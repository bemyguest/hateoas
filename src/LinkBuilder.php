<?php

namespace BeMyGuest\Hateoas;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

class LinkBuilder
{
    public const URL_PARAMETERS = ['language', 'currency'];

    /** @var UrlGenerator */
    private $urlGenerator;

    /** @var Request */
    private $request;

    private $requestParameters;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
        $this->requestParameters = self::URL_PARAMETERS;
    }

    public function withRequest(Request $request): LinkBuilder
    {
        $new = clone $this;
        $new->request = $request;

        return $new;
    }

    public function withRequestParameters(array $params): LinkBuilder
    {
        $new = clone $this;
        $new->requestParameters = $params;

        return $new;
    }

    public function createLink(string $key, string $url, $method): array
    {
        $request = $this->request ? $this->request->query() : [];
        $params = array_only($request, $this->requestParameters);

        $url .= '?' . http_build_query($params);

        return [
            'method' => strtoupper($method),
            'rel' => $key,
            'href' => rtrim($url, '?'),
        ];
    }

    public function createLinkFromRoute($key, $method, $route, ...$params): array
    {
        $url = $this->urlGenerator->route($route, $params);

        return $this->createLink($key, $url, $method);
    }
}
