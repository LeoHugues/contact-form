<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $user = new User();

        $user->setEmail('true@test.com')
             ->setLastname('lastname');
             
        $this->assertTrue($user->getEmail() === 'true@test.com');
        $this->assertTrue($user->getLastname() === 'lastname');
    }

    public function testIsFalse() : void
    {
        $user = new User();

        $user->setEmail('true@test.com')
             ->setLastname('lastname');
             
        $this->assertFalse($user->getEmail() === 'false@test.com');
        $this->assertFalse($user->getLastname() === 'false');
    }

    public function testIsEmpty() : void
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getLastname());
    }
}
