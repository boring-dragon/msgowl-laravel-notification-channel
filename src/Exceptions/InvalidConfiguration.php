<?php

namespace BoringDragon\MsgowlLaravelNotificationChannel;

use Exception;

class InvalidConfiguration extends Exception
{
    /**
     * @return static
     */
    public static function configurationNotSet()
    {
        return new static('In order to send notification via MsgOwl you need to add credentials in the `msgowl` key of `config.services`.');
    }
}
