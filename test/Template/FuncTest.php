<?php

declare(strict_types=1);

/**
 * This file is part of mobiCMS Content Management System.
 *
 * @license     https://opensource.org/licenses/MIT MIT (see the LICENSE file)
 * @link        http://mobicms.org mobiCMS Project
 */

namespace MobicmsTest;

use League\Plates\Template\Func;
use LogicException;
use MobicmsTest\Extension\DummyExtensionInterface;
use PHPUnit\Framework\TestCase;

class FuncTest extends TestCase
{
    private $function;

    public function setUp() : void
    {
        $this->function = new Func('uppercase', function ($string) {
            return strtoupper($string);
        });
    }

    public function testCanCreateInstance() : void
    {
        $this->assertInstanceOf(Func::class, $this->function);
    }

    public function testSetAndGetName() : void
    {
        $this->assertInstanceOf(Func::class, $this->function->setName('test'));
        $this->assertEquals($this->function->getName(), 'test');
    }

    public function testSetInvalidName() : void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Not a valid function name.');
        $this->function->setName('invalid-function-name');
    }

    public function testSetAndGetCallback() : void
    {
        $this->assertInstanceOf(Func::class, $this->function->setCallback('strtolower'));
        $this->assertEquals($this->function->getCallback(), 'strtolower');
    }

    public function testSetInvalidCallback() : void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Not a valid function callback.');
        $this->function->setCallback(null);
    }

    public function testFunctionCall() : void
    {
        $this->assertEquals($this->function->call(null, ['Jonathan']), 'JONATHAN');
    }

    public function testExtensionFunctionCall() : void
    {
        $extension = $this->createPartialMock(DummyExtensionInterface::class, ['register', 'foo']);
        $extension->method('foo')->willReturn('bar');
        $this->function->setCallback([$extension, 'foo']);
        $this->assertEquals($this->function->call(null), 'bar');
    }
}
