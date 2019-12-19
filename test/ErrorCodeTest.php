<?php

use PHPUnit\Framework\TestCase;
use code\ErrorCode;
use code\GeneralCode;

class ErrorCodeTest extends TestCase
{
    public function testGetCode()
    {
        $this->assertEquals(101100, ErrorCode::getCode(GeneralCode::AMQP_CONNECT_FAIL));
    }
}