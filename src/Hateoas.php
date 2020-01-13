<?php

namespace BeMyGuest\Hateoas;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;

/**
 * This class aims to provide easy way to add useful links to the
 * API JSON response. That is the foundation of REST - HATEOAS.
 *
 * @link https://en.wikipedia.org/wiki/HATEOAS
 */
class Hateoas
{
    public static function createLink(string $key, string $url = '', $method = 'get', Request $request = null): array
    {
        $request = $request ?? Request::capture();
        $urls = new UrlGenerator(new RouteCollection(), $request);
        $builder = new LinkBuilder($urls);
        $builder = $builder->withRequest($request);

        return $builder->createLink($key, $url, $method);
    }
}

