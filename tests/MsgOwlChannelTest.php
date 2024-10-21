<?php

namespace BoringDragon\MsgowlLaravelNotificationChannel\Test;

use BoringDragon\MsgowlLaravelNotificationChannel\MsgOwlChannel;
use BoringDragon\MsgowlLaravelNotificationChannel\MsgOwlClient;
use BoringDragon\MsgowlLaravelNotificationChannel\MsgOwlMessage;
use GuzzleHttp\Client;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Mockery;
use PHPUnit\Framework\TestCase;

class MsgOwlChannelTest extends TestCase
{
    private $notification;

    private $string_notification;

    private $notifiable;

    private $guzzle;

    private $client;

    private $channel;

    public function setUp(): void
    {
        $this->notification = new TestNotification;
        $this->string_notification = new TestStringNotification;
        $this->notifiable = new TestNotifiable;
        $this->guzzle = Mockery::mock(new Client);
        $this->client = Mockery::mock(new MsgOwlClient($this->guzzle, 'test_aabtyuendgdhdshjw'));
        $this->channel = new MsgOwlChannel($this->client);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(MsgOwlClient::class, $this->client);
        $this->assertInstanceOf(MsgOwlChannel::class, $this->channel);
    }

    /** @test */
    public function test_it_shares_message()
    {
        $this->client->shouldReceive('send')->once();
        $this->assertNull($this->channel->send($this->notifiable, $this->notification));
    }

    /** @test */
    public function if_string_message_can_be_send()
    {
        $this->client->shouldReceive('send')->once();
        $this->assertNull($this->channel->send($this->notifiable, $this->string_notification));
    }
}

class TestNotifiable
{
    use Notifiable;

    public function routeNotificationForMsgOwl()
    {
        return '9607777777';
    }
}

class TestNotification extends Notification
{
    public function toMsgOwl($notifiable)
    {
        return (new MsgOwlMessage('Message content'))
            ->setSenderId('Jinas')
            ->setRecipients('9607777777');
    }
}

class TestStringNotification extends Notification
{
    public function toMsgOwl($notifiable)
    {
        return 'Test by string';
    }
}
