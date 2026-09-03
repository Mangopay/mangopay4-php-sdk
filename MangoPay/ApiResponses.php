<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for responses
 * See
 */
class ApiResponses extends Libraries\ApiBase
{
    /**
     * Get response from previous call by idempotency key
     * @param string $idempotencyKey Idempotency key
     * @return Response Entity of Response object
     */
    public function Get($idempotencyKey)
    {
        $response = $this->GetObject('responses_get', 'MangoPay\Response', $idempotencyKey);

        // Same logic as RestTool::CheckResponseCode
        if ($response->StatusCode >= 200 && $response->StatusCode <= 299) {
            // Target the class to use from the SDK
            $className = $this->GetObjectForIdempotencyUrl($response->RequestURL);
            if (is_null($className) || empty($className) || is_null($response->Resource) || empty($response->Resource)) {
                return $response;
            }

            $response->Resource = $this->CastResponseToEntity($response->Resource, $className);
            return $response;
        }

        $response->Resource = $this->CastResponseToError($response->Resource);
        return $response;
    }
}
