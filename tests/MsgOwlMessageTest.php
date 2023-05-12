<?php

declare(strict_types=1);

namespace BoringDragon\MsgowlLaravelNotificationChannel\Test;

use BoringDragon\MsgowlLaravelNotificationChannel\MsgOwlMessage;
use PHPUnit\Framework\TestCase;

class MsgOwlMessageTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $message = new MsgOwlMessage();

        $this->assertInstanceOf(MsgOwlMessage::class, $message);
    }

    /** @test */
    public function it_can_accept_body_content_when_created()
    {

        $message = new MsgOwlMessage('YOO');

        $this->assertEquals('YOO', $message->body);

    }

    /** @test */
    public function it_can_call_the_create_method()
    {

        $message = MsgOwlMessage::create('YOO');

        $this->assertInstanceOf(MsgOwlMessage::class, $message);
        $this->assertEquals('YOO', $message->body);

    }

    /** @test */
    public function it_can_set_body()
    {
        $message = (new MsgOwlMessage())->setBody('Yolo');

        $this->assertEquals('Yolo', $message->body);
    }

    /** @test */
    public function it_can_set_sender_id()
    {

        $message = (new MsgOwlMessage())->setSenderId('NeverGonnaGiveYouUp');

        $this->assertEquals('NeverGonnaGiveYouUp', $message->sender_id);
    }

    /** @test */
    public function it_can_set_recipients_from_array()
    {
        $message = (new MsgOwlMessage())->setRecipients(['9607777777', '9607777778']);

        $this->assertEquals('9607777777,9607777778', $message->recipients);
    }

    /** @test */
    public function it_can_set_recipients_from_integer()
    {
        $message = (new MsgOwlMessage())->setRecipients(9607777777);

        $this->assertEquals(9607777777, $message->recipients);
    }

       /** @test */
       public function it_can_set_recipients_from_string()
       {
           $message = (new MsgOwlMessage())->setRecipients('9607777777');

           $this->assertEquals('9607777777', $message->recipients);
       }
}
