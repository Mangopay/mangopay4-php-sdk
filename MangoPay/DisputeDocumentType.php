<?php

namespace MangoPay;

/**
 * Dispute document types
 */
class DisputeDocumentType
{
    public const DeliveryProof = "DELIVERY_PROOF";
    public const Invoice = "INVOICE";
    public const RefundProof = "REFUND_PROOF";
    public const UserCorrespondance = "USER_CORRESPONDANCE";
    public const UserAcceptanceProof = "USER_ACCEPTANCE_PROOF";
    public const ProductReplacementProof = "PRODUCT_REPLACEMENT_PROOF";
    public const Other = "OTHER";
}
