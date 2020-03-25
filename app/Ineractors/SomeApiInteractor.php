<?php


namespace App\Handlers;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;

class SomeApiInteractor
{
    function getChatLinkForCoordinates($coordinates)
    {
        $tstUrl = 'https://api.covidarnost.ru/chat/getChat/?data={"coords": "' . $coordinates . '"}';
        $gluszzClient = new Client([
            'base_uri' => $tstUrl,
        ]);
        try {
            Log::debug('start $tstUrl ' . json_encode($tstUrl));
            $get = $gluszzClient->post('');
            $resultCode = $get->getStatusCode();
            Log::debug('complete $resultCode ' . json_encode($resultCode));

            if ($resultCode == 200) {
                $resultBodyString = $get->getBody()->getContents();
                Log::debug('getChatLinkForCoordinates answer ' . $resultBodyString);
                $resultBodyObj = json_decode($resultBodyString);
                return $resultBodyObj->url;
            } else {
                return null;
            }
        } catch (ServerException $ex) {
            Log::debug('catch catch ');
            return null;
        }
    }

    function saveChatLinkForCoordinates($coordinates, $link)
    {
        $tstUrl = 'https://api.covidarnost.ru/chat/createChat/?data={"coords": "' . $coordinates . '","url":"' . $link . '"}';
        Log::debug('start save $coordinates ' . $coordinates . ' $link ' . $link . ' $tstUrl ' . json_encode($tstUrl));
        $gluszzClient = new Client([
            'base_uri' => $tstUrl,
        ]);
        $get = $gluszzClient->post('');
        Log::debug('saved ');
        $resultCode = $get->getStatusCode();
    }
}
