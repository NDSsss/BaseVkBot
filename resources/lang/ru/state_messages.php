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
    StatesNamesEnum::$HELP.'_1'=>'Я помогу организовать новое или присоединиться к уже существующему локальному сообществу ваших соседей по дому. Если у вас уже есть чат, в котором вы общаетесь с соседями — сообщите мне о нем, так я смогу звать волонтеров',
    StatesNamesEnum::$HELP.'_2'=>'Поделитесь со мной адресом вашего дома. Я найду для вас чат',
    StatesNamesEnum::$SUBSCRIBE_INIT_ALREADY_SUB=>'Вы уже подписаны на рассылку. Хотите отписаться?',
    StatesNamesEnum::$SUBSCRIBE_INIT_NOT_SUBBED=>'Вы можете подписаться на рассылку важных уведомлений',
    StatesNamesEnum::$SUBSCRIBE_INIT_UN_SUBSCRIBING_SUCCESS=>'Вы отписались от рассылки',
    StatesNamesEnum::$SUBSCRIBE_INIT_SUBSCRIBING_SUCCESS=>'Вы успешно подписались на рассылку',
    StatesNamesEnum::$HELP_CHAT_FOUND.'_1'=>'Спасибо! Я определил ваш адрес и нашел ближайшие сообщества в радиусе пяти километров. Вы можете создать новое сообщество.',
    StatesNamesEnum::$HELP_CHAT_FOUND.'_2'=>'Ближайшие сообщества: :addresses',
    StatesNamesEnum::$HELP_CHAT_NOT_FOUND.'_1'=>'Спасибо! Я определил ваш адрес — :address. Ваши соседи еще не создали чат, или я о нем пока не знаю',
    StatesNamesEnum::$HELP_CHAT_NOT_FOUND.'_2'=>'Если чат уже существует — отправьте мне ссылку на присоединение. Если чата еще нет — создайте и отправьте на него ссылку',
    StatesNamesEnum::$HELP_CHAT_WAIT_LINK=>'Пожалуйста, введите ссылку на чат',
    StatesNamesEnum::$HELP_CHAT_WAIT_LINK_VALIDATION_ERROR=>'Не правильный формат ссылки',
    StatesNamesEnum::$HELP_CHAT_LINK_NOT_VALID=>'Неверный формат ссылки. Попробуйте еще раз',
    StatesNamesEnum::$HELP_CREATE_CHAT_SUCCESS=>'Спасибо, ссылка сохранена.',
    StatesNamesEnum::$HELP_CREATE_CHAT_DUPLICATE=>'Этот чат уже привязан к данному адресу.',

    StatesNamesEnum::$HELP_USER_ADDRESS_INPUT=>'Пришлите мне адрес текстом',
    StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_SUCCESS=>'Спасибо! Проверьте правильность вашего полного адреса — :address.',
    StatesNamesEnum::$HELP_USER_ADDRESS_INPUT_FAIL=>'Не удалось распознать адресс :address, попробуйте ввсети еще раз',
    ''=>'',
];

