# SDK Usage Guide

## mTLS (Mutual TLS) Authentication

The SDK supports mutual TLS (mTLS) client certificate authentication. You can provide the certificate either as file paths or as in-memory strings.

### Option 1: Certificate files (PEM format)

```php
$api = new MangoPay\MangoPayApi();
$api->Config->ClientId = 'your-client-id';
$api->Config->ClientPassword = 'your-client-password';

// Path to the client certificate file (PEM)
$api->Config->ClientCertificatePath = '/path/to/client-cert.pem';

// Path to the private key file (PEM)
$api->Config->ClientCertificateKeyPath = '/path/to/client-key.pem';

// Optional: passphrase if the private key is password-protected
$api->Config->ClientCertificateKeyPassword = 'key-passphrase';
```

### Option 2: Certificate strings (from secrets manager or environment)

Use this approach when certificates are loaded from a secrets manager, environment variables, or any in-memory source rather than the filesystem.

**Requirements:** PHP >= 8.1 and libcurl >= 7.71.0.

The certificate and key must be base64-encoded PEM strings.

```php
$api = new MangoPay\MangoPayApi();
$api->Config->ClientId = 'your-client-id';
$api->Config->ClientPassword = 'your-client-password';

// Base64-encoded PEM certificate content
$api->Config->ClientCertificateString = 'base64-encoded-string'

// Base64-encoded PEM private key content
$api->Config->ClientCertificateKeyString = 'base64-encoded-string'

// Optional: passphrase if the private key is password-protected
$api->Config->ClientCertificateKeyPassword = 'key-passphrase';
```

A typical real-world usage with a secrets manager would look like:

```php
$cert = $secretsManager->getSecret('mangopay-client-cert');  // already base64 PEM
$key  = $secretsManager->getSecret('mangopay-client-key');

$api->Config->ClientCertificateString    = $cert;
$api->Config->ClientCertificateKeyString = $key;
```

### Notes

- The `BaseUrl` must use the `api-mtls` hostname (e.g. `https://api-mtls.sandbox.mangopay.com`) instead of the standard `api` hostname when mTLS is used.
- File path and string options are mutually exclusive. If `ClientCertificatePath` is set it takes precedence over `ClientCertificateString`.
- The string-based option uses `CURLOPT_SSLCERT_BLOB` / `CURLOPT_SSLKEY_BLOB` under the hood, which requires PHP >= 8.1 compiled against libcurl >= 7.71.0. An exception is thrown at runtime if these constants are unavailable.
- `ClientCertificateKeyPassword` applies to both file and string modes.