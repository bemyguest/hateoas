<?php

namespace BeMyGuest\Hateoas\Tests;

use BeMyGuest\Hateoas\LinkBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use PHPUnit\Framework\TestCase;

class LinkBuilderTest extends TestCase
{
    private $request;
    private $urlGenerator;

    public function setUp(): void
    {
        $this->request = $this->createMock(Request::class);
        $this->urlGenerator = $this->createMock(UrlGenerator::class);
    }

    public function testCreateLink(): void
    {
        $this->request->expects($this->any())->method('query')->willReturn([]);
        $builder = (new LinkBuilder($this->urlGenerator))
            ->withRequest($this->request);

        $simpleLink = $builder->createLink('self', 'http://example.com', 'post');
        $this->assertEquals(['method' => 'POST', 'rel' => 'self', 'href' => 'http://example.com'], $simpleLink);
    }

    public function testCreateLinkFromRoute(): void
    {
        $this->request->expects($this->any())->method('query')->willReturn([]);
        $this->urlGenerator->method('route')->willReturn('http://example.com/route-name');

        $builder = (new LinkBuilder($this->urlGenerator))
            ->withRequest($this->request);

        $routeLink = $builder->createLinkFromRoute('self', 'get', 'example_route');
        $this->assertEquals(['method' => 'GET', 'rel' => 'self', 'href' => 'http://example.com/route-name'], $routeLink);
    }

    public function testAppendRequestParameters(): void
    {
        $this->request->expects($this->any())->method('query')->willReturn(['key1' => 'val1', 'key2' => 'val2']);
        $builder = (new LinkBuilder($this->urlGenerator))
            ->withRequest($this->request)
            ->withRequestParameters(['key1', 'key2']);

        $simpleLink = $builder->createLink('self', 'http://example.com', 'post');
        $this->assertEquals(['method' => 'POST', 'rel' => 'self', 'href' => 'http://example.com?key1=val1&key2=val2'], $simpleLink);
    }


}
