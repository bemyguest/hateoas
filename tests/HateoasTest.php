<?php
namespace BeMyGuest\Hateoas\Tests;

use BeMyGuest\Hateoas\Hateoas;
use PHPUnit\Framework\TestCase;

class HateoasTest extends TestCase
{
    public function testCreateLink()
    {
        $this->assertSame([
            'method' => 'GET',
            'rel' => 'listings',
            'href' => '',
        ], Hateoas::createLink('listings'));
        $this->assertSame([
            'method' => 'GET',
            'rel' => 'listings',
            'href' => 'https://dashboard.bemyguest.com.sg/api/listings',
        ], Hateoas::createLink('listings', 'https://dashboard.bemyguest.com.sg/api/listings'));
        $this->assertSame([
            'method' => 'POST',
            'rel' => 'listings',
            'href' => 'https://dashboard.bemyguest.com.sg/api/listings',
        ], Hateoas::createLink('listings', 'https://dashboard.bemyguest.com.sg/api/listings', 'post'));
    }
}
