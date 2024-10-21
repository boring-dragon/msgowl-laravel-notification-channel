<?php

namespace BoringDragon\MsgowlLaravelNotificationChannel;

use BoringDragon\MsgowlLaravelNotificationChannel\Exceptions\CouldNotSendNotification;
use Exception;
use GuzzleHttp\Client;

class MsgOwlClient
{
    protected $client;

    protected $api_key;

    /**
     * MsglOwlClient constructor.
     *
     * @param  $api_key  string API Key from MsgOwl API
     */
    public function __construct(Client $client, $api_key)
    {
        $this->client = $client;
        $this->api_key = $api_key;
    }

    public function send(MsgOwlMessage $message)
    {
        if (empty($message->sender_id)) {
            $message->setSenderId(config('services.msgowl.sender_id'));
        }
        if (empty($message->recipients)) {
            $message->setRecipients(config('services.msgowl.recipients'));
        }

        try {
            $response = $this->client->request('POST', 'https://rest.msgowl.com/messages', [
                'body' => $message->toJson(),
                'headers' => [
                    'Authorization' => 'AccessKey '.$this->api_key,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody()->__toString());
        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}
