<?php

namespace MangoPay\Tests\Cases;

use MangoPay\Libraries\RestTool;
use MangoPay\MangoPayApi;
use MangoPay\Pagination;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for RestTool::ReadResponseHeader: pagination (X-Number-Of-*, Link) and
 * rate limit (X-RateLimit*) headers must be parsed regardless of the header name casing.
 */
class ResponseHeaderTest extends TestCase
{
    // real API format: <url>; rel="name", comma separated without space
    private const LINK_VALUE = '<https://api.sandbox.mangopay.com/v2.01/ClientId/users?page=1&per_page=10>; rel="first",'
        . '<https://api.sandbox.mangopay.com/v2.01/ClientId/users?page=2&per_page=10>; rel="next",'
        . '<https://api.sandbox.mangopay.com/v2.01/ClientId/users?page=5&per_page=10>; rel="last"';

    public static function casingProvider(): array
    {
        return [
            'canonical' => [fn (string $name) => $name],
            'lowercase' => [fn (string $name) => strtolower($name)],
            'uppercase' => [fn (string $name) => strtoupper($name)],
        ];
    }

    #[DataProvider('casingProvider')]
    public function test_paginationHeadersParsedForAnyCasing(callable $case)
    {
        $pagination = $this->readResponseHeader([
            'HTTP/1.1 200 OK' . "\r",
            $case('X-Number-Of-Pages') . ': 5' . "\r",
            $case('X-Number-Of-Items') . ': 42' . "\r",
            $case('Link') . ': ' . self::LINK_VALUE . "\r",
        ]);

        $this->assertSame(5, $pagination->TotalPages);
        $this->assertSame(42, $pagination->TotalItems);
        $this->assertSame([
            'first' => '<https://api.sandbox.mangopay.com/v2.01/ClientId/users?page=1&per_page=10>',
            'next' => '<https://api.sandbox.mangopay.com/v2.01/ClientId/users?page=2&per_page=10>',
            'last' => '<https://api.sandbox.mangopay.com/v2.01/ClientId/users?page=5&per_page=10>',
        ], $pagination->Links);
    }

    public function test_linkHeaderValuePreservesUrlCasing()
    {
        $pagination = $this->readResponseHeader([
            'link: <https://api.sandbox.mangopay.com/v2.01/MyClient/users?page=2>; rel="next"' . "\r",
        ]);

        $this->assertSame(['next' => '<https://api.sandbox.mangopay.com/v2.01/MyClient/users?page=2>'], $pagination->Links);
    }

    public function test_linkInsideAnotherHeaderIsIgnored()
    {
        $pagination = $this->readResponseHeader([
            'X-Custom: Link: <https://example.com>; rel="next"' . "\r",
            'Deeplink: <https://example.com>; rel="next"' . "\r",
        ]);

        $this->assertSame([], $pagination->Links);
    }

    #[DataProvider('casingProvider')]
    public function test_rateLimitHeadersParsedForAnyCasing(callable $case)
    {
        $reset = time() + 10 * 60;
        $api = new MangoPayApi();
        $this->readResponseHeader([
            $case('X-RateLimit') . ': 3' . "\r",
            $case('X-RateLimit-Remaining') . ': 2297' . "\r",
            $case('X-RateLimit-Reset') . ': ' . $reset . "\r",
        ], $api);

        $this->assertCount(1, $api->RateLimits);
        $this->assertSame(3, $api->RateLimits[0]->CallsMade);
        $this->assertSame(2297, $api->RateLimits[0]->CallsRemaining);
        $this->assertSame($reset, $api->RateLimits[0]->ResetTimeTimestamp);
        $this->assertSame(15, $api->RateLimits[0]->IntervalMinutes);
    }

    private function readResponseHeader(array $headers, ?MangoPayApi $api = null): Pagination
    {
        $restTool = new RestTool($api ?? new MangoPayApi());
        $pagination = new Pagination();

        $property = new \ReflectionProperty(RestTool::class, '_pagination');
        $property->setValue($restTool, $pagination);

        $method = new \ReflectionMethod(RestTool::class, 'ReadResponseHeader');
        $method->invoke($restTool, $headers);

        return $pagination;
    }
}
