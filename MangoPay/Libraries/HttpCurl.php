<?php

namespace MangoPay\Libraries;

/**
 * Curl Http Client
 */
class HttpCurl extends HttpBase
{
    /**
     * cURL handle
     * @var resource
     */
    private $_curlHandle;

    /**
     * @param RestTool $restTool
     *
     * @return HttpResponse
     */
    public function Request(RestTool $restTool)
    {
        $this->BuildRequest($restTool);

        return $this->RunRequest();
    }

    /**
     * @param RestTool $restTool
     *
     * @throws Exception
     */
    private function BuildRequest(RestTool $restTool)
    {
        $this->_curlHandle = curl_init($restTool->GetRequestUrl());
        if ($this->_curlHandle === false) {
            $this->logger->error('Cannot initialize cURL session');
            throw new Exception('Cannot initialize cURL session');
        }

        curl_setopt($this->_curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_curlHandle, CURLOPT_HEADER, true);

        curl_setopt($this->_curlHandle, CURLOPT_CONNECTTIMEOUT, $this->GetCurlConnectionTimeout());
        curl_setopt($this->_curlHandle, CURLOPT_TIMEOUT, $this->GetCurlResponseTimeout());

        curl_setopt($this->_curlHandle, CURLOPT_RETURNTRANSFER, true);

        if (!empty($this->_root->Config->CertificatesFilePath)) {
            curl_setopt($this->_curlHandle, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($this->_curlHandle, CURLOPT_CAINFO, $this->_root->Config->CertificatesFilePath);
        }

        // handle mTLS cert via file paths
        if (!empty($this->_root->Config->ClientCertificatePath)) {
            curl_setopt($this->_curlHandle, CURLOPT_SSLCERT, $this->_root->Config->ClientCertificatePath);
            curl_setopt($this->_curlHandle, CURLOPT_SSLKEY, $this->_root->Config->ClientCertificateKeyPath);
            if (!empty($this->_root->Config->ClientCertificateKeyPassword)) {
                curl_setopt($this->_curlHandle, CURLOPT_SSLKEYPASSWD, $this->_root->Config->ClientCertificateKeyPassword);
            }
        } elseif (!empty($this->_root->Config->ClientCertificateString)) {
            // handle mTLS cert via strings
            if (!defined('CURLOPT_SSLCERT_BLOB') || !defined('CURLOPT_SSLKEY_BLOB')) {
                throw new Exception('ClientCertificateString requires PHP >= 8.1 and libcurl >= 7.71.0');
            }
            curl_setopt($this->_curlHandle, CURLOPT_SSLCERT_BLOB, $this->_root->Config->ClientCertificateString);
            curl_setopt($this->_curlHandle, CURLOPT_SSLKEY_BLOB, $this->_root->Config->ClientCertificateKeyString);
            if (!empty($this->_root->Config->ClientCertificateKeyPassword)) {
                curl_setopt($this->_curlHandle, CURLOPT_SSLKEYPASSWD, $this->_root->Config->ClientCertificateKeyPassword);
            }
        }

        switch ($restTool->GetRequestType()) {
            case RequestType::POST:
                curl_setopt($this->_curlHandle, CURLOPT_POST, true);
                break;
            case RequestType::PUT:
                curl_setopt($this->_curlHandle, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
            case RequestType::DELETE:
                curl_setopt($this->_curlHandle, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
        }


        curl_setopt($this->_curlHandle, CURLOPT_HTTPHEADER, $restTool->GetRequestHeaders());

        if (!is_null($this->_root->Config->HostProxy)) {
            curl_setopt($this->_curlHandle, CURLOPT_PROXY, $this->_root->Config->HostProxy);
        }

        if (!is_null($this->_root->Config->UserPasswordProxy)) {
            curl_setopt($this->_curlHandle, CURLOPT_PROXYUSERPWD, $this->_root->Config->UserPasswordProxy);
        }

        if ($restTool->GetRequestData()) {
            curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $restTool->GetRequestData());
        }

        /**
         * Hotfix for Travis-CI integration issue.
         * CURLOPT_SSLVERSION is not set correctly, causing SSL requests issue
         */
        if (getenv('TRAVIS')) {
            $options['curl'][CURLOPT_SSLVERSION] = CURL_SSLVERSION_TLSv1_2;
            curl_setopt($this->_curlHandle, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        }
    }

    /**
     * Execute request and check response
     * @return HttpResponse Response data
     * @throws Exception If cURL has error
     */
    private function RunRequest()
    {
        $result = curl_exec($this->_curlHandle);
        if ($result === false && curl_errno($this->_curlHandle) != 0) {
            $this->logger->error("cURL error: " . curl_error($this->_curlHandle));
            throw new Exception('cURL error: ' . curl_error($this->_curlHandle));
        }

        $response = new HttpResponse();
        $response->ResponseCode = (int) curl_getinfo($this->_curlHandle, CURLINFO_HTTP_CODE);

        curl_close($this->_curlHandle);

        $explode = explode("\r\n\r\n", $result);

        // multiple query (follow redirect) take only the last request
        $explode = array_slice($explode, sizeof($explode) - 2, 2);

        $response->Headers = explode("\n", implode($explode));
        $response->Body = array_pop($explode);

        return $response;
    }

    /**
     * Get cURL connection timeout to use in request
     * @return int Time in seconds
     */
    private function GetCurlConnectionTimeout()
    {
        return (int) max($this->_root->Config->CurlConnectionTimeout, 0);
    }

    /**
     * Get cURL response timeout to use in request
     * @return int Time in seconds
     */
    private function GetCurlResponseTimeout()
    {
        return (int) max($this->_root->Config->CurlResponseTimeout, 0);
    }
}
