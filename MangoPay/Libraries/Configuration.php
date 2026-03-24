<?php

namespace MangoPay\Libraries;

/**
 * Configuration settings
 */
class Configuration
{
    /**
     * Client Id
     * @var string
     */
    public $ClientId;

    /**
     * Client password
     * @var string
     */
    public $ClientPassword;

    /**
     * Base URL to MangoPay API
     * @var string
     */
    /*Production URL changes to {public $BaseUrl = 'https://api.mangopay.com'}*/
    public $BaseUrl = 'https://api.sandbox.mangopay.com';

    /**
     * Path to folder with temporary files (with permissions to write)
     */
    public $TemporaryFolder = null;

    /**
     * Absolute path to file holding one or more certificates to verify the peer with.
     * If empty - don't verifying the peer's certificate.
     * @var string
     */
    public $CertificatesFilePath = '';

    /**
     * Absolute path to the client certificate file for mTLS authentication (PEM format).
     * If empty, mTLS client certificate authentication is not used.
     * @var string
     */
    public $ClientCertificatePath = '';

    /**
     * Absolute path to the private key file for the client certificate (PEM format).
     * @var string
     */
    public $ClientCertificateKeyPath = '';

    /**
     * Client certificate content as a PEM-encoded base64 string for mTLS authentication.
     * Use this instead of ClientCertificatePath when the certificate is available
     * in memory (e.g. from a secrets manager).
     * Requires PHP >= 8.1 and libcurl >= 7.71.0.
     * If empty, mTLS string-based authentication is not used.
     * @var string
     */
    public $ClientCertificateString = '';

    /**
     * Private key content as a PEM-encoded base64 string for the client certificate.
     * Requires PHP >= 8.1 and libcurl >= 7.71.0.
     * @var string
     */
    public $ClientCertificateKeyString = '';

    /**
     * Password/passphrase for the client certificate private key.
     * Leave empty if the key is not password-protected.
     * @var string
     */
    public $ClientCertificateKeyPassword = '';

    /**
     * [INTERNAL USAGE ONLY]
     * Switch debug mode: log all request and response data
     */
    public $DebugMode = false;

    /**
     * Set the logging class if DebugMode is enabled
     */
    public $LogClass = 'MangoPay\Libraries\Logs';


    /**
     * Set the cURL connection timeout limit (in seconds)
     */
    public $CurlConnectionTimeout = 30;

    /**
     * Set the cURL response timeout limit (in seconds)
     */
    public $CurlResponseTimeout = 30;

    /**
     * Set the proxy host
     */
    public $HostProxy = null;

    /**
     * Set the user:password proxy
     */
    public $UserPasswordProxy = null;

    /**
     * Set to true for uk traffic
     * @deprecated Will be removed in future versions
     */
    public $UKHeaderFlag = false;
}
