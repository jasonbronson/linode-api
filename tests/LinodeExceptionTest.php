<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2016 Artem Rodygin
//
//  You should have received a copy of the MIT License along with
//  this file. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace Tests\Linode;

use Linode\LinodeException;

class LinodeExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultConstructor()
    {
        $exception = new LinodeException();

        self::assertCount(0, $exception);
        self::assertEquals(400, $exception->getCode());
        self::assertEquals('Unknown error.', $exception->getMessage());
    }

    public function testCustomCode()
    {
        $exception = new LinodeException([], 404);

        self::assertEquals(404, $exception->getCode());
    }

    public function testSingleMessage()
    {
        $exception = new LinodeException(['Custom message.']);

        self::assertCount(1, $exception);
        self::assertEquals('Custom message.', $exception->getMessage());
    }

    public function testMultipleMessages()
    {
        $errors = [
            'field1' => 'Custom message #1.',
            'Not a field-specific message.',
            'field2' => 'Custom message #2.',
            'field3' => 'Custom message #3.',
        ];

        $exception = new LinodeException($errors);

        self::assertCount(4, $exception);
        self::assertEquals('Custom message #1.', $exception->getMessage());

        $result = [];

        foreach ($exception as $field => $reason) {
            $result[$field] = $reason;
        }

        self::assertEquals($errors, $result);
    }
}
