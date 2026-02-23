## [3.50.1] - 2026-02-23
### Added - ChargeBearer body parameter on payouts

https://github.com/Mangopay/mangopay4-php-sdk/pull/779/changes/011296e13901bd6ece848d9f052de9f93dd43346
On [POST Create a Payout](/api-reference/payouts/create-payout), platforms can now request to pay all SWIFT fees using the `OUR` value of the new `ChargeBearer` property ([API release note](/release-notes/api/2026-02-16)):
- Handle `ChargeBearer` param

### Added - AuthenticationType response property on card pay-ins

https://github.com/Mangopay/mangopay4-php-sdk/pull/779/changes/cffccbe99a3efd51bdfba54ff4e37536240af578
- The `AuthenticationResult.AuthenticationType` response property is now returned on card pay-ins

### Added - TelephoneOrder body parameter on recurring card pay-ins (CIT and MIT)

https://github.com/Mangopay/mangopay4-php-sdk/pull/779/changes/e69cc7af27f9384c3d02bac91774b21f76061035
To support the `TelephoneOrder` property on [POST Create a Recurring PayIn (MIT)](/api-reference/recurring-card-payins/create-recurring-payin-cit) and [POST Create a Recurring PayIn (CIT)](/api-reference/recurring-card-payins/create-recurring-payin-mit):
- handle `PaymentCategory` param

## [3.50.0] - 2026-02-12
### FX

#### Breaking change – Custom fees
#771
To support percentage-based FX fees ([API release note](/release-notes/api/2026-02-11)):
- **Breaking change** – The `CreateInstantConversion.Fees` type is now `CustomFees` instead of `Money`, to support the new FX fees structure of `Type` (`PERCENTAGE` | `FIXED`) and `Value`
- **Breaking change** - The `ConversionQuote.Fees` type is now `CustomFees` instead of `Money`,  to support the new FX fees structure of `Type` (`PERCENTAGE` | `FIXED`) and `Value`
- Added `RequestedFees` to `ConversionQuote` and `Conversion`

#### Added – User margin
#771
To support the FX user margin ([API release note](/release-notes/api/2026-02-11)):
- Added `UserMargin` to `CreateInstantConversion` and `ConversionQuote`
- Added `MarginsResponse` to `Conversion` and `ConversionQuote`

### Echo

#### Breaking change - Settlement upload endpoints
#767
To support the new behavior of the [POST Create a Settlement](/api-reference/settlements/create-settlement) endpoint to obtain an `UploadUrl`:
- Updated `settlement_sample.csv` and tests
- Added `FileName` and `UploadUrl` to `Settlement`
- Added `GenerateSettlementUploadUrl ` interface
- **Breaking change** – Replaced `upload` method in `ApiSettlements` with `GenerateUploadUrl`
- **Breaking change** – Replaced `update` method in `ApiSettlements` with `GenerateNewUploadUrl`

#### Added - GET validations for a Settlement endpoint
#767
To support the [GET View validations for a Settlement](/api-reference/settlements/view-settlement-validations) endpoint:
- Added `SettlementValidation`, `SettlementValidationFooter`, `SettlementValidationLine` classes
- Added `GetValidations` method to `ApiSettlements`

#### Added - PUT Cancel a Settlement endpoint
#767
To support the [PUT Cancel a Settlement](/api-reference/settlements/cancel-settlement) endpoint:
- Added `Cancel` method to `ApiSettlements`

#### Added – Intent unfunded amounts and source wallet
#768
- Added `SplitOriginWalletId` to `PayInIntentLineItem`, `PayInIntentSplit`
  #761
- Added `UnfundedSellerAmount` to `PayInIntentLineItem`
- Added `UnfundedAmount` to `PayInIntent`

#### Added – POST Create a Refund of an Intent
#763
To support [POST Create a Refund of an Intent](/api-reference/intents/create-intent-refund):
- Added `Refund` and `Capture` to `PayInIntent`
- Added `CreatePayInIntentRefund` method to `ApiPayins`

#### Added – POST Reverse the Refund of an Intent
#763
To support [POST Reverse the Refund of an Intent](/api-reference/intents/create-intent-refund):
- Added `ReversePayInIntentRefund` method to `ApiPayins`

#### Added – POST Create a Dispute of an Intent
#763
To support [POST Create a Dispute of an Intent](/api-reference/intents/create-intent-refund):
- Added `Dispute` to `PayInIntent`
- Added `CreatePayInIntentDispute` method to `ApiPayins`

#### Added - PUT Update an Intent Dispute
#763
To support [PUT Update an Intent Dispute](/api-reference/intents/create-intent-dispute):
- Added `Decision` to `PayInIntent`
- Added `UpdatePayInIntentDisputeOutcome` method to `ApiPayins`

#### Fixed - VirtualAccountCapabilities
#760
- Fixed `LocalPayInAvailable` and `InternationalPayInAvailable` in `VirtualAccountCapabilities` class

## [3.49.0] - 2026-01-27
### Added
- Support for new [GET View the SCA status of a User](https://docs.mangopay.com/api-reference/users/view-user-sca-status) endpoint ([API release note](https://docs.mangopay.com/release-notes/api/2026-01-15)) (#766)
- Support for new [event types](https://docs.mangopay.com/webhooks/event-types#mangopay-sca-email-and-phone-number-verification) `SCA_CONTACT_INFORMATION_UPDATE_CONSENT_GIVEN`, `SCA_CONTACT_INFORMATION_UPDATE_CONSENT_REVOKED`, `SCA_TRANSFER_CONSENT_GIVEN`, `SCA_TRANSFER_CONSENT_REVOKED`, `SCA_RECIPIENT_REGISTRATION_CONSENT_GIVEN`, `SCA_RECIPIENT_REGISTRATION_CONSENT_REVOKED`, `SCA_VIEW_ACCOUNT_INFORMATION_CONSENT_GIVEN`, `SCA_VIEW_ACCOUNT_INFORMATION_CONSENT_REVOKED`, `SCA_EMAIL_VERIFIED`, `SCA_PHONE_NUMBER_VERIFIED` (#765) (thank you @williamdes)
- Support for new `RecipientId` property on [payouts](https://docs.mangopay.com/api-reference/payouts/create-payout) ([API release note](https://docs.mangopay.com/release-notes/api/2026-01-27)) (#759)

Release PR: #770

## [3.48.0] - 2025-11-28
### Changed
- Migrated to V4 naming convention

## [3.47.1] - 2025-11-25
### Added
- Support for `ScaContext` on [POST Create a Recipient](https://docs.mangopay.com/api-reference/recipients/create-recipient) for platforms taking action by [proxy with consent](https://docs.mangopay.com/guides/sca/proxy-management) from the user ([API release note](https://docs.mangopay.com/release-notes/api/2025-11-17), #753)

## [3.47.0] - 2025-10-27
### Added
- New [POST Manage proxy consent for a User](https://docs.mangopay.com/api-reference/users/manage-proxy-consent) endpoint to obtain and manage user consent via the hosted SCA experience (if proxy is activated). A proxy and user consent are now required to use the `USER_NOT_PRESENT` value for `ScaContext` ([API release note](https://docs.mangopay.com/release-notes/api/2025-10-23), #751)
- `ScaContext` request parameter newly added on all user POST and PUT endpoints, enabling the platform to request these actions with `USER_NOT_PRESENT` – provided the proxy is in place, activated, and the user has given consent ([API release note](https://docs.mangopay.com/release-notes/api/2025-10-23#sca%3A-scacontext-request-parameter-on-user-endpoints), #750 )
- Support for the `Licensor` property on [GET View a Client](https://docs.mangopay.com/api-reference/client/view-client) (#749 )

### Changed
- `x-tenant-id` deprecated as no longer necessary for UK platforms; the parameter is ignored by Mangopay (#749 )

## [3.46.0] - 2025-10-01
### Added
- [Verification of Payee (VOP)](https://docs.mangopay.com/guides/vop/recipients-payouts) API response fields (`RecipientVerificationOfPayee` and sub-properties) on the endpoints [GET View a Recipient](https://docs.mangopay.com/api-reference/recipients/view-recipient), [POST Create a Recipient](https://docs.mangopay.com/api-reference/recipients/create-recipient), [POST Create a Payout](https://docs.mangopay.com/api-reference/payouts/create-payout) ([API release note](https://docs.mangopay.com/release-notes/api/2025-09-30), #739)
- Support for the [POST Cancel an Intent](https://docs.mangopay.com/api-reference/intents/cancel-intent) endpoint for [Echo](https://docs.mangopay.com/guides/echo), Mangopay's solution for platforms working with another third-party PSP for funds acquisition (#747)
- Support for [POST Submit data for a PayPal PayIn](https://docs.mangopay.com/api-reference/paypal/submit-data-paypal-payin) endpoint (#744)

## [3.45.2] - 2025-09-23
### Added
- Support for `ProfilingAttemptReference` on all payment methods for Mangopay's Fraud Prevention solution #743
- Webhook event types for [Echo](https://docs.mangopay.com/guides/echo), Mangopay's solution for third-party PSP integrations: `INTENT_AUTHORIZED`,`INTENT_CAPTURED`,`INTENT_REFUNDED`,`INTENT_REFUND_REVERSED`,`INTENT_DISPUTE_CREATED`,`INTENT_DISPUTE_DEFENDED`,`INTENT_DISPUTE_WON`,`INTENT_DISPUTE_LOST`,`INTENT_SETTLED_NOT_PAID`,`INTENT_PAID`,`SPLIT_CREATED`,`SPLIT_PENDING_FUNDS_RECEPTION`,`SPLIT_AVAILABLE`,`SPLIT_REJECTED`,`SPLIT_REVERSED` #742
- Support for `VirtualAccountPurpose` on Banking Alias object #745

## [3.45.1] - 2025-09-03
### Added
- Support for `Fees` on `ConversionQuote` #736 (thank you @pkly #647)

### Improved
- OAuth token refresh buffer before expiry updated to 30s #740
- Curl verification of SSL certificate #737 (thank you @Kelthan #695)
- PHP 8.2 compatibility #738 (thank you @Nek- #588  @nurul-umbhiya #640)

### Fixed
- Tests #734

## [3.45.0] - 2025-08-14
### Changed
- Type casting to deserialize arrays in `GetSchema` #732 (#717 thanks for raising @tarsFromTesseract).
> ⚠️**Caution – Potentially breaking**
> The new `GetSchema` typings may result in a breaking change if your integration relies on the `stdClass` returned previously.

- Made `PendingUserAction` nullable #730 (#726 thanks for raising @williamdes)

### Added
- Support for [POST Create a Bank Wire to the Repudiation Wallet](https://docs.mangopay.com/api-reference/dispute-settlement/create-bank-wire-payin-to-repudiation-wallet) #731

## [3.44.0] - 2025-08-07
### Added
Support for new Splits endpoints for Echo (#727, [API release note](https://docs.mangopay.com/release-notes/api/2025-07-16)):
- [PUT Update a Split of an Intent](https://docs.mangopay.com/api-reference/intents/update-intent-split)
- [POST Execute a Split of an Intent](https://docs.mangopay.com/api-reference/intents/execute-intent-split)
- [POST Reverse the Split of an Intent](https://docs.mangopay.com/api-reference/intents/reverse-intent-split)
- [GET View a Split of an Intent](https://docs.mangopay.com/api-reference/intents/view-intent-split)

New `ReportTypes` for Echo (#728, [API release note](https://docs.mangopay.com/release-notes/api/2025-08-06))):
- `ECHO_INTENT`
- `ECHO_INTENT_ACTION`
- `ECHO_SETTLEMENT`
- `ECHO_SPLIT`

## [3.43.1] - 2025-07-28
### Added
- `Sku` parameter on LineItem, for [Klarna PayIns](https://docs.mangopay.com/api-reference/klarna/create-klarna-payin)
- handle new endpoint [View supported banks for Pay by Bank](https://docs.mangopay.com/api-reference/pay-by-bank/view-supported-banks-pay-by-bank), to enable presentation of banks to user before Pay by Bank payment request

## [3.43.0] - 2025-07-18
### Added
Endpoints for [Mangopay Echo](https://docs.mangopay.com/guides/echo), a solution for platforms working with another third-party PSP for funds acquisition (including via the Mirakl Connector) #720 :
- [POST Create an Intent](https://docs.mangopay.com/api-reference/intents/create-intent)
- [GET View an Intent](https://docs.mangopay.com/api-reference/intents/view-intent)
- [POST Create a Capture for an Intent](https://docs.mangopay.com/api-reference/intents/create-intent-capture)
- [POST Create a Settlement](https://docs.mangopay.com/api-reference/settlements/create-settlement)
- [PUT Update a Settlement](https://docs.mangopay.com/api-reference/settlements/update-settlement)
- [GET View a Settlement](https://docs.mangopay.com/api-reference/settlements/view-settlement)
- [POST Create a Split of an Intent](https://docs.mangopay.com/api-reference/intents/create-intent-split)

## [3.42.0] - 2025-07-03
### Added
- New endpoint [POST Create a Bizum PayIn](https://docs.mangopay.com/api-reference/bizum/create-bizum-payin)
- New webhook event types for SCA enrollment ([API release note](https://docs.mangopay.com/release-notes/api/2025-06-23)), note that these are triggered on enrollment not authentication:
  - `SCA_ENROLLMENT_SUCCEEDED`
  - `SCA_ENROLLMENT_FAILED`
  - `SCA_ENROLLMENT_EXPIRED`
- New webhook event types for `UserCategory` change ([API release note](https://docs.mangopay.com/release-notes/api/2025-06-23) ):
  - `USER_CATEGORY_UPDATED_TO_OWNER`
  - `USER_CATEGORY_UPDATED_TO_PAYER`
  - `USER_CATEGORY_UPDATED_TO_PLATFORM`
- Support for `PLATFORM` value to `UserCategory` enum
- Support for [GET List Transactions for a Card Fingerprint](https://docs.mangopay.com/api-reference/transactions/list-transactions-card-fingerprint)

## [3.41.1] - 2025-06-12
### Added
- [US and CA virtual accounts](https://docs.mangopay.com/release-notes/api/2025-06-12) for local pay-in collection

### Fixed
- On POST Enroll a User, `PendingUserAction` cast to `\MangoPay\PendingUserAction` instead of `stdClass` (thanks for raising @renanwingly #713)

## [3.41.0] - 2025-06-10
### Added

Endpoints for [new Reporting Service](https://docs.mangopay.com/release-notes/api/2025-06-05) feature:
- [POST Create a Report](https://docs.mangopay.com/api-reference/reporting/create-report)
- [GET View a Report](https://docs.mangopay.com/api-reference/reporting/view-report)
- [GET List all Reports](https://docs.mangopay.com/api-reference/reporting/list-reports)

Webhook [event types](url) for new Reporting Service:
- `REPORT_GENERATED`
- `REPORT_FAILED`

Support for [GET List Disputes for a PayIn](https://docs.mangopay.com/api-reference/disputes/list-disputes-payin) endpoint.

## [3.40.1] - 2025-06-06
### Added
- Support for `RecipientScope` query parameter on [GET List Recipients for a User](https://docs.mangopay.com/api-reference/recipients/list-recipients-user)
- Support for missing webhook event types (recurring registration, deposit preauth, etc)

### Fixed
- `Status` enum value on Identity Verification object changed from `OUTDATED` to `OUT_OF_DATE`

## [3.40.0] - 2025-05-23
### Added

Event types for [user account webhooks](https://docs.mangopay.com//webhooks/event-types#user-account), relevant to [SCA enrollment in user endpoints](https://docs.mangopay.com/guides/sca/users#user-status) and account closure:
- `USER_ACCOUNT_VALIDATION_ASKED`
- `USER_ACCOUNT_ACTIVATED`
- `USER_ACCOUNT_CLOSED`

Event types for [instant and quoted FX conversions](https://docs.mangopay.com//webhooks/event-types#fx-conversions):
- `INSTANT_CONVERSION_CREATED`
- `INSTANT_CONVERSION_SUCCEEDED`
- `INSTANT_CONVERSION_FAILED`
- `QUOTED_CONVERSION_CREATED`
- `QUOTED_CONVERSION_SUCCEEDED`
- `QUOTED_CONVERSION_FAILED`

Support for [30-day deposit preauthorization](https://docs.mangopay.com/guides/payment-methods/card/deposit-preauthorization) features:
- [POST Create a Deposit Preauthorized PayIn prior to complement](https://docs.mangopay.com/api-reference/deposit-preauthorizations/create-deposit-preauthorized-payin-prior-to-complement)
- [POST Create a Deposit Preauthorized PayIn complement](https://docs.mangopay.com/api-reference/deposit-preauthorizations/create-deposit-preauthorized-payin-complement)
- `NO_SHOW_REQUESTED` on `updateDeposit` method for [PUT Cancel a Deposit Preauthorization or request a no-show](https://docs.mangopay.com/api-reference/deposit-preauthorizations/cancel-deposit-preauthorization-request-no-show)
- [GET View a PayIn (Deposit Preauthorized Card](https://docs.mangopay.com/api-reference/deposit-preauthorizations/view-payin-deposit-preauthorized)
- [GET List Transactions for a Deposit Preauthorization](https://docs.mangopay.com/api-reference/transactions/list-transactions-deposit-preauthorization)

## [3.39.0] - 2025-05-14
### Added and refined

#### Hosted KYC/KYB endpoints

The following endpoints have been refined following the beta phase, and are now generally available:
- [POST Create an IDV Session](https://docs.mangopay.com/api-reference/idv-sessions/create-idv-session) (no changes)
- [GET View an IDV Session](https://docs.mangopay.com/api-reference/idv-sessions/view-idv-session) (includes `Checks` in response)
- [GET List IDV Sessions for a User](https://docs.mangopay.com/api-reference/idv-sessions/list-idv-sessions-user) (new endpoint)

The previously available endpoint GET View Checks for an IDV Session has been removed (as Checks were integrated into the GET by ID).

See the [guide](https://docs.mangopay.com/guides/users/verification/hosted) for more details.

#### Recipients

The `Country` property has been added to [Recipients](https://docs.mangopay.com/guides/sca/recipients), as a required query parameter on [GET View the schema for a Recipient](https://docs.mangopay.com/api-reference/recipients/view-recipient-schema) and as a required body parameter on [POST Validate data for a Recipient](https://docs.mangopay.com/api-reference/recipients/validate-recipient-data) and [POST Create a Recipient](https://docs.mangopay.com/api-reference/recipients/create-recipient).

### Added

- [GET List Deposit Preauthorizations for a Card](https://docs.mangopay.com/api-reference/deposit-preauthorizations/list-deposit-preauthorizations-card)
- [GET List Deposit Preauthorizations for a User](https://docs.mangopay.com/api-reference/deposit-preauthorizations/list-deposit-preauthorizations-user)

## [3.38.0] - 2025-04-29
### Added

#### SCA on wallet access endpoints
`ScaContext` query parameter added on wallet access endpoints for the [introduction of SCA](https://docs.mangopay.com/guides/sca/wallets):

- [GET View a Wallet](https://docs.mangopay.com/api-reference/wallets/view-wallet)
- [GET List Wallets for a User](https://docs.mangopay.com/api-reference/wallets/list-wallets-user)
- [GET List Transactions for a User](https://docs.mangopay.com/api-reference/transactions/list-transactions-user)
- [GET List Transactions for a Wallet](https://docs.mangopay.com/api-reference/transactions/list-transactions-wallet)

If SCA is required, Mangopay responds with a 401 response code. The `PendingUserAction` `RedirectUrl` is in the dedicated `WWW-Authenticate` response header.

See the tests for examples on handling this error.

## [3.37.0] - 2025-04-17
### Added

#### Recipients
- [GET View payout methods](/api-reference/recipients/view-payout-methods)
- [GET View the schema for a Recipient](/api-reference/recipients/view-recipient-schema)
- [POST Validate data for a Recipient](/api-reference/recipients/validate-recipient-data)
- [POST Create a Recipient](/api-reference/recipients/create-recipient)
- [GET View a Recipient](/api-reference/recipients/view-recipient)
- [GET List Recipients for a user](/api-reference/recipients/list-recipients-user)
- [PUT Deactivate a Recipient](/api-reference/recipients/deactivate-recipient)
- Webhook event types:
  - `RECIPIENT_ACTIVE`
  - `RECIPIENT_CANCELED`
  - `RECIPIENT_DEACTIVATED`

#### SCA on Owner-initiated transfers
- On [POST Create a Transfer](/api-reference/transfers/create-transfer)
  - `ScaContext` body parameter
  - `PendingUserAction` response field containing `RedirectUrl`

#### Endpoints to close a user account
- [DELETE Close a Natural User](/api-reference/users/close-natural-user)
- [DELETE Close a Legal User](/api-reference/users/close-legal-user)

## [3.36.0] - 2025-04-17
### Added
- [POST Create a BLIK PayIn (with code)](https://docs.mangopay.com/api-reference/blik/create-blik-payin-with-code)
- [POST Create a TWINT PayIn](https://docs.mangopay.com/api-reference/twint/create-twint-payin)
- [POST Create a Pay by Bank PayIn](https://docs.mangopay.com/api-reference/pay-by-bank/create-pay-by-bank-payin), including related `PAYIN_NORMAL_PROCESSING_STATUS_PENDING_SUCCEEDED` webhook event type
- `RTGS_PAYMENT` for `PayoutModeRequested` on [POST Create a Payout](https://docs.mangopay.com/api-reference/payouts/create-payout)
- PayPal recurring payments, thanks to the `PaymentType` value `PAYPAL` on [Recurring PayIn Registrations](https://docs.mangopay.com/api-reference/recurring-payin-registrations/create-recurring-payin-registration-paypal) and new endpoints ([POST Create a Recurring PayPal PayIn (CIT)](https://docs.mangopay.com/api-reference/paypal/create-recurring-paypal-payin-cit) and [POST Create a Recurring PayPal PayIn (MIT)](https://docs.mangopay.com/api-reference/paypal/create-recurring-paypal-payin-mit)

## [3.35.1] - 2025-04-02
### Changed
- User-Agent Header value standardized on format: User-Agent: Mangopay-SDK/`SDKVersion` (`Language`/`LanguageVersion`)

### Fixed
- Replaced int property with Money property for recurring payin registration `TotalAmount`
- Fixed tests for categorize SCA users endpoint

## [3.35.0] - 2025-03-07
### Added

New endpoints for [strong customer authentication (SCA)](https://docs.mangopay.com/guides/users/sca) on Owner users:
- [POST Create a Natural User (SCA)](https://docs.mangopay.com/api-reference/users/create-natural-user-sca)
- [PUT Update a Natural User (SCA)](https://docs.mangopay.com/api-reference/users/update-natural-user-sca)
- [POST Create a Legal User (SCA)](https://docs.mangopay.com/api-reference/users/create-legal-user-sca)
- [PUT Update a Legal User (SCA)](https://docs.mangopay.com/api-reference/users/update-legal-user-sca)
- [PUT Categorize a Natural User (SCA)](https://docs.mangopay.com/api-reference/users/categorize-natural-user)
- [PUT Categorize a Legal User (SCA)](https://docs.mangopay.com/api-reference/users/categorize-legal-user)
- [POST Enroll a User in SCA](https://docs.mangopay.com/api-reference/users/enroll-user)

### Added

New endpoint for Payconiq:
- [POST Create a Payconiq PayIn](https://docs.mangopay.com/api-reference/payconiq/create-payconiq-payin)

## [3.34.1] - 2025-02-28
### Fixed

Rate limiting headers interpreted dynamically based on `X-RateLimit-Reset` time and for a variable number of bucket values.

## [3.34.0] - 2025-02-14
### Added

New endpoints for [hosted Identity Verification](https://docs.mangopay.com/guides/users/verification/hosted#guide-to-hosted-identity-verification) and relevant webhooks:

- [Create a hosted Identity Verification Session](https://docs.mangopay.com/guides/users/verification/hosted#post-create-a-hosted-identity-verification-session)
- [View an Identity Verification Session](https://docs.mangopay.com/guides/users/verification/hosted#get-view-an-identity-verification-session)
- [View an Identity Verification Checks](https://docs.mangopay.com/guides/users/verification/hosted#get-view-identity-verification-checks)

New endpoint for The Swish PayIn object:

- [Create a Swish PayIn](https://docs.mangopay.com/api-reference/swish/create-swish-payin)
- [View a PayIn (Swish)](https://docs.mangopay.com/api-reference/swish/view-payin-swish)

New endpoints for client wallet conversations:

- [Create an Instant Conversion between Client Wallets](https://docs.mangopay.com/api-reference/conversions/create-instant-conversion-client-wallets)
- [Create a Quoted Conversion between Client Wallets](https://docs.mangopay.com/api-reference/conversions/create-quoted-conversion-client-wallets)

## [3.33.2] - 2025-02-05
### Updated

Revised tests to improve reliability and address any outdated tests.
## [3.33.1] - 2025-01-29
### Updated

Added option to create a [GB Banking Alias](https://docs.mangopay.com/api-reference/banking-aliases/create-iban-banking-alias#200-gb).

## [3.33.0] - 2024-12-13
### Added

- New `PaymentRef` parameter for [Payouts](https://docs.mangopay.com/api-reference/payouts/payout-object#the-payout-object)
v
## [3.32.2] - 2024-11-28
### Updated

Added all relevant `EVENT_TYPE_CHOICES` for virtual accounts:

- `VIRTUAL_ACCOUNT_ACTIVE`
- `VIRTUAL_ACCOUNT_BLOCKED`
- `VIRTUAL_ACCOUNT_CLOSED`
- `VIRTUAL_ACCOUNT_FAILED`

## [3.32.1] - 2024-11-12
### Fixed

- https://github.com/Mangopay/mangopay2-php-sdk/pull/643 Fixed PHP doc blocks.
- https://github.com/Mangopay/mangopay2-php-sdk/pull/654 Fixed idempotency response to return the error object.
- #656 Update `bankAccountId` parameter to accept alphanumerical IDs.

Thanks for you contribution [@williamdes](https://github.com/williamdes)

## [3.32.0] - 2024-10-30
### Added

New endpoints for The Virtual Account object:
- [Create a Virtual Account]()
- [Deactivate a Virtual Account]()
- [View a Virtual Account]()
- [List Virtual Accounts for a Wallet]()
- [View Client Availabilities]()

## [3.31.0] - 2024-07-30
### Added

1. New endpoint: [Create a Bancontact PayIn](https://mangopay.com/docs/endpoints/bancontact#create-bancontact-payin)

2. New parameter `PaymentCategory` for the following endpoints :
- [Create a Card Validation](https://mangopay.com/docs/endpoints/card-validations#create-card-validation)
- [Create a Direct Card PayIn](https://mangopay.com/docs/endpoints/direct-card-payins#create-direct-card-payin)
- [Create a Preauthorization](https://mangopay.com/docs/endpoints/preauthorizations#create-preauthorization)

## [3.30.0] - 2024-05-31
### Added

New parameter `StatementDescriptor` for the following endpoints :

- [Create a refund for a payin](https://mangopay.com/docs/endpoints/refunds#create-refund-payin)
- [View a refund](https://mangopay.com/docs/endpoints/refunds#view-refund)

Thanks @williamdes

## [3.29.3] - 2024-05-24
### Added

- New parameter `CardHolderName` for [Update Card registration](https://mangopay.com/docs/endpoints/card-validations#update-card-registration)

## [3.29.2] - 2024-04-30
### Fixed

- Updated the implementation for [Look up metadata for a payment method](https://mangopay.com/docs/endpoints/payment-method-metadata#lookup-payment-method-metadata). The `CommercialIndicator` and `CardType` fields have been moved to the `BinData` object in the API response.

## [3.29.1] - 2024-04-12
### Fixed

- #637 Reset DebugMode to false by default

## [3.29.0] - 2024-04-02
### Added

- New endpoint [Add tracking to Paypal payin](https://mangopay.com/docs/endpoints/paypal#add-tracking-paypal-payin)
- New parameter `SecureMode` for [Create card validation](https://mangopay.com/docs/endpoints/card-validations#create-card-validation)
- New parameters for Paypal mean of payment : `CancelURL` & `Category` (sub-parameter of `LineItems`). And management of `PaypalPayerID`, `BuyerCountry`, `BuyerFirstname`, `BuyerLastname`, `BuyerPhone`, `PaypalOrderID` in the response.

## [3.28.0] - 2024-03-08
### Fixed

- Fixed incorrect spelling of the `Subtype` key in the `BinData` parameter.
- Conversions endpoint spelling

### Added

- The optional Fees parameter is now available on instant conversions, allowing platforms to charge users for FX services. More information [here](https://mangopay.com/docs/release-notes/millefeuille).
- Platforms can now use a quote to secure the rate for a conversion between two currencies for a set amount of time. More information [here](https://mangopay.com/docs/release-notes/millefeuille).
- Introduced the `UKHeaderFlag` boolean configuration key. Platforms partnered with Mangopay's UK entity should set this key to true for proper configuration.

## [3.27.0] - 2024-02-13
### Added

- New endpoint to look up metadata from BIN or Google Pay token. More information [here](https://mangopay.com/docs/release-notes/kisale)
- [Get a card validation endpoint](https://mangopay.com/docs/endpoints/card-validations#view-card-validation)
- [Validate the format of user data endpoint](https://mangopay.com/docs/endpoints/user-data-format#validate-user-data-format)
- Deprecate dynamic properties #592
- Constant class created for UserCategory parameter

## [3.26.0] - 2023-12-22
### Added

New `CardInfo` parameter returned on card transactions. More information [here](https://mangopay.com/docs/release-notes/chilka).

## [3.25.0] - 2023-12-07
### Added

The IDEAL legacy implementation has been enhanced. You can now pass the `Bic`., and if provided, the API response will include the `BankName` parameter. More information [here](https://mangopay.com/docs/endpoints/web-card-payins#create-web-card-payin).

## [3.24.1] - 2023-11-09
### Added

It's now possible to specify an amount for DebitedFunds and Fees when you create a refund with `PayIns->CreateRefund()`.

## [3.24.0] - 2023-11-02
### Updated
- Giropay and Ideal integrations with Mangopay have been improved.
- Klarna param "MerchantOrderId" has been renamed to "Reference"

### Added
- New Reference parameter for the new Paypal implementation.

## [3.23.0] - 2023-09-29
### Added
- Instantly convert funds between 2 wallets of different currencies owned by the same user with the new SPOT FX endpoints

## [3.22.1] - 2023-09-15
### Fixed

- Formatting issues (linter)

## [3.22.0] - 2023-09-15
### Added

- Multibanco, Satispay, Blik, Klarna are now available as a payment method with Mangopay. This payment method is in private beta. Please contact support if you have any questions.
- Card validation endpoint is now available (Private beta)
- A new parameter for Paypal : ShippingPreference
- Timeout configuration is now customizable. Default value is now 30s.

### Updated

- Google Pay integration with Mangopay has been improved. This payment method is in private beta. Please contact support if you have any questions.

### Fixed

- MBWay & PayPal are now using Web Execution Type.

## [3.21.0] - 2023-07-07
### Added

Paypal integration with Mangopay has been improved. This payment method is in private beta. Please contact support if you have any questions.

### Fixed

- `Phone` parameter instead of `PhoneNumber` for MBWay

## [3.20.1] - 2023-06-21
### Fixed
- linter issue for the new Mbway PayIn model

## [3.20.0] - 2023-06-21
### Added

- MB WAY is now available as a payment method with Mangopay. This payment method is in private beta. Please contact support if you have any questions.

## [3.19.0] - 2023-03-17
### Added

Knowing when a dispute was closed is now possible thanks to the new ClosedDate parameter for the Dispute object.

The following endpoints have been updated accordingly:

[Vew a Dispute](ttps://docs.mangopay.com/endpoints/v2.01/disputes#e240_view-a-dispute)

[List Disputes for a User](https://docs.mangopay.com/endpoints/v2.01/disputes#e817_list-a-users-disputes)

[List Disputes for a Wallet](https://docs.mangopay.com/endpoints/v2.01/disputes#e816_list-a-wallets-disputes)

[List all Disputes](https://docs.mangopay.com/endpoints/v2.01/disputes#e241_list-all-disputes)

[List Disputes that need settling](https://docs.mangopay.com/endpoints/v2.01/disputes#e980_list-disputes-that-need-settling)

Please note that the new ClosedDate field will only display values for the Disputes closed after this release. Otherwise, a null value will be returned.

## [3.18.1] - 2023-01-26
### Fixed

- Fix bug preventing access to authentication endpoint

## [3.18.0] - 2023-01-12
### Added

Verifying some specific legal structures is now more efficient thanks to a new legal entity type: `PARTNERSHIP`.

The Legal User LegalPersonType parameter now includes the `PARTNERSHIP` value. The following endpoints have been updated accordingly:

[Create a Legal User (Payer)](https://docs.mangopay.com/endpoints/v2.01/users#e259_create-a-legal-user)

[Create a Legal User (Owner)](https://docs.mangopay.com/endpoints/v2.01/users#e1060_create-a-legal-user-owner)

[Update a Legal User](https://docs.mangopay.com/endpoints/v2.01/users#e261_update-a-legal-user)

Please note that changing the LegalPersonType to `PARTNERSHIP` for an existing user will automatically result in:

- A KYC downgrade to Light (default) verification
- The REGISTRATION_PROOF document being flagged as OUT_OF_DATE.

With this new LegalPersonType, the MANGOPAY team can better handle specific legal structures and speed up the validation process.



## [3.17.0] - 2022-11-15
### Added

#### New 30-day preauthorization feature

Preauthorizations can now hold funds for up to 30 days, therefore ensuring the solvency of a registered card for the same amount of time.

- The **ApiDeposits** class has been added with methods for creating, fetching and canceling a deposit
- The **CreateCardPreAuthorizedDepositPayIn()** method has been added to the ApiPayIns class

Thanks to 30-day preauthorizations, MANGOPAY can provide a simpler and more flexible payment experience for a wide range of use cases, especially for rentals.

## [3.16.2] - 2022-10-26
### Fixed 

- 565 : Add Id on PayInRecurringRegistration
- 564 : Fix type hint for RemainingFunds
- 563 : Added CardId property to PayInExecutionDetailsDirect and used “int” as types for identifiers

Thanks @AntoineLemaire & @garsaud 

## [3.16.1] - 2022-10-18
### Fixed

Tests have been fixed due to API updates

## [3.16.0] - 2022-09-07
##Added
**New country authorizations endpoints**

Country authorizations can now be viewed by using one of the following endpoints:

<a href="https://docs.mangopay.com/endpoints/v2.01/regulatory#e1061_the-country-authorizations-object">View a country's authorizations</a> <br>
<a href="https://docs.mangopay.com/endpoints/v2.01/regulatory#e1061_the-country-authorizations-object">View all countries' authorizations</a>

With these calls, it is possible to check which countries have:

- Blocked user creation
- Blocked bank account creation
- Blocked payout creation

Please refer to the <a href="https://docs.mangopay.com/guide/restrictions-by-country">Restrictions by country</a>
article for more information.

## [3.15.0] - 2022-06-29
##Added
**Recurring: €0 deadlines for CIT**

Setting free recurring payment deadlines is now possible for CIT (customer-initiated transactions) with the **FreeCycles** parameter.

The **FreeCycles** parameter allows platforms to define the number of consecutive deadlines that will be free. The following endpoints have been updated to take into account this new parameter:

<a href="https://docs.mangopay.com/endpoints/v2.01/payins#e1051_create-a-recurring-payin-registration">Create a Recurring PayIn Registration</a><br>
<a href="https://docs.mangopay.com/endpoints/v2.01/payins#e1056_view-a-recurring-payin-registration">View a Recurring PayIn Registration</a><br>

This feature provides new automation capabilities for platforms with offers such as “Get the first month free” or “free trial” subscriptions.

Please refer to the <a href="https://docs.mangopay.com/guide/recurring-payments-introduction">Recurring payments overview</a> documentation for more information.

## [3.14.1] - 2022-05-23
### Fixed

Implementation of UserCategory has been simplified


## [3.14.0] - 2022-05-20
### Added

#### UserCategory management

Users can now be differentiated depending on their MANGOPAY usage.

This is possible with the new UserCategory parameter, whose value can be set to:

- Payer – For users who are only using MANGOPAY to give money to other users (i.e., only pay).
- Owner – For users who are using MANGOPAY to receive funds (and who are therefore required to accept MANGOPAY’s terms and conditions).

Please note that the following parameters become required as soon as the UserCategory is set to “Owner”:
- HeadquartersAddress
- CompanyNumber (if the LegalPersonType is “Business”)
- TermsAndConditionsAccepted.

The documentation of user-related endpoints has been updated and reorganised to take into account the new parameter:

[Create a Natural User (Payer)](https://docs.mangopay.com/endpoints/v2.01/users#e255_create-a-natural-user)
[Create a Natural User (Owner)](https://docs.mangopay.com/endpoints/v2.01/users#e1059_create-natural-user-owner)
[Update a Natural User](https://docs.mangopay.com/endpoints/v2.01/users#e260_update-a-natural-user)
[Create a Legal User (Payer)](https://docs.mangopay.com/endpoints/v2.01/users#e259_create-a-legal-user)
[Create a Legal User (Owner)](https://docs.mangopay.com/endpoints/v2.01/users#e1060_create-a-legal-user-owner)
[Update a Legal User](https://docs.mangopay.com/endpoints/v2.01/users#e261_update-a-legal-user)
[View a User](https://docs.mangopay.com/endpoints/v2.01/users#e256_view-a-user)
[List all Users](https://docs.mangopay.com/endpoints/v2.01/users#e257_list-all-users)

Differentiating the platform users results in a smoother user experience for “Payers” as they will have less declarative data to provide.

#### RecurringPayinRegistrationId in all PayIn GET calls

A PR to add the missing RecurringPayinRegistrationId to all PayIn get calls to match the MangoPay API calls. Thanks @H4wKs

#552

### Fix in ReportRequest Entity

#551

Thanks @Asenar

## [3.13.0] - 2022-05-12
### Added

#### Terms and conditions acceptance parameter

The acceptance of the MANGOPAY terms and conditions by the end user can now be registered via the SDK.

This information can be managed by using the new `TermsAndConditionsAccepted` parameter added to the `User` object.

The following API endpoints have been updated to take into account the new TermsAndConditionsAccepted parameter:

[Create a Natural User](https://docs.mangopay.com/endpoints/v2.01/users#e255_create-a-natural-user)
[Update a Natural User](https://docs.mangopay.com/endpoints/v2.01/users#e260_update-a-natural-user)
[Create a Legal User](https://docs.mangopay.com/endpoints/v2.01/users#e259_create-a-legal-user)
[Update a Legal User](https://docs.mangopay.com/endpoints/v2.01/users#e261_update-a-legal-user)
[View a User](https://docs.mangopay.com/endpoints/v2.01/users#e256_view-a-user)

Please note that:

- Existing users have to be updated to include the terms and conditions acceptance information.
- Once accepted, the terms and conditions cannot be revoked.


## [3.12.0] - 2022-03-31
### Added

#### Instant payment eligibility check

With the function
`PayOuts->CheckInstantPayoutEligibility($params);`
the destination bank reachability can now be verified prior to making an instant payout. This results in a better user experience, as this preliminary check will allow the platform to propose the instant payout option only to end users whose bank is eligible.

## [3.11.0] - 2022-03-18
## Fixed

We are now compatible with psr/log 1 to psr/log 3.

## [3.10.0] - 2021-11-19
## Added

We are now providing new hooks for our new feature [Instant payouts](https://docs.mangopay.com/guide/instant-payment-payout) :

- INSTANT_PAYOUT_SUCCEEDED
- INSTANT_PAYOUT_FALLBACKED

It will allow you to trigger an action depends on the Instant Payout treatment.

## [3.9.0] - 2021-10-20
## Added

You can now change the status to "ENDED" for a recurring payment.

## Fixed

- "Status" is now available in the response when you request a recurring payment registration.
- Fix recurring PayIn CIT / MIT create methods return doctype

## [3.8.0] - 2021-10-11
## Added

### Payconiq

As requested by numerous clients, we are now providing [Payconiq](https://www.payconiq.be) as a new mean-of-payment. To request access, please contact MANGOPAY.

### Flags for KYC documents

**We provide more information regarding refused KYC documents.** Therefore it will be easier for you to adapt your app behavior and help your end user.

You are now able to see the exact explanation thanks to a new parameter called “Flags”.

It has been added to

`MangoPay::KycDocument.fetch(new_natural_user['Id'], new_document['Id'])`

It will display one or several error codes that provide the reason(s) why your document validation has failed. These error codes description are available [here](https://docs.mangopay.com/guide/kyc-document).

## [3.7.1] - 2021-08-10
## Fixed

- Better support of more PHPUnit versions
- Cleanup the vendor bundle, to reduce the size of the SDK

Thanks williamdes for your help

## [3.7.0] - 2021-08-10
## Fixed

- ChargeDate has been added for PayInPaymentDetailsDirectDebit
- Change `FallbackReason` parameter's type to object in PayOutPaymentDetailsBankWire

## Added

- You can now update and view a Recurring PayIn Registration object. To know more about this feature, please consult the documentation [here](https://docs.mangopay.com/guide/recurring-payments-introduction).
- To improve recurring payments, we have added new parameters for CIT : DebitedFunds & Fees. To know more about this feature, please consult the documentation [here](https://docs.mangopay.com/endpoints/v2.01/payins#e1053_create-a-recurring-payin-cit)

## [3.6.0] - 2021-06-10
## Added

We have added a new feature **[recurring payments](https://docs.mangopay.com/guide/recurring-payments)** dedicated to clients needing to charge a card repeatedly, such as subscriptions or payments installments.

You can start testing in sandbox, to help you define your workflow. This release provides the first elements of the full feature.

- [Create a Recurring PayIn Registration object](https://docs.mangopay.com/endpoints/v2.01/payins#e1051_create-a-recurring-payin-registration), containing all the information to define the recurring payment
- [Initiate your recurring payment flow](https://docs.mangopay.com/endpoints/v2.01/payins#e1053_create-a-recurring-payin-cit) with an authenticated transaction (CIT) using the Card Recurring PayIn endpoint
- [Continue your recurring payment flow](https://docs.mangopay.com/endpoints/v2.01/payins#e1054_create-a-recurring-payin-mit) with an non-authenticated transaction (MIT) using the Card Recurring PayIn endpoint

This feature is not yet available in production and you need to contact the Support team to request access.

## [3.5.0] - 2021-05-27
## Added

### Instant payment

Mangopay introduces the instant payment mode. It allows payouts (transfer from wallet to user bank account) to be processed within 25 seconds, rather than the 48 hours for a standard payout.

You can now use this new type of payout with the PHP SDK.

Example :

```php
$payOutGet = $this->_api->PayOuts->GetBankwire($payOut->Id);
// where $payOut->Id is the id of an existing payout
```

Please note that this feature must be authorized and activated by MANGOPAY. More information [here](https://docs.mangopay.com/guide/instant-payment-payout).

### Accepted PRs

- Improved documentation around ubo declaration reason
- ResponseError object improvement

## [3.4.0] - 2021-05-11
## Fixed

### IBAN for testing purposes

⚠️ **IBAN provided for testing purpose should never be used outside of a testing environement!**

More information about how to test payments, click [here](https://docs.mangopay.com/guide/testing-payments).

### Others

- Fix Shipping was missing Libraries\Dto thank you @ericabouaf
- Fix `BankAccount` IBAN reference for tests
- FIX path oauth/token erreur 404 url not found. Thank you @rachedbelhadj

## Added

### New events for PreAuthorization

Some of you use a lot the [PreAuthorization](https://docs.mangopay.com/endpoints/v2.01/preauthorizations#e183_the-preauthorization-object) feature of our API. To make your life easier, we have added three new events :

- PREAUTHORIZATION_CREATED
- PREAUTHORIZATION_SUCCEEDED
- PREAUTHORIZATION_FAILED

The goal is to help you monitor a PreAuthorization with a [webhook](https://docs.mangopay.com/endpoints/v2.01/hooks#e246_the-hook-object).

*Example: If a PreAuthorization is desynchronized, when the status is updated, you will be able to know it.*

### PSR4 / PSR12 compliance

- Thanks to @MockingMagician, the SDK is PSR4 / PSR12 compliant. That help your IDE and make sure you can run tests on case-sensitive system. Plus, docker environments has been added to run tests locally in all PHP major versions.

## Changed
- To better illustrate the fact that Rate Limiting Reset is a timestamp, we have change $rateLimits[0]->ResetTimeMillis to $rateLimits[0]->ResetTimeTimestamp

## [3.3.0] - 2021-03-25
## Added

### On demand feature for 3DSv2

> **This on-demand feature is for testing purposes only and will not be available in production**

#### Request

We've added a new parameter `Requested3DSVersion` (not mandatory) that allows you to choose between versions of 3DS protocols (managed by the parameter `SecureMode`). Two values are available:
* `V1`
* `V2_1`

If nothing is sent, the flow will be 3DS V1.

The `Requested3DSVersion` may be included on all calls to the following endpoints:
* `/preauthorizations/card/direct`
* `/payins/card/direct`

#### Response

In the API response, the `Requested3DSVersion` will show the value you requested:
* `V1`
* `V2_1`
* `null` – indicates that nothing was requested

The parameter `Applied3DSVersion` shows you the version of the 3DS protocol used. Two values are possible:
* `V1`
* `V2_1`

## Fixed

* Fixed UBO declaration by adding missing `UserId`
* Added missing `Billing` in `/payins/card/web`
* Test on `IpAddress` presence in `/payins/card/direct`



# [3.2.0] - 2021-02-19
- 3DS2 integration with Shipping and Billing objects, including FirstName and a LastName fields
The objects Billing and Shipping may be included on all calls to the following endpoints:
  - /preauthorizations/card/direct
  - /payins/card/direct
  - /payins/card/web
- Activate Instant Payment for payouts by adding a new parameter PayoutModeRequested on the following endpoint /payouts/bankwire
  - The new parameter PayoutModeRequested can take two differents values : "INSTANT_PAYMENT" or "STANDARD" (STANDARD = the way we procede normaly a payout request)
  - This new parameter is not mandatory and if empty or not present, the payout will be "STANDARD" by default
  - Instant Payment is in beta all over Europe - SEPA region
- Fix inverted params for PHP compatibility : Due to compatibility issues with newer versions of PHP we have inverted params in certain methods, including constructor, please check the release code for further detail 🔄
- Fix method ScopeBlocked for blocked status
- Fix BrowserInfo class
# [3.1.6] -  2020-12-18
Added IpAddress and BrowserInfo parameters to the following endpoints and corresponding objects
- /payins/card/direct
- /preauthorizations/card/direct

Added 'NO_CHOICE' value for the SecureMode parameter
# [3.1.5] - 2020-12-11
- Removed testing older PHP testing versions
- Added 'Regulatory' endpoint to allow checks of User Block Status
- Added support for Regulatory -> Blocked Status Hooks
- Added methods for creating Client bank accounts and client payouts
## [3.1.4] - 2020-10-23
- New endpoint : GET .../v2.01/ClientId/preauthorizations/PreAuthorizationId/transactions/ which allows multiple transactions to be listed
- Testing config changes for TLS, this was blocking a part of the deploy process
- Sorting::_sortFields changed to avoid an error when calling GetSortParameter()
- Changed ignore phpunit-cache and minor "Field" typo
- removed php 5.4 and 5.5 from travis and updated curl ssl version

## [3.1.2] - 2020-09-25
- New endpoint to support changes to Card Validation process (please listen out for product announcements)
- New RemainingFunds Parameters (Complete feature not fully activated, please listen for product announcements)
- Fix to PayInWebExtendedView

## [3.1.1] - 2020-08-28
- As part of KYC improvements, we are adding an OUT_OF_DATE status for KYC documents
- New MultiCapture Parameter added to Preauthorization object (Complete feature not fully activated, please listen for product announcements)
- "User-agent" format in the headers changed, aligned to other assets
- Improvements to error handling for RestTool.php requests

## [3.1.0]
- USER_KYC_REGULAR has been added as a new Event. Thanks to it, you are now able to know when all the needed KYCs for a user have been validated and its KYCLevel is updated.
- Release adds typing for EventType values KYC_OUTDATED USER_KYC_REGULAR and USER_KYC_LIGHT
- Updated filtering on user Cards list
- Google Pay are ready to be supported!
- AccountNumber has been added for Payin External Instruction as a part of DebitedBankAccountDetails. Funds from a non-IBAN account are now better identified.

## [3.0.0]
### BREAKING CHANGES
- Add a new `PAYLINEV2` parameter for Payin Web Card only. You must now use `PayInCardTemplateURLOptions` object instead of `PayInTemplateURLOptions` (if you use custom Template). You can always use `PayInTemplateURLOptions`for all of your Payin Direct Debit Web.

## [2.13.2]
### Added
- Mandate Status `EXPIRED` and EventType `MANDATE_EXPIRED` have been added.

## [2.13.1]
### Fixed
- Deprecated syntax on RestTool.php file for PHP 7.4 version.

## [2.13.0]
### Added
- ApplePay `Payin` functions are now available. More info about activation to come in the following weeks...  
- `UBODeclaration` can be retrieved only with its ID thanks to new `GetById`function
- `COUNTERFEIT_PRODUCT` added as a new `DisputeReasonType`
- `GetEMoney` function has been fixed due to too many mandatory parameters.

## [2.12.2] - 2019-09-11
### Changed
- GET EMoney method now supports year and month parameters. More info on our [docs](https://docs.mangopay.com/endpoints/v2.01/user-emoney#e895_view-a-users-emoney)
### Fixed
- Add missing `isActive`property for `UBOs`

## [2.12.1] - 2019-06-13
### Fixed
- missing UBO EventTypes has been added 

## [2.12.0] - 2019-05-21
### Added
- new [`UBODelaration`](https://docs.mangopay.com/endpoints/v2.01/ubo-declarations#e1024_the-ubo-declaration-object) submission system
- `CompanyNumber` support for [Legal `Users`](https://docs.mangopay.com/endpoints/v2.01/users#e259_create-a-legal-user)
### Fixed
- Pagination has been fixed as total pages/items value was always zero.

 
