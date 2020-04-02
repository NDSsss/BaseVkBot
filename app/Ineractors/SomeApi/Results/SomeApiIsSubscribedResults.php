<?php


namespace App\Ineractors\SomeApi\Results;


class SomeApiIsSubscribedResults
{
    public static $UNKNOWN_ERROR = 'UNKNOWN_ERROR';

    public static $SUBSCRIBED = '$SUBSCRIBED';
    public static $NOT_SUBSCRIBED = '$NOT_SUBSCRIBED';

    public static $UN_SUBSCRIBE_SUCCESS ='$UN_SUBSCRIBE_SUCCESS';

    public static $SUBSCRIBE_SUCCESS ='$SUBSCRIBE_SUCCESS';
    public static $SUBSCRIBE_ALREADY_SUBBED ='$SUBSCRIBE_ALREADY_SUBBED';

    public static $SAVE_USER_SUCCESS = '$SAVE_USER_SUCCESS';

    public static $CHAT_FOR_COORDINATES_EXISTS = '$CHAT_FOR_COORDINATES_EXISTS';
    public static $CHAT_FOR_COORDINATES_NOT_EXISTS = '$CHAT_FOR_COORDINATES_NOT_EXISTS';

    public static $CHAT_LINK_SAVE_SUCCESS = '$CHAT_LINK_SAVE_SUCCESS';

    public static $VERIFY_ADDRESS_SUCCESS = '$VERIFY_ADDRESS_SUCCESS';
    public static $VERIFY_ADDRESS_FAIL = '$VERIFY_ADDRESS_FAIL';
}
