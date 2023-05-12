<?php

namespace BoringDragon\MsgowlLaravelNotificationChannel\Test;

use BoringDragon\MsgowlLaravelNotificationChannel\MsgOwlClient;
use BoringDragon\MsgowlLaravelNotificationChannel\MsgOwlMessage;
use GuzzleHttp\Client;
use Mockery;
use PHPUnit\Framework\TestCase;

class MsgOwlClientTest extends TestCase
{
    private $guzzle;

    private $client;

    private $message;

    public function setUp(): void
    {
        $this->guzzle = Mockery::mock(new Client());
        $this->client = Mockery::mock(new MsgOwlClient($this->guzzle, 'test_aabtyuendgdhdshjw'));
        $this->message = (new MsgOwlMessage('Message content'))->setSenderId('Jinas')->setRecipients('9607777777');
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
        $this->assertInstanceOf(MsgOwlMessage::class, $this->message);
    }

    /** @test */
    public function it_can_send_message()
    {
        $this->client->shouldReceive('send')->with($this->message)->once();
        $this->assertNull($this->client->send($this->message));
    }
}
