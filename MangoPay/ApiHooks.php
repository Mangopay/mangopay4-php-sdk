<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for hooks and notifications
 */
class ApiHooks extends Libraries\ApiBase
{
    /**
     * Create new hook
     * @param Hook $hook
     * @param string $idempotencyKey Idempotency key for response replication
     * @return Hook Hook object returned from API
     */
    public function Create($hook, $idempotencyKey = null)
    {
        return $this->CreateObject('hooks_create', $hook, '\MangoPay\Hook', null, null, $idempotencyKey);
    }

    /**
     * Get hook
     * @param string $hookId Hook identifier
     * @return Hook Wallet object returned from API
     */
    public function Get($hookId)
    {
        return $this->GetObject('hooks_get', '\MangoPay\Hook', $hookId);
    }

    /**
     * Save hook
     * @param Hook $hook Hook object to save
     * @return Hook Hook object returned from API
     */
    public function Update($hook)
    {
        return $this->SaveObject('hooks_save', $hook, '\MangoPay\Hook');
    }

    /**
     * Get all hooks
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Sorting object
     * @return Hook[] Array with objects returned from API
     * @throws Libraries\Exception
     */
    public function GetAll(& $pagination = null, $sorting = null)
    {
        return $this->GetList('hooks_all', $pagination, '\MangoPay\Hook', null, null, $sorting);
    }
}
