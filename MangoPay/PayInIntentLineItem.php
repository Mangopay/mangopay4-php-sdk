<?php

namespace MangoPay;

class PayInIntentLineItem extends Libraries\Dto
{
    /**
     * Unique identifier.
     * @var string
     */
    public $Id;

    /**
     * Information about the seller involved in the transaction
     * @var PayInIntentSeller
     */
    public $Seller;

    /**
     * The unique identifier of the item
     * @var string
     */
    public $Sku;

    /**
     * The name of the item
     * @var string
     */
    public $Name;

    /**
     * The description of the item
     * @var string
     */
    public $Description;

    /**
     * The quantity of the item
     * @var int
     */
    public $Quantity;

    /**
     * The cost of the item, excluding tax and discount
     * @var int
     */
    public $UnitAmount;

    /**
     * The item total amount to be captured
     * @var int
     */
    public $Amount;

    /**
     * The tax amount applied to the item
     * @var int
     */
    public $TaxAmount;

    /**
     * The discount amount applied to the item
     * @var int
     */
    public $DiscountAmount;

    /**
     * The item category
     * @var string
     */
    public $Category;

    /**
     * Information about the end user’s shipping address
     * @var Address
     */
    public $ShippingAddress;

    /**
     * The item total amount including tax and discount
     * @var int
     */
    public $TotalLineItemAmount;

    /**
     * The item total canceled amount
     * @var int
     */
    public $CanceledAmount;

    /**
     * The item total captured amount
     * @var int
     */
    public $CapturedAmount;

    /**
     * The item total refunded amount
     * @var int
     */
    public $RefundedAmount;

    /**
     * The item total disputed amount
     * @var int
     */
    public $DisputedAmount;

    /**
     * The item total split amount
     * @var int
     */
    public $SplitAmount;

    /**
     * @var int|null
     */
    public $UnfundedSellerAmount;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['ShippingAddress'] = '\MangoPay\Address';
        $subObjects['Seller'] = '\MangoPay\PayInIntentSeller';

        return $subObjects;
    }
}
