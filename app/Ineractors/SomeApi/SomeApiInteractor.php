<?php


namespace App\Handlers;


use App\Ineractors\SomeApi\Results\SomeApiIsSubscribedResults;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;

class SomeApiInteractor
{
    function getChatLinkForCoordinates($coordinates)
    {
        return [SomeApiIsSubscribedResults::$CHAT_FOR_COORDINATES_NOT_EXISTS,'some address from interactor','some link from interactor'];
//        $tstUrl = 'https://api.covidarnost.ru/chat/getChat/?data={"coords": "' . $coordinates . '"}';
//        $gluszzClient = new Client([
//            'base_uri' => $tstUrl,
//        ]);
//        try {
//            Log::debug('start $tstUrl ' . json_encode($tstUrl));
//            $get = $gluszzClient->post('');
//            $resultCode = $get->getStatusCode();
//            Log::debug('complete $resultCode ' . json_encode($resultCode));
//
//            if ($resultCode == 200) {
//                $resultBodyString = $get->getBody()->getContents();
//                Log::debug('getChatLinkForCoordinates answer ' . $resultBodyString);
//                $resultBodyObj = json_decode($resultBodyString);
//                return $resultBodyObj->url;
//            } else {
//                return null;
//            }
//        } catch (ServerException $ex) {
//            dd($ex);
//            Log::debug('catch catch ');
//            return null;
//        }
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

    public function saveUser(){
        return [SomeApiIsSubscribedResults::$SAVE_USER_SUCCESS];
    }

    public function verifyAddress($addressInput){
        return [SomeApiIsSubscribedResults::$VERIFY_ADDRESS_SUCCESS,'some address from interactor','44.936877,34.12343'];
    }
}
