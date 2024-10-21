<?php

namespace BoringDragon\MsgowlLaravelNotificationChannel;

use BoringDragon\MsgowlLaravelNotificationChannel\Exceptions\CouldNotSendNotification;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;

class MsgOwlChannel
{
    /** @var \BoringDragon\MsgowlLaravelNotificationChannel\MsgOwlClient */
    protected $client;

    private $dispatcher;

    public function __construct(MsgOwlClient $client, ?Dispatcher $dispatcher = null)
    {
        $this->client = $client;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @return object with response body data if succesful response from API | empty array if not
     *
     * @throws \BoringDragon\MsgowlLaravelNotificationChannel\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toMsgOwl($notifiable);

        $data = [];

        if (is_string($message)) {
            $message = MsgOwlMessage::create($message);
        }

        if ($to = $notifiable->routeNotificationFor('MsgOwl')) {
            $message->setRecipients($to);
        }

        try {
            $data = $this->client->send($message);

            if ($this->dispatcher !== null) {
                $this->dispatcher->dispatch('msgowl-sms', [$notifiable, $notification, $data]);
            }
        } catch (CouldNotSendNotification $e) {
            if ($this->dispatcher !== null) {
                $this->dispatcher->dispatch(
                    new NotificationFailed(
                        $notifiable,
                        $notification,
                        'msgowl-sms',
                        $e->getMessage()
                    )
                );
            }
        }

        return $data;
    }
}
