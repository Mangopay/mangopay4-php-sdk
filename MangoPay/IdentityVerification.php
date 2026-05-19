<?php

namespace MangoPay;

class IdentityVerification extends Libraries\EntityBase
{
    /**
     * The URL to redirect the user to for the hosted identity verification session.
     * @var string
     */
    public $HostedUrl;

    /**
     * The status of the identity verification session:
     *  <p>PENDING – The session is available on the HostedUrl, to which the user must be redirected to complete it.</p>
     *  <p>VALIDATED – The session was successful.</p>
     *  <p>REFUSED – The session was refused.</p>
     *  <p>REVIEW – The session is under manual review by Mangopay.</p>
     *  <p>OUT_OF_DATE – The session is no longer valid (likely due to expired documents used during the session).</p>
     *  <p>TIMEOUT – The session timed out due to inactivity.</p>
     *  <p>ERROR – The session was not completed because an error occurred.</p>
     * @var string
     */
    public $Status;

    /**
     * The URL to which the user is returned after the hosted identity verification session, regardless of the outcome.
     * @var string
     */
    public $ReturnUrl;

    /**
     * @var int
     */
    public $LastUpdate;

    /**
     * @var string
     */
    public $UserId;

    /**
     * @var Check[]
     */
    public $Checks;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Checks'] = ['array_single', '\MangoPay\Check'];

        return $subObjects;
    }
}
