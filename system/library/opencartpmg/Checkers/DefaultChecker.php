<?php

namespace OpenCardPMG\Checkers;

abstract class DefaultChecker
{
    public static $messages = [];

    public static function execute(){

    }

    public static function put_message( $message ){
        self::$messages[] = trim( $message );
    }

    public static function get_messages( ){
        return self::$messages;
    }
}