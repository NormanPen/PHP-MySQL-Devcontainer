<?php

namespace App\Tests;

use App\Example;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testAddReturnsSum(): void
    {
        $example = new Example();
        $this->assertSame(4, $example->add(2, 2));
    }
}
