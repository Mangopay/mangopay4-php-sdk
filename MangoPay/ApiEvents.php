<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for cards
 */
class ApiEvents extends Libraries\ApiBase
{
    /**
     * Get events
     * @param Pagination $pagination Pagination object
     * @param FilterEvents $filter Object to filter data
     * @param Sorting $sorting Object to sorting data
     *
     * @return Event[] Events list
     */
    public function GetAll(& $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('events_all', $pagination, '\MangoPay\Event', null, $filter, $sorting);
    }
}
