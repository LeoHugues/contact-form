<?php

namespace App\Tests;

use App\Entity\ContactRequest;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class ContactRequestTest extends TestCase
{
    public function testIsTrue(): void
    {
        $request = new ContactRequest();
        $user = new User();
        $now = new DateTime();

        $request->setContactUser($user);
        $request->setRequest('Lorem ipsum dolor si amet');
        $request->setCreateDate($now);

        $this->assertTrue($request->getContactUser() === $user);
        $this->assertTrue($request->getRequest() === 'Lorem ipsum dolor si amet');
        $this->assertTrue($request->getCreateDate() === $now);
    }

    public function testIsFalse(): void
    {
        $request = new ContactRequest();
        $user = new User();

        $request->setContactUser($user);
        $request->setRequest('Lorem ipsum dolor si amet');

        $this->assertFalse($request->getContactUser() === new User());
        $this->assertFalse($request->getRequest() === 'false');
        $this->assertFalse($request->getCreateDate() === new DateTime('yesterday'));
    }

    public function testIsEmpty(): void
    {
        $request = new ContactRequest();

        $this->assertEmpty($request->getContactUser());
        $this->assertEmpty($request->getRequest());
        $this->assertNotEmpty($request->getCreateDate());
    }
}
