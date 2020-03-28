<?php


namespace App\Enums;


class StateTypesEnum
{
    public static $SEND_MESSAGE_AND_CHANGE_STATE = 'SEND_MESSAGE_AND_CHANGE_STATE';
    public static $SEND_MESSAGE_AND_GO_TO_MAIN = '$SEND_MESSAGE_AND_GO_TO_MAIN';
    public static $JUST_SEND_MESSAGE = '$JUST_SEND_MESSAGE';
    public static $MAKE_SOME_ACTIONS = '$MAKE_SOME_ACTIONS';
}
