<?php

namespace MsgOwl\MsgowlLaravelNotificationChannel\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * @return static
     */
    public static function serviceRespondedWithAnError(Exception $exception)
    {
        return new static("MsgOwl service responded with an error '{$exception->getCode()}: {$exception->getMessage()}'");
    }
}
