<?php


namespace App\Handlers;


use App\Ineractors\SomeApi\Results\SomeApiIsSubscribedResults;
use App\MyLogger;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;

class SomeApiInteractor
{

    function getChatLinkForCoordinatesTest()
    {
        $tstCoordinates = '44.936877,34.12343';
        dd($this->getChatLinkForCoordinates($tstCoordinates));
    }

    function getChatLinkForCoordinates($coordinates)
    {
        /*
         * 200 - уже существует
         * 501 - еще нет
         * все остальные ошибка
         */
//        return [SomeApiIsSubscribedResults::$CHAT_FOR_COORDINATES_NOT_EXISTS,'some address from interactor','some link from interactor'];
        $tstUrl = 'https://api.covidarnost.ru/chat/getChat/?data={"coords": "' . $coordinates . '"}';
        $gluszzClient = new Client([
            'base_uri' => $tstUrl,
        ]);
        try {
            MyLogger::LOG('start getChatLinkForCoordinates $tstUrl ' . MyLogger::JSON_ENCODE($tstUrl));
            $get = $gluszzClient->post('');
            //После ниже выполянется в случае успеха, если будет ошибка при запросе, то ниже код не выполниться, выполниться catch
            $resultCode = $get->getStatusCode();
            MyLogger::LOG('complete getChatLinkForCoordinates $resultCode ' . MyLogger::JSON_ENCODE($resultCode));

            if ($resultCode == 200) {
                $resultBodyString = $get->getBody()->getContents();
                MyLogger::LOG('getChatLinkForCoordinates answer ' . $resultBodyString);
                $resultBodyObj = json_decode($resultBodyString);
//                dd($resultBodyObj);
                return [SomeApiIsSubscribedResults::$CHAT_FOR_COORDINATES_EXISTS,$resultBodyObj->address,$resultBodyObj->url];
            } else {
                return [SomeApiIsSubscribedResults::$UNKNOWN_ERROR];
            }
        } catch (ServerException $ex) {
//            dd($ex->getCode());
            switch ($ex->getCode()) {
                case 501:
                    return [SomeApiIsSubscribedResults::$CHAT_FOR_COORDINATES_NOT_EXISTS];
                    break;
                default:
                    return [SomeApiIsSubscribedResults::$UNKNOWN_ERROR];
                    break;
            }
        }
    }

    function saveChatLinkForCoordinates($coordinates, $link)
    {
//        $tstUrl = 'https://api.covidarnost.ru/chat/createChat/?data={"coords": "' . $coordinates . '","url":"' . $link . '"}';
//        Log::debug('start save $coordinates ' . $coordinates . ' $link ' . $link . ' $tstUrl ' . json_encode($tstUrl));
//        $gluszzClient = new Client([
//            'base_uri' => $tstUrl,
//        ]);
//        $get = $gluszzClient->post('');
//        Log::debug('saved ');
//        $resultCode = $get->getStatusCode();
        return [SomeApiIsSubscribedResults::$CHAT_LINK_SAVE_SUCCESS];
    }

    public function isSubscribed($user)
    {
        //TODO: make request to api and handle result
        return [SomeApiIsSubscribedResults::$NOT_SUBSCRIBED];
    }

    public function subscribe($user)
    {
        return [SomeApiIsSubscribedResults::$SUBSCRIBE_ALREADY_SUBBED];
    }

    public function unSubscribe($user)
    {
        return [SomeApiIsSubscribedResults::$UN_SUBSCRIBE_SUCCESS];
    }

    public function saveUser()
    {
        return [SomeApiIsSubscribedResults::$SAVE_USER_SUCCESS];
    }

    public function verifyAddress($addressInput)
    {
        return [SomeApiIsSubscribedResults::$VERIFY_ADDRESS_SUCCESS, 'some address from interactor', '44.936877,34.12343'];
    }
}
