<?php

namespace MangoPay\Tests\Cases;

use MangoPay\Libraries\ResponseException;
use MangoPay\Libraries\RestTool;
use MangoPay\MangoPayApi;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the SCA 401 detection in RestTool::CheckResponseCode / HandleSca401:
 * the WWW-Authenticate header must be found regardless of its casing.
 */
class ScaHeaderTest extends TestCase
{
    private const REDIRECT_URL = 'https://sca.example.com/pending?id=123';

    public static function headerNameProvider(): array
    {
        return [
            'uppercase' => ['WWW-Authenticate'],
            'capitalized' => ['Www-Authenticate'],
            'lowercase' => ['www-authenticate'],
            'all caps' => ['WWW-AUTHENTICATE'],
        ];
    }

    #[DataProvider('headerNameProvider')]
    public function test_sca401DetectedForAnyHeaderCasing(string $headerName)
    {
        $exception = $this->checkResponseCode(401, [
            'HTTP/1.1 401 Unauthorized' . "\r",
            'Content-Length: 0' . "\r",
            $headerName . ': PendingUserAction RedirectUrl=' . self::REDIRECT_URL . "\r",
        ]);

        $this->assertSame(401, $exception->getCode());
        $error = $exception->GetErrorDetails();
        $this->assertNotNull($error, 'SCA error not populated for header ' . $headerName);
        $this->assertSame('SCA required', $error->Message);
        $this->assertArrayHasKey('Sca', $error->Errors);
        $this->assertSame(self::REDIRECT_URL, $error->Data['RedirectUrl']);
    }

    public function test_401WithoutWwwAuthenticateHeaderIsNotSca()
    {
        $exception = $this->checkResponseCode(401, [
            'HTTP/1.1 401 Unauthorized' . "\r",
            'Content-Length: 0' . "\r",
        ]);

        $this->assertSame(401, $exception->getCode());
        $this->assertNull($exception->GetErrorDetails());
    }

    private function checkResponseCode(int $responseCode, array $responseHeaders): ResponseException
    {
        $restTool = new RestTool(new MangoPayApi());
        $method = new \ReflectionMethod(RestTool::class, 'CheckResponseCode');

        try {
            $method->invoke($restTool, $responseCode, null, $responseHeaders);
        } catch (ResponseException $e) {
            return $e;
        }
        $this->fail('Expected a ResponseException');
    }
}
