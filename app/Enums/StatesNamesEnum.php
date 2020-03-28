<?php


namespace App\Enums;


class StatesNamesEnum
{
    public static $START ='start';

    public static $MAIN_SCREEN ='main_screen';
    public static $REQUEST_ERROR ='request_error';

    public static $REMINDER ='reminder';
    public static $SUBSCRIBE_INIT ='subscribe_init';
    public static $SUBSCRIBE_INIT_ALREADY_SUB ='subscribe_init_already_sub';
    public static $SUBSCRIBE_INIT_NOT_SUBBED ='subscribe_init_NOT_subbed';
    public static $SUBSCRIBE_INIT_ACCEPT ='subscribe_accept';
    public static $SUBSCRIBE_INIT_SUBSCRIBING_REQUEST ='subscribe_init_subscribing_request';
    public static $SUBSCRIBE_INIT_SUBSCRIBING_SUCCESS ='subscribe_init_subscribing_success';
    public static $SUBSCRIBE_INIT_UN_SUBSCRIBING_REQUEST ='subscribe_init_un_subscribing_request';
    public static $SUBSCRIBE_INIT_UN_SUBSCRIBING_SUCCESS ='subscribe_init_subscribing_un_success';
    public static $VOLUNTEERS ='volunteers';
}
