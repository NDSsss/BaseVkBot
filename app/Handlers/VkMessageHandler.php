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
use Dotenv\Regex\Regex;
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
                case StatesNamesEnum::$HELP:
                    if (key_exists('geo', $message)) {
                        $this->handleGeoMessage($foundUser, $message['geo']);
                        break;
                    }
                    $this->handleUserMessage($message);
                    break;
                case StatesNamesEnum::$HELP_CHAT_WAIT_LINK:
                    if (filter_var($message['text'], FILTER_VALIDATE_URL)) {
                        $this->saveChatLink($foundUser->coordinates, $message['text']);
                    } else {
                        $this->moveUserToState(StatesNamesEnum::$HELP_CHAT_WAIT_LINK_VALIDATION_ERROR);
                    }
                    break;
                case StatesNamesEnum::$HELP_USER_ADDRESS_INPUT:
                    if (key_exists('geo', $message)) {
                        $this->handleGeoMessage($foundUser, $message['geo']);
                        break;
                    } else {
                        $this->handleTextAddressInput($message['text']);
                    }
                    break;
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
            $this->vkMessenger->sendMessageToUserWithKeyboard(
                $this->user,
                __('messages.unknown_command'),
                $this->generateTriggerWordsForState($this->user->state),
                $this->user->state != StatesNamesEnum::$MAIN_SCREEN
            );
        }
    }

    function handleGeoMessage($user, $geo)
    {
        MyLogger::LOG('handleGeoMessage $user' . MyLogger::JSON_ENCODE($user) . ' $geo ' . MyLogger::JSON_ENCODE($geo));
        $coordinates = $geo['coordinates']['latitude'] . ',' . $geo['coordinates']['longitude'];
        if ($this->handleCommonErrors($this->apiInteractor->saveUser())[0] != SomeApiIsSubscribedResults::$SAVE_USER_SUCCESS) {
            return null;
        }
        $user->coordinates = $coordinates;
        $user->save();
        $userState = $user->state;
        $chatLinkResult = $this->handleCommonErrors($this->apiInteractor->getChatLinkForCoordinates($coordinates));
        switch ($chatLinkResult[0]) {
            case SomeApiIsSubscribedResults::$CHAT_FOR_COORDINATES_EXISTS:
                $this->moveUserToState(StatesNamesEnum::$HELP_CHAT_FOUND, ['address' => $chatLinkResult[1], 'url' => $chatLinkResult[2]]);
                break;
            case SomeApiIsSubscribedResults::$CHAT_FOR_COORDINATES_NOT_EXISTS:
                $this->moveUserToState(StatesNamesEnum::$HELP_CHAT_NOT_FOUND, ['address' => $chatLinkResult[1]]);
                break;
        }
    }

    private function handleTextAddressInput($addressInput)
    {
        $result = $this->handleCommonErrors($this->apiInteractor->verifyAddress($addressInput));
        switch ($result[0]) {
            case SomeApiIsSubscribedResults::$VERIFY_ADDRESS_SUCCESS:
                $this->user->coordinates = $result[2];
                $this->user->save();
                $this->moveUserToState(StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_SUCCESS, ['address' => $result[1]]);
                break;
            case SomeApiIsSubscribedResults::$VERIFY_ADDRESS_FAIL:
                $this->moveUserToState(StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_FAIL, ['address' => $addressInput]);
                break;
        }
    }

    private function saveChatLink($coordinates, $link)
    {
        $result = $this->handleCommonErrors($this->apiInteractor->saveChatLinkForCoordinates($coordinates, $link));
        switch ($result[0]) {
            case SomeApiIsSubscribedResults::$CHAT_LINK_SAVE_SUCCESS:
                $this->moveUserToState(StatesNamesEnum::$HELP_CREATE_CHAT_SUCCESS);
                break;
            default:
                $this->handleInnerError();
                break;
        }
    }

    private function moveUserToState($newState, $messagesArgs = [])
    {
        MyLogger::LOG('moveUserToState $user' . MyLogger::JSON_ENCODE($this->user) . ' $newState ' . MyLogger::JSON_ENCODE($newState));
        $newStateFull = $this->statesManager->getStates()->where('state', '=', $newState)->first();
        $stateMessages = $newStateFull['state_messages'];
        $stateMessagesCount = count($newStateFull['state_messages']);
        if ($stateMessagesCount > 1) {
            for ($i = 0; $i < $stateMessagesCount - 1; $i++) {
                $this->vkMessenger->sendMessageToUser($this->user, __('state_messages.' . $newStateFull['state_messages'][$i], $messagesArgs));
            }
            $messageResToSend = $newStateFull['state_messages'][$stateMessagesCount - 1];
        } else {
            $messageResToSend = $newStateFull['state_messages'][0];
        }
        switch ($newStateFull['state_type']) {
            case StateTypesEnum::$SEND_MESSAGE_AND_CHANGE_STATE:
                if ($this->vkMessenger->sendMessageToUserWithKeyboard(
                    $this->user,
                    __('state_messages.' . $messageResToSend, $messagesArgs),
                    $this->generateTriggerWordsForState($newState),
                    $newState != StatesNamesEnum::$MAIN_SCREEN)
                ) {
                    $this->user->state = $newState;
                    $this->user->save();
                };
                break;
            case StateTypesEnum::$SEND_MESSAGE_AND_GO_TO_MAIN:
                if ($this->vkMessenger->sendMessageToUserWithKeyboard(
                    $this->user,
                    __('state_messages.' . $messageResToSend, $messagesArgs),
                    $this->generateTriggerWordsForState(StatesNamesEnum::$MAIN_SCREEN),
                    false)
                ) {
                    $this->user->state = 'main_screen';
                    $this->user->save();
                };
                break;
            case StateTypesEnum::$JUST_SEND_MESSAGE:
                if ($this->vkMessenger->sendMessageToUser($this->user, __('state_messages.' . $messageResToSend, $messagesArgs))) {
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
            case StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_USER_ACCEPT:
                $this->handleUserAcceptAddressAction();
                break;
            default:
                $this->handleInnerError();
                break;
        }
    }

    private function subscribeInitIsSubscribed()
    {
        $result = $this->handleCommonErrors($this->apiInteractor->isSubscribed($this->user))[0];
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
        $result = $this->handleCommonErrors($this->apiInteractor->subscribe($this->user))[0];
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
        $result = $this->handleCommonErrors($this->apiInteractor->unSubscribe($this->user))[0];
        switch ($result) {
            case SomeApiIsSubscribedResults::$UN_SUBSCRIBE_SUCCESS:
                $this->moveUserToState(StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_SUCCESS);
                break;
            default:
                $this->moveUserToState(StatesNamesEnum::$REQUEST_ERROR);
                break;
        }
    }

    private function handleUserAcceptAddressAction(){
        $savedCoordinates = explode(',',$this->user->coordinates);
        $tmpGeo = [];
        $tmpGeo['coordinates']['latitude']=$savedCoordinates[0];
        $tmpGeo['coordinates']['longitude']=$savedCoordinates[1];
        $this->handleGeoMessage($this->user,$tmpGeo);
    }

    private function handleCommonErrors($result)
    {
        if ($result[0] == SomeApiIsSubscribedResults::$UNKNOWN_ERROR) {
            $this->moveUserToState(StatesNamesEnum::$REQUEST_ERROR);
        }
        return $result;
    }

    private function handleInnerError()
    {
        $this->moveUserToState(StatesNamesEnum::$REQUEST_ERROR);
    }


}
