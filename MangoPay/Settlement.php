<?php

namespace MangoPay;

class Settlement extends Libraries\EntityBase
{
    /**
     * The unique identifier of the settlement object
     * @var string
     */
    public $SettlementId;

    /**
     * The status of the settlement
     * @var string
     */
    public $Status;

    /**
     * The date at which the settlement was created by the external provider
     * @var int Unix Timestamp
     */
    public $SettlementDate;

    /**
     * The name of the external provider
     * @var string
     */
    public $ExternalProviderName;

    /**
     * The total amount declared through intent API calls with the following calculation:
     * (Sum of captured intents) - (Sum of refunds amounts) + (Sum of refund reversed amounts) - (Sum of DISPUTED disputes) + (Sum of WON disputes)
     * @var int
     */
    public $DeclaredIntentAmount;

    /**
     * The total fees charged by the external provider
     * @var int
     */
    public $ExternalProcessorFeesAmount;

    /**
     * The total amount due to the platform (to be held in escrow wallet).
     * This amount correspond to the TotalSettlementAmount from the settlement file.
     * A negative amount will result in this parameter being set to zero, indicating no incoming funds to the escrow wallet.
     * @var int
     */
    public $ActualSettlementAmount;

    /**
     * The difference between ActualSettlementAmount and the amount received on the escrow wallet
     * @var int
     */
    public $FundsMissingAmount;

    /**
     * The FileName submitted to the POST Create a Settlement and generate upload URL endpoint,
     * with a timestamp of the Settlement creation date automatically appended by Mangopay.
     * @var string|null
     */
    public $FileName;

    /**
     * The unique temporary pre-signed URL to which to upload your CSV file.
     * Use the full dynamic URL including the host, path, and all query parameters.
     * The URL is already authenticated, so the call does not require an Authorization header.
     * @var string|null
     */
    public $UploadUrl;
}
