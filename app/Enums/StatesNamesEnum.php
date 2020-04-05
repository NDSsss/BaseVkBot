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
    public static $HELP ='help';
//    public static $HELP_SAVE_USER_WITH_GEO_REQUEST ='help_save_user_with_geo_request';
    public static $HELP_GET_NEAR_CHAT_REQUEST ='help_get_near_chat_request';
    public static $HELP_CHAT_FOUND ='help_chat_found';
    public static $HELP_CHAT_NOT_FOUND ='help_chat_not_found';
    public static $HELP_CHAT_WAIT_LINK ='help_chat_not_found_wait_link';
    public static $HELP_CHAT_WAIT_LINK_VALIDATION_ERROR ='help_chat_not_found_wait_link_validation_error';
    public static $HELP_CREATE_CHAT_SUCCESS ='help_create_chat_success';
    public static $HELP_CREATE_CHAT_DUPLICATE ='help_create_chat_duplicate';
    public static $HELP_CHAT_LINK_NOT_VALID ='help_chat_link_not_valid';
    public static $HELP_CREATE_CHAT_REQUEST ='help_chat_not_found_link_not_validated_request';
    public static $HELP_USER_ADDRESS_INPUT = 'user_address_input';
    public static $HELP_USER_ADDRESS_INPUT_SUCCESS = 'user_address_input_success';
    public static $HELP_USER_ADDRESS_INPUT_FAIL = 'user_address_input_fail';
    public static $HELP_USER_ADDRESS_INPUT_USER_ACCEPT = 'user_address_input_user_accept';
}
