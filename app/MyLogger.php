<?php


namespace App;


use Illuminate\Support\Facades\Log;

class MyLogger
{
    public static function LOG($message)
    {
        Log::debug($message);
    }

    public static function JSON_ENCODE($object){
        return json_encode($object, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }

}
