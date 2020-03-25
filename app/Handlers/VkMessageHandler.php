<?php


namespace App\Handlers;


use App\Managers\PossibleStatesManager;
use App\Managers\StatesManager;
use App\Managers\TriggerWordsManager;
use App\Messenger\VkMessenger;
use App\MyLogger;
use App\State;
use App\TriggerWord;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
     * VkMessageHandler constructor.
     * @param StatesHandler $statesHandler
     * @param VkMessenger $vkMessenger
     * @param StatesManager $statesManager
     * @param PossibleStatesManager $possibleStatesManager
     * @param TriggerWordsManager $triggerWordsManager
     */
    public function __construct(StatesHandler $statesHandler, VkMessenger $vkMessenger, StatesManager $statesManager, PossibleStatesManager $possibleStatesManager, TriggerWordsManager $triggerWordsManager)
    {
        $this->statesHandler = $statesHandler;
        $this->vkMessenger = $vkMessenger;
        $this->statesManager = $statesManager;
        $this->possibleStatesManager = $possibleStatesManager;
        $this->triggerWordsManager = $triggerWordsManager;
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

        if ($this->statesHandler->isStartTriggerWord($message['text'])) {
            $this->moveUserToState($foundUser, 'main_screen');
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
                    $this->handleUserMessage($foundUser, $message);
                    break;
            }
        }
    }

    function handleUserMessage($user, $receivedMessage)
    {
        $receivedMessage = $receivedMessage['text'];
        MyLogger::LOG('handleUserMessage $user' . MyLogger::JSON_ENCODE($user) . ' $receivedMessage ' . MyLogger::JSON_ENCODE($receivedMessage));
        $triggerWords = $this->generateTriggerWordsForState($user->state);
        $nexState = $triggerWords->where('word', $receivedMessage);
        MyLogger::LOG('$triggerWords ' . MyLogger::JSON_ENCODE($triggerWords) . ' $nexState. ' . MyLogger::JSON_ENCODE($nexState));
        if ($nexState->isNotEmpty()) {
            $this->moveUserToState($user, $nexState->first()->state);
        } else {
            MyLogger::LOG('handleUserMessage No next state trigger word $user' . MyLogger::JSON_ENCODE($user) . ' $receivedMessage ' . MyLogger::JSON_ENCODE($receivedMessage));
            $this->vkMessenger->sendMessageToUserWithKeyboard($user, __('messages.unknown_command'), $this->generateTriggerWordsForState($user->state));
        }
    }

    function handleGeoMessage($user, $geo)
    {
        MyLogger::LOG('handleGeoMessage $user' . MyLogger::JSON_ENCODE($user) . ' $geo ' . MyLogger::JSON_ENCODE($geo));
        $coordinates = $geo['coordinates']['latitude'] . ',' . $geo['coordinates']['longitude'];
        $user->coordinates = $coordinates;
        $user->save();
        $userState = $user->state;
        $apiInteractor = new SomeApiInteractor();
        $chatLink = $apiInteractor->getChatLinkForCoordinates($coordinates);
        MyLogger::LOG('handleGeoMessage $chatLink' . MyLogger::JSON_ENCODE($chatLink));
        if ($chatLink) {
            $this->moveUserToState($user, 5, $chatLink);
        } else {
            $this->moveUserToState($user, 6);
        }
    }

    private function saveChatLink($coordinates, $link)
    {
        $apiInteractor = new SomeApiInteractor();
        $apiInteractor->saveChatLinkForCoordinates($coordinates, $link);
    }

    private function moveUserToState($user, $newState, $extraMessage = '', $extraStartMessage = '')
    {
        MyLogger::LOG('moveUserToState $user' . MyLogger::JSON_ENCODE($user) . ' $newState ' . MyLogger::JSON_ENCODE($newState));
        $user->state = $newState;
        $newState = $this->statesManager->getStates()->where('state', '=', $newState)->get()->first();
        if ($this->vkMessenger->sendMessageToUserWithKeyboard($user, $extraStartMessage . ' ' . $newState->message . ' ' . $extraMessage, $this->generateTriggerWordsForState($newState))) {
            $user->save();
        };
    }

    private function generateTriggerWordsForState($state): Collection
    {
        $userPossibleStates = $this->possibleStatesManager->getPossibleStates()
            ->where('current_state', '=', $state)
            ->get('possible_state')
            ->map(function ($item, $key) {
                return $item->possible_state;
            })
            ->toArray();
        $triggerWords = $this->triggerWordsManager->getTriggerWords()
            ->whereIn('state', $userPossibleStates)
            ->get()
            ->filter(function ($value, $key) {
                return $value->id != 1;
            });
        dd($userPossibleStates, $triggerWords);

        return $triggerWords;
    }

}
