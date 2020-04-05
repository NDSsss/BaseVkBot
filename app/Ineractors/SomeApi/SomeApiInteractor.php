<?php


namespace App\Handlers;


use App\Ineractors\SomeApi\Results\SomeApiIsSubscribedResults;
use App\MyLogger;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\RequestInterface;

class SomeApiInteractor
{

    public static $SOCIAL_NETWORK = 'vk';

    /**
     * @var Client
     */
    private $client;

    /**
     * SomeApiInteractor constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.covidarnost.ru/v3/',
            'http_errors' => false,
        ]);
    }


    function getChatLinkForCoordinatesTest()
    {
        $lat = 12.1;
        $lng = 12.1;
        dd($this->getChatLinkForCoordinates($lat, $lng));
    }

    function getChatLinkForCoordinates($lat, $lng)
    {
        /*
         * 200 - список чатов
         * 501 - чатов нет
         * все остальные ошибка
         */
        $configWithQuery = [
            RequestOptions::QUERY => [
                'lat' => $lat,
                'lng' => $lng,
            ]
        ];
        $response = $this->client->request('POST', 'Chat/getNear', $configWithQuery);
        $responseContent = $response->getBody()->getContents();
        MyLogger::LOG('API Chat/getNear query=' . MyLogger::JSON_ENCODE($configWithQuery) . ' CODE=' . $response->getStatusCode() . ' response= ' . $responseContent);

        switch ($response->getStatusCode()) {
            case 200:
                $resultObj = json_decode($responseContent);
                return [SomeApiIsSubscribedResults::$CHAT_FOR_COORDINATES_EXISTS, $resultObj];
            case 501:
                return [SomeApiIsSubscribedResults::$CHAT_FOR_COORDINATES_NOT_EXISTS];
            default:
                return [SomeApiIsSubscribedResults::$UNKNOWN_ERROR];
        }
    }

    function saveChatLinkForCoordinatesTest()
    {
        dd($this->saveChatLinkForCoordinates(12, 12, 'http://www.google.com2', 12345));
    }

    function saveChatLinkForCoordinates($lat, $lng, $link, $userId)
    {
        $configWithQuery = [
            RequestOptions::QUERY => [
                'lat' => $lat,
                'lng' => $lng,
                'url' => $link,
                'user_id' => $userId,
                'social_network' => SomeApiInteractor::$SOCIAL_NETWORK,
            ]
        ];
        $response = $this->client->request('POST', 'Chat/createChat', $configWithQuery);
        $responseContent = $response->getBody()->getContents();
        MyLogger::LOG('API Chat/createChat query=' . MyLogger::JSON_ENCODE($configWithQuery) . ' CODE=' . $response->getStatusCode() . ' response= ' . $responseContent);

        switch ($response->getStatusCode()) {
            case 200:
                return [SomeApiIsSubscribedResults::$CHAT_LINK_SAVE_SUCCESS,];
            case 409:
                return [SomeApiIsSubscribedResults::$CHAT_LINK_SAVE_DUPLICATE];
            default:
                return [SomeApiIsSubscribedResults::$UNKNOWN_ERROR];
        }
    }

    public function isSubscribedTest()
    {
        $tstId = 12345;
        dd($this->isSubscribed($tstId));
    }

    public function isSubscribed($userId)
    {
        $configWithQuery = [
            RequestOptions::QUERY => [
                'user_id' => $userId,
                'social_network' => SomeApiInteractor::$SOCIAL_NETWORK,
            ]
        ];
        $response = $this->client->request('POST', 'Users/isSubscribed', $configWithQuery);
        $responseContent = $response->getBody()->getContents();
        MyLogger::LOG('API Users/isSubscribed query=' . MyLogger::JSON_ENCODE($configWithQuery) . ' CODE=' . $response->getStatusCode() . ' response= ' . $responseContent);
        switch ($response->getStatusCode()) {
            case 200:
                switch ($responseContent) {
                    case 'true':
                        return [SomeApiIsSubscribedResults::$SUBSCRIBED];
                        break;
                    case 'false':
                        return [SomeApiIsSubscribedResults::$NOT_SUBSCRIBED];
                        break;
                    default:
                        return [SomeApiIsSubscribedResults::$UNKNOWN_ERROR];

                }
            case 204:
                return [SomeApiIsSubscribedResults::$NO_USER_FOUND];
            default:
                return [SomeApiIsSubscribedResults::$UNKNOWN_ERROR];
        }
    }

    public function subscribe($userId)
    {
        $configWithQuery = [
            RequestOptions::QUERY => [
                'user_id' => $userId,
                'social_network' => SomeApiInteractor::$SOCIAL_NETWORK,
                'unsubscribe' => 'false',
            ]
        ];
        $response = $this->client->request('POST', 'Users/subscribeUser', $configWithQuery);
        $responseContent = $response->getBody()->getContents();
        MyLogger::LOG('API Users/subscribeUser query=' . MyLogger::JSON_ENCODE($configWithQuery) . ' CODE=' . $response->getStatusCode() . ' response= ' . $responseContent);
        switch ($response->getStatusCode()) {
            case 200:
                return [SomeApiIsSubscribedResults::$SUBSCRIBE_SUCCESS];
            case 409:
                return [SomeApiIsSubscribedResults::$SUBSCRIBE_ALREADY_SUBBED];
            default:
                return [SomeApiIsSubscribedResults::$UNKNOWN_ERROR];
        }
    }

    public function unSubscribe($userId)
    {
        $configWithQuery = [
            RequestOptions::QUERY => [
                'user_id' => $userId,
                'social_network' => SomeApiInteractor::$SOCIAL_NETWORK,
                'unsubscribe' => 'true',
            ]
        ];
        $response = $this->client->request('POST', 'Users/subscribeUser', $configWithQuery);
        $responseContent = $response->getBody()->getContents();
        MyLogger::LOG('API Users/subscribeUser query=' . MyLogger::JSON_ENCODE($configWithQuery) . ' CODE=' . $response->getStatusCode() . ' response= ' . $responseContent);
        switch ($response->getStatusCode()) {
            case 200:
                return [SomeApiIsSubscribedResults::$UN_SUBSCRIBE_SUCCESS];
            default:
                return [SomeApiIsSubscribedResults::$UNKNOWN_ERROR];
        }
    }

    public function saveUserTest()
    {
        $id = '12345';
        dd($this->saveUser($id));
    }

    public function saveUser($userId)
    {
        $configWithQuery = [
            RequestOptions::QUERY => [
                'user_id' => $userId,
                'social_network' => SomeApiInteractor::$SOCIAL_NETWORK,
            ]
        ];
        $response = $this->client->request('POST', 'Users/saveUser', $configWithQuery);
        $responseContent = $response->getBody()->getContents();
        MyLogger::LOG('API Users/saveUser query=' . MyLogger::JSON_ENCODE($configWithQuery) . ' CODE=' . $response->getStatusCode() . ' response= ' . $responseContent);

        switch ($response->getStatusCode()) {
            case 200:
                return [SomeApiIsSubscribedResults::$SAVE_USER_SUCCESS,];
            default:
                return [SomeApiIsSubscribedResults::$UNKNOWN_ERROR];
        }
    }

    public function verifyAddressTest()
    {
        $tstAddress = 'г.Симферополь ул.Дарвина 9';
        dd($this->verifyAddress($tstAddress));
    }

    public function verifyAddress($addressInput)
    {
        $configWithQuery = [
            RequestOptions::QUERY => [
                'address' => $addressInput
            ]
        ];
        $response = $this->client->request('POST', 'Chat/verifyAddress', $configWithQuery);
        switch ($response->getStatusCode()) {
            case 200:
                $responseObj = json_decode($response->getBody()->getContents());
                return [SomeApiIsSubscribedResults::$VERIFY_ADDRESS_SUCCESS, $responseObj->full_address, $responseObj->lat, $responseObj->lng];
            case 204:
                return [SomeApiIsSubscribedResults::$VERIFY_ADDRESS_FAIL,];
            default:
                return [SomeApiIsSubscribedResults::$UNKNOWN_ERROR];
        }
//        return [SomeApiIsSubscribedResults::$VERIFY_ADDRESS_SUCCESS, 'some address from interactor', '44.936877,34.12343'];
    }
}
