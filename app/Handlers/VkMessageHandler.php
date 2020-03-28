<?php


namespace App\Handlers;


use App\Enums\StatesNamesEnum;
use App\Enums\StateTypesEnum;
use App\Ineractors\SomeApi\Results\SomeApiIsSubscribedResults;
use App\Managers\PossibleStatesManager;
use App\Managers\StatesManager;
use App\Managers\TriggerWordsManager;
use App\Messenger\VkMessenger;
use App\MyLogger;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class VkMessageHandler
{

    /**
     * @var StatesHandler
     */
    private $statesHandler;
    /**
     * @var VkMessenger
     */
    private $vkMessenger;
    /**
     * @var StatesManager
     */
    private $statesManager;
    /**
     * @var PossibleStatesManager
     */
    private $possibleStatesManager;
    /**
     * @var TriggerWordsManager
     */
    private $triggerWordsManager;

    /**
     * @var SomeApiInteractor
     */
    private $apiInteractor;

    /**
     * @var User
     */
    private $user;

    /**
     * VkMessageHandler constructor.
     * @param StatesHandler $statesHandler
     * @param VkMessenger $vkMessenger
     * @param StatesManager $statesManager
     * @param PossibleStatesManager $possibleStatesManager
     * @param TriggerWordsManager $triggerWordsManager
     * @param SomeApiInteractor $apiInteractor
     */
    public function __construct(
        StatesHandler $statesHandler,
        VkMessenger $vkMessenger,
        StatesManager $statesManager,
        PossibleStatesManager $possibleStatesManager,
        TriggerWordsManager $triggerWordsManager,
        SomeApiInteractor $apiInteractor
    )
    {
        $this->statesHandler = $statesHandler;
        $this->vkMessenger = $vkMessenger;
        $this->statesManager = $statesManager;
        $this->possibleStatesManager = $possibleStatesManager;
        $this->triggerWordsManager = $triggerWordsManager;
        $this->apiInteractor = $apiInteractor;
    }


    function handleMessageRequest(Request $request)
    {
        MyLogger::LOG('handleMessageRequest' . MyLogger::JSON_ENCODE($request));
        $object = $request->input('object');
        $vkUserId = $object['message']['from_id'];
        $foundUser = User::query()->where('vk_user_id', $vkUserId)->get()->first();
        $message = $object['message'];
        if ($foundUser == null) {
            $newUser = new User();
            $newUser->vk_user_id = $vkUserId;
            if ($newUser->save()) {
                $foundUser = User::query()->where('vk_user_id', $vkUserId)->get()->first();
            }
        }
        MyLogger::LOG('$foundUser ' . MyLogger::JSON_ENCODE($foundUser));
        $this->user = $foundUser;
        if ($this->statesHandler->isStartTriggerWord($message['text'])) {
            $this->moveUserToState(StatesNamesEnum::$MAIN_SCREEN);
        } else {
            switch ($foundUser->state) {
                //TODO: handle location example
//                case 3:
//                    if (key_exists('geo', $message)) {
//                        $this->handleGeoMessage($foundUser, $message['geo']);
//                        break;
//                    }
//                    $this->handleUserMessage($foundUser, $message);
//                    break;
                //TODO: save link example
//                case 7:
//                    if ($message['text'] != 'Начало') {
//                        $this->saveChatLink($foundUser->coordinates, $message['text']);
//                    }
//                    $this->moveUserToState($foundUser, 2, '', __('messages.chat_linked', ['link' => $message['text']]));
//                    break;
                default:
                    $this->handleUserMessage($message);
                    break;
            }
        }
    }

    function handleUserMessage($receivedMessage)
    {
        $receivedMessage = $receivedMessage['text'];
        MyLogger::LOG('handleUserMessage $user' . MyLogger::JSON_ENCODE($this->user) . ' $receivedMessage ' . MyLogger::JSON_ENCODE($receivedMessage));
        $triggerWords = $this->generateTriggerWordsForState($this->user->state);
        $nexStates = $triggerWords->where('word', $receivedMessage);
        MyLogger::LOG('$triggerWords ' . MyLogger::JSON_ENCODE($triggerWords) . ' $nexState. ' . MyLogger::JSON_ENCODE($nexStates));
        if ($nexStates->isNotEmpty()) {
            $this->moveUserToState($nexStates->first()['state']);
        } else {
            MyLogger::LOG('handleUserMessage No next state trigger word $user' . MyLogger::JSON_ENCODE($this->user) . ' $receivedMessage ' . MyLogger::JSON_ENCODE($receivedMessage));
            $this->vkMessenger->sendMessageToUserWithKeyboard($this->user, __('messages.unknown_command'), $this->generateTriggerWordsForState($this->user->state));
        }
    }

    function handleGeoMessage($user, $geo)
    {
        MyLogger::LOG('handleGeoMessage $user' . MyLogger::JSON_ENCODE($user) . ' $geo ' . MyLogger::JSON_ENCODE($geo));
        $coordinates = $geo['coordinates']['latitude'] . ',' . $geo['coordinates']['longitude'];
        $user->coordinates = $coordinates;
        $user->save();
        $userState = $user->state;
        $chatLink = $this->apiInteractor->getChatLinkForCoordinates($coordinates);
        MyLogger::LOG('handleGeoMessage $chatLink' . MyLogger::JSON_ENCODE($chatLink));
        if ($chatLink) {
            //FIXME: change link handling
//            $this->moveUserToState($user, 5, $chatLink);
        } else {
//            $this->moveUserToState($user, 6);
        }
    }

    private function saveChatLink($coordinates, $link)
    {
        $this->apiInteractor->saveChatLinkForCoordinates($coordinates, $link);
    }

    private function moveUserToState($newState)
    {
        MyLogger::LOG('moveUserToState $user' . MyLogger::JSON_ENCODE($this->user) . ' $newState ' . MyLogger::JSON_ENCODE($newState));
        $newStateFull = $this->statesManager->getStates()->where('state', '=', $newState)->first();
        $stateMessages = $newStateFull['state_messages'];
        $stateMessagesCount = count($newStateFull['state_messages']);
        if ($stateMessagesCount > 1) {
            //TODO: send multiple messages
            for ($i = 0; $i < $stateMessagesCount - 1; $i++) {
                $this->vkMessenger->sendMessageToUser($this->user, __('state_messages.' . $newStateFull['state_messages'][$i]));
            }
            $messageResToSend = $newStateFull['state_messages'][$stateMessagesCount - 1];
        } else {
            $messageResToSend = $newStateFull['state_messages'][0];
        }
        switch ($newStateFull['state_type']) {
            case StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE:
                if ($this->vkMessenger->sendMessageToUserWithKeyboard(
                    $this->user,
                    __('state_messages.' . $messageResToSend),
                    $this->generateTriggerWordsForState($newState))
                ) {
                    $this->user->state = $newState;
                    $this->user->save();
                };
                break;
            case StateTypesEnum::$SEND_MESSAGE_AND_GO_TO_MAIN:
                if ($this->vkMessenger->sendMessageToUserWithKeyboard(
                    $this->user,
                    __('state_messages.' . $messageResToSend),
                    $this->generateTriggerWordsForState('main_screen'))
                ) {
                    $this->user->state = 'main_screen';
                    $this->user->save();
                };
                break;
            case StateTypesEnum::$JUST_SEND_MESSAGE:
                if ($this->vkMessenger->sendMessageToUser($this->user, __('state_messages.' . $messageResToSend))) {
                    $this->user->save();
                };
                break;
            case StateTypesEnum::$MAKE_SOME_ACTIONS:
                $this->handleMakeSomeActionState($newStateFull);
                break;
            default:
                $this->handleInnerError();
                break;
        }
//            if ($this->vkMessenger->sendMessageToUserWithKeyboard(
//                $user,
//                __('state_messages.' . $newStateFull['state_messages'][0]),
//                $this->generateTriggerWordsForState($newState))
//            ) {
//                $user->save();
//            };
    }

    private function generateTriggerWordsForState($state): Collection
    {
        $userPossibleStates = $this->possibleStatesManager->getPossibleStates()
            ->where('current_state', '=', $state)
            ->map(function ($item, $key) {
                return $item['possible_state'];
            })
            ->toArray();
        $triggerWords = $this->triggerWordsManager->getTriggerWords()
            ->whereIn('state', $userPossibleStates);
//        dd($state,$userPossibleStates,$triggerWords);
        return $triggerWords;
    }

    private function handleMakeSomeActionState($state)
    {
        switch ($state['state']) {
            case StatesNamesEnum::$SUBSCRIBE_INIT:
                $this->subscribeInitIsSubscribed();
                break;
            case StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_REQUEST:
                $this->subscribeInitSubscribe();
                break;
            case StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_REQUEST:
                $this->subscribeInitUnSubscribe();
                break;
            default:
                $this->handleInnerError();
                break;
        }
    }

    private function subscribeInitIsSubscribed()
    {
        $result = $this->handleCommonErrors($this->apiInteractor->isSubscribed($this->user));
        switch ($result) {
            case SomeApiIsSubscribedResults::$SUBSCRIBED:
                $this->moveUserToState(StatesNamesEnum::$SUBSCRIBE_INIT_ALREADY_SUB);
                break;
            case SomeApiIsSubscribedResults::$NOT_SUBSCRIBED:
                $this->moveUserToState(StatesNamesEnum::$SUBSCRIBE_INIT_NOT_SUBBED);
                break;
            default:
                $this->moveUserToState(StatesNamesEnum::$REQUEST_ERROR);
                break;
        }
    }

    private function subscribeInitSubscribe()
    {
        $result = $this->handleCommonErrors($this->apiInteractor->subscribe($this->user));
        switch ($result) {
            case SomeApiIsSubscribedResults::$SUBSCRIBE_ALREADY_SUBBED:
                $this->moveUserToState(StatesNamesEnum::$SUBSCRIBE_INIT_ALREADY_SUB);
                break;
            case SomeApiIsSubscribedResults::$SUBSCRIBE_SUCCESS:
                $this->moveUserToState(StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_SUCCESS);
                break;
            default:
                $this->moveUserToState(StatesNamesEnum::$REQUEST_ERROR);
                break;
        }
    }

    private function subscribeInitUnSubscribe()
    {
        $result = $this->handleCommonErrors($this->apiInteractor->unSubscribe($this->user));
        switch ($result) {
            case SomeApiIsSubscribedResults::$UN_SUBSCRIBE_SUCCESS:
                $this->moveUserToState(StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_SUCCESS);
                break;
            default:
                $this->moveUserToState(StatesNamesEnum::$REQUEST_ERROR);
                break;
        }
    }

    private function handleCommonErrors($result)
    {
        if ($result == SomeApiIsSubscribedResults::$UNKNOWN_ERROR) {
            $this->moveUserToState(StatesNamesEnum::$REQUEST_ERROR);
        }
        return $result;
    }

    private function handleInnerError()
    {
        $this->moveUserToState(StatesNamesEnum::$REQUEST_ERROR);
    }

}
