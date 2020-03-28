<?php

use App\Enums\StatesNamesEnum;

return [
    StatesNamesEnum::$START=>'Для начала нажмите кнопку, или отправьте сообщение "Начало"',
    StatesNamesEnum::$MAIN_SCREEN=>'Здравствуйте! Я — бот-помощник проекта COVIDарность. Меня запустили совсем недавно, поэтому я пока мало что умею.',
    'my_house'=>'Я помогу организовать или присоединиться к уже существующему локальному сообществу ваших соседей по дому.

Поделитесь со мной адресом вашего дома. Я найду для вас чат.',
    StatesNamesEnum::$REQUEST_ERROR=>'Что-то пошло не так. Поробуйте повторить позже',

    StatesNamesEnum::$REMINDER=>'Читайте подробнее на нашем сайте — https://covidarnost.ru/covid/',
    'chat_exists'=>'Спасибо! Ваши соседи уже создали чат. Присоединяйтесь — ',
    'chat_not_exists'=>'Спасибо! Ваши соседи еще не создали чат, или я о нем пока не знаю. Если чат уже существует — отправьте мне ссылку на присоединение. Если чата еще нет — создайте и отправьте на него ссылку.',
    'creating_chat'=>'Вы можете создать чат в любой социальной сети и отправить нам ссылку. Эта ссылка закрепится за вашим домом.',
    'join_project'=>'Присоединяйтесь к проекту!',
    'instructions'=>'Инструкция — https://covidarnost.ru/#wanttohelp
Стать волонтером проекта — https://covidarnost.ru/volonteer/',
    StatesNamesEnum::$SUBSCRIBE_INIT=>'Вы можете подписаться на рассылку важных уведомлений',
    'subscribe_accept_success_new'=>'Вы успешно подписались на рассылку',
    'subscribe_accept_success_already'=>'Вы уже подписаны на рассылку',
    StatesNamesEnum::$VOLUNTEERS.'_1'=>'Инструкция — https://covidarnost.ru/#wanttohelp',
    StatesNamesEnum::$VOLUNTEERS.'_2'=>'Стать волонтером проекта — https://covidarnost.ru/volonteer/',
    StatesNamesEnum::$SUBSCRIBE_INIT_ALREADY_SUB=>'Вы уже подписаны на рассылку. Хотите отписаться?',
    StatesNamesEnum::$SUBSCRIBE_INIT_NOT_SUBBED=>'Вы можете подписаться на рассылку важных уведомлений',
    StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_SUCCESS=>'Вы отписались от рассылки',
    StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_SUCCESS=>'Вы успешно подписались на рассылку',
    ''=>'',
];

