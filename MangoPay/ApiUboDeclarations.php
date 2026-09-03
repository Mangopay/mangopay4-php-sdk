<?php

namespace MangoPay;

/**
 * Manages API calls for the UBO declaration entity.
 */
class ApiUboDeclarations extends Libraries\ApiBase
{
    /**
     * Creates a new UBO Declaration for an user.
     * @param string $userId The ID of the user
     * @return UboDeclaration UBO Declaration object returned from API
     */
    public function Create($userId)
    {
        return $this->CreateObject('ubo_declaration_create', null, '\MangoPay\UboDeclaration', $userId);
    }

    public function GetAll($userId, $pagination = null, $sorting = null)
    {
        return $this->GetList("ubo_declaration_all", $pagination, '\MangoPay\UboDeclaration', $userId, null, $sorting);
    }

    /**
     * Gets an UBO Declaration.
     * @param string $userId
     * @param string $uboDeclarationId
     * @return UboDeclaration UBO Declaration object returned from API
     */
    public function Get($userId, $uboDeclarationId)
    {
        return $this->GetObject('ubo_declaration_get', '\MangoPay\UboDeclaration', $userId, $uboDeclarationId);
    }

    /**
     * Gets an UBO Declaration directly by Id.
     * @param string $uboDeclarationId
     * @return UboDeclaration UBO Declaration object returned from API
     */
    public function GetById($uboDeclarationId)
    {
        return $this->GetObject('ubo_declaration_get_by_id', '\MangoPay\UboDeclaration', $uboDeclarationId);
    }

    /**
     * Creates a new UBO for the specified arguments
     * @param string $userId int
     * @param string $uboDeclarationId int
     * @param Ubo $ubo
     * @return Ubo UBO object returned from API
     */
    public function CreateUbo($userId, $uboDeclarationId, $ubo)
    {
        if (is_null($uboDeclarationId) or empty($uboDeclarationId)) {
            throw new Libraries\ResponseException('Parameter uboDeclarationId is empty', 400);
        }
        return $this->SaveObject('ubo_create', $ubo, '\MangoPay\Ubo', $userId, $uboDeclarationId);
    }

    /**
     * Updates an UBO
     * @param string $userId
     * @param string $uboDeclarationId
     * @param Ubo $ubo
     * @return Ubo UBO object returned from API
     */
    public function UpdateUbo($userId, $uboDeclarationId, $ubo)
    {
        return $this->SaveObject('ubo_update', $ubo, '\MangoPay\Ubo', $userId, $uboDeclarationId);
    }

    /**
     * Gets an UBO
     * @param string $userId
     * @param string $uboDeclarationId
     * @param string $uboId
     * @return Ubo UBO object returned from API
     */
    public function GetUbo($userId, $uboDeclarationId, $uboId)
    {
        return $this->GetObject('ubo_get', '\MangoPay\Ubo', $userId, $uboDeclarationId, $uboId);
    }

    /**
     * Updates an UBO Declaration with the status <code>VALIDATION_ASKED</code>.
     * @param string $userId
     * @param string $uboDeclarationId
     * @return UboDeclaration
     */
    public function SubmitForValidation($userId, $uboDeclarationId)
    {
        $entity = new UboDeclaration();
        $entity->Id = $uboDeclarationId;
        $entity->Status = UboDeclarationStatus::ValidationAsked;
        return $this->SaveObject('ubo_declaration_submit', $entity, '\MangoPay\UboDeclaration', $userId);
    }

    /**
     * Gets an UBO Declaration.
     * @param string $uboDeclarationId
     * @return UboDeclaration UBO Declaration object returned from API
     */
    public function GetUboDeclarationById($uboDeclarationId)
    {
        return $this->GetObject('ubo_declaration_get_by_id', '\MangoPay\UboDeclaration', $uboDeclarationId);
    }
}
