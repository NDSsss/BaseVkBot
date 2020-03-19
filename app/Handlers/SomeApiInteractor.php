<?php


namespace App\Handlers;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Log;

class SomeApiInteractor
{
    function getChatLinkForCoordinates($coordinates){

        $gluszzClient = new Client([
            'base_uri' => 'https://api.covidarnost.ru/chat/getChat/',
        ]);
        $query = [
            'query' => [
                'data' => '{"coords": "'.$coordinates.'"}'
            ]
        ];
        try {
            $get = $gluszzClient->post('', $query);
            $resultCode = $get->getStatusCode();

            if($resultCode == 200){
                $resultBodyString = $get->getBody()->getContents();
                Log::debug('getChatLinkForCoordinates answer '.$resultBodyString);
                $resultBodyObj =json_decode($resultBodyString);
                return $resultBodyObj->url;
            } else {
                return null;
            }
        } catch (ServerException $ex){
            return null;
        }
    }

    function saveChatLinkForCoordinates($coordinates, $link){
        $gluszzClient = new Client([
            'base_uri' => 'https://api.covidarnost.ru/chat/createChat/',
        ]);
        $query = [
            'query' => [
                'data' => '{"coords": "'.$coordinates.'","url":"'.$link.'"}'
            ]
        ];
        $get = $gluszzClient->post('', $query);
        $resultCode = $get->getStatusCode();
    }
}
