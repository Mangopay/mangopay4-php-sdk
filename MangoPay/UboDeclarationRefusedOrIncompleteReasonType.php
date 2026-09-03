<?php

namespace MangoPay;

/**
 * Holds enumeration of possible reasons why a UBO declaration is refused or incomplete.
 */
class UboDeclarationRefusedOrIncompleteReasonType
{
    /**
     * When at least one natural user is missing on the declaration
     */
    public const MissingUbo = 'MISSING_UBO';

    /**
     * When at least one natural user should not be declared as UBO
     */
    public const DeclarationDoNotMatchUboInformation = 'DECLARATION_DO_NOT_MATCH_UBO_INFORMATION';

    /**
     * When name, first name, or other parameters are incorrectly entered.
     */
    public const WrongUboInformation = 'WRONG_UBO_INFORMATION';

    /**
     * When we need the UBO ID.
     */
    public const UboIdentityNeeded = 'UBO_IDENTITY_NEEDED';

    /**
     * When the statutes are silent, so we cannot verify if the information provided in the UBO is correct: We need a shareholder declaration document
     */
    public const ShareholdersDeclarationNeeded = 'SHAREHOLDERS_DECLARATION_NEEDED';

    /**
     * In case of a complex holding architecture we need the organization chart
     */
    public const OrganizationChartNeeded = 'ORGANIZATION_CHART_NEEDED';

    /**
     * When we are waiting the statutes and / or proof of registration to verify that all is correct.
     */
    public const DocumentNeeded = 'DOCUMENTS_NEEDED';

    /**
     * When a specific case not covered by the other reasons occurs.
     * @see UboDeclaration::$Message
     */
    public const SpecificCase = 'SPECIFIC_CASE';
}
