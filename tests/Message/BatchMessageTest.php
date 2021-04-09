<?php

declare(strict_types=1);

/*
 * Copyright (C) 2013 Worker
 *
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace Worker\Tests\Message;

use Worker\Api\Message;
use Worker\Message\BatchMessage;
use Worker\Message\Exceptions\MissingRequiredParameter;
use Worker\Model\Message\SendResponse;
use Worker\Tests\WorkerTestCase;
use Nyholm\NSA;

class BatchMessageTest extends WorkerTestCase
{
    /**
     * @var BatchMessage
     */
    private $batchMessage;

    public function setUp(): void
    {
        $messageApi = $this->getMockBuilder(Message::class)
            ->disableOriginalConstructor()
            ->setMethods(['send', 'sendMime', 'show'])
            ->getMock();
        $messageApi->method('send')
            ->willReturn(SendResponse::create(['id' => '4711', 'message' => 'Message sent']));

        $this->batchMessage = $messageApi->getBatchMessage('example.com');
    }

    public function testAddRecipient()
    {
        $this->batchMessage->addToRecipient('test@samples.worker.org', ['first' => 'Test', 'last' => 'User']);
        $message = NSA::getProperty($this->batchMessage, 'message');
        $this->assertEquals(['to' => ['"Test User" <test@samples.worker.org>']], $message);

        $counter = NSA::getProperty($this->batchMessage, 'counters');
        $this->assertEquals(1, $counter['recipients']['to']);
    }

    public function testAddRecipientWithoutFirstAndLastName()
    {
        $this->batchMessage->addToRecipient('test@samples.worker.org');
        $message = NSA::getProperty($this->batchMessage, 'message');
        $this->assertEquals(['to' => ['test@samples.worker.org']], $message);

        $counter = NSA::getProperty($this->batchMessage, 'counters');
        $this->assertEquals(1, $counter['recipients']['to']);
    }

    public function testRecipientVariablesOnTo()
    {
        $this->batchMessage->addToRecipient('test@samples.worker.org', ['first' => 'Test', 'last' => 'User']);
        $message = NSA::getProperty($this->batchMessage, 'message');
        $this->assertEquals(['to' => ['"Test User" <test@samples.worker.org>']], $message);

        $attributes = NSA::getProperty($this->batchMessage, 'batchRecipientAttributes');
        $this->assertEquals('Test', $attributes['test@samples.worker.org']['first']);
        $this->assertEquals('User', $attributes['test@samples.worker.org']['last']);
    }

    public function testRecipientVariablesOnCc()
    {
        $this->batchMessage->addCcRecipient('test@samples.worker.org', ['first' => 'Test', 'last' => 'User']);
        $message = NSA::getProperty($this->batchMessage, 'message');
        $this->assertEquals(['cc' => ['"Test User" <test@samples.worker.org>']], $message);

        $attributes = NSA::getProperty($this->batchMessage, 'batchRecipientAttributes');
        $this->assertEquals('Test', $attributes['test@samples.worker.org']['first']);
        $this->assertEquals('User', $attributes['test@samples.worker.org']['last']);
    }

    public function testRecipientVariablesOnBcc()
    {
        $this->batchMessage->addBccRecipient('test@samples.worker.org', ['first' => 'Test', 'last' => 'User']);
        $message = NSA::getProperty($this->batchMessage, 'message');
        $this->assertEquals(['bcc' => ['"Test User" <test@samples.worker.org>']], $message);

        $attributes = NSA::getProperty($this->batchMessage, 'batchRecipientAttributes');
        $this->assertEquals('Test', $attributes['test@samples.worker.org']['first']);
        $this->assertEquals('User', $attributes['test@samples.worker.org']['last']);
    }

    public function testAddMultipleBatchRecipients()
    {
        for ($i = 0; $i < 100; ++$i) {
            $this->batchMessage->addToRecipient("$i@samples.worker.org", ['first' => 'Test', 'last' => "User $i"]);
        }
        $message = NSA::getProperty($this->batchMessage, 'message');
        $this->assertEquals(100, count($message['to']));
    }

    public function testMaximumBatchSize()
    {
        $this->batchMessage->setFromAddress('samples@worker.org', ['first' => 'Test', 'last' => 'User']);
        $this->batchMessage->setSubject('This is the subject of the message!');
        $this->batchMessage->setTextBody('This is the text body of the message!');
        for ($i = 0; $i < 1001; ++$i) {
            $this->batchMessage->addToRecipient("$i@samples.worker.org", ['first' => 'Test', 'last' => "User $i"]);
        }
        $message = NSA::getProperty($this->batchMessage, 'message');
        $this->assertEquals(1, count($message['to']));
    }

    public function testRecipientAttributeResetOnEndBatchMessage()
    {
        $this->batchMessage->addToRecipient('test-user@samples.worker.org', ['first' => 'Test', 'last' => 'User']);
        $this->batchMessage->setFromAddress('samples@worker.org', ['first' => 'Test', 'last' => 'User']);
        $this->batchMessage->setSubject('This is the subject of the message!');
        $this->batchMessage->setTextBody('This is the text body of the message!');
        $this->batchMessage->finalize();
        $message = NSA::getProperty($this->batchMessage, 'message');

        $this->assertTrue(empty($message['to']));
        $this->assertNotEmpty($message);
    }

    public function testDefaultIDInVariables()
    {
        $this->batchMessage->addToRecipient('test-to@samples.worker.org');
        $this->batchMessage->addCcRecipient('test-cc@samples.worker.org');

        $attributes = NSA::getProperty($this->batchMessage, 'batchRecipientAttributes');
        $this->assertEquals('to_1', $attributes['test-to@samples.worker.org']['id']);
        $this->assertEquals('cc_1', $attributes['test-cc@samples.worker.org']['id']);
    }

    public function testGetMessageIds()
    {
        $this->batchMessage->addToRecipient('test-user@samples.worker.org', ['first' => 'Test', 'last' => 'User']);
        $this->batchMessage->setFromAddress('samples@worker.org', ['first' => 'Test', 'last' => 'User']);
        $this->batchMessage->setSubject('This is the subject of the message!');
        $this->batchMessage->setTextBody('This is the text body of the message!');
        $this->batchMessage->finalize();

        $this->assertEquals(['4711'], $this->batchMessage->getMessageIds());
    }

    public function testInvalidMissingRequiredMIMEParametersExceptionGetsFlungNoFrom()
    {
        $this->batchMessage->addToRecipient('test-user@samples.worker.org', ['first' => 'Test', 'last' => 'User']);
        $this->batchMessage->setSubject('This is the subject of the message!');
        $this->batchMessage->setTextBody('This is the text body of the message!');

        $this->expectException(MissingRequiredParameter::class);
        $this->batchMessage->finalize();
    }

    public function testInvalidMissingRequiredMIMEParametersExceptionGetsFlungNoTo()
    {
        $this->batchMessage->setFromAddress('samples@worker.org', ['first' => 'Test', 'last' => 'User']);
        $this->batchMessage->setSubject('This is the subject of the message!');
        $this->batchMessage->setTextBody('This is the text body of the message!');
        $this->expectException(MissingRequiredParameter::class);
        $this->batchMessage->finalize();
    }

    public function testInvalidMissingRequiredMIMEParametersExceptionGetsFlungNoSubject()
    {
        $this->batchMessage->addToRecipient('test-user@samples.worker.org', ['first' => 'Test', 'last' => 'User']);
        $this->batchMessage->setFromAddress('samples@worker.org', ['first' => 'Test', 'last' => 'User']);
        $this->batchMessage->setTextBody('This is the text body of the message!');
        $this->expectException(MissingRequiredParameter::class);
        $this->batchMessage->finalize();
    }

    public function testInvalidMissingRequiredMIMEParametersExceptionGetsFlungNoTextOrHtml()
    {
        $this->batchMessage->addToRecipient('test-user@samples.worker.org', ['first' => 'Test', 'last' => 'User']);
        $this->batchMessage->setFromAddress('samples@worker.org', ['first' => 'Test', 'last' => 'User']);
        $this->batchMessage->setSubject('This is the subject of the message!');
        $this->expectException(MissingRequiredParameter::class);
        $this->batchMessage->finalize();
    }
}
