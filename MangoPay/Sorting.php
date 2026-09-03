<?php

namespace MangoPay;

/**
 * Base sorting object
 */
class Sorting
{
    /**
     * Fields separator in sort parameters in URL
     */
    public const SortFieldSeparator = "_";

    /**
     * Fields separator in sort parameters in URL
     */
    public const SortUrlParameterName = "Sort";

    /**
     * Array with fields to sort
     * @var array
     */
    private $_sortFields = [];

    /**
     * Add filed to sort
     * @param string $fieldName Property name to sort
     * @param string $sortDirection Sort direction (ASC | DESC)
     */
    public function AddField($fieldName, $sortDirection)
    {
        $this->_sortFields[$fieldName] = $sortDirection;
    }

    /**
     * @deprecated Contains typo, kept for backward compatibility
     */
    public function AddFiled($fieldName, $sortDirection)
    {
        //for backward compatibility from before typo fix
        $this->AddField($fieldName, $sortDirection);
    }
    /**
     * Get sort parametrs to URL
     * @return array
     */
    public function GetSortParameter()
    {
        return [self::SortUrlParameterName => $this->_getFields()];
    }

    private function _getFields()
    {
        $sortValues = "";
        foreach ($this->_sortFields as $key => $value) {
            if (!empty($sortValues)) {
                $sortValues .= self::SortFieldSeparator;
            }

            $sortValues .= $key . ":" . $value;
        }

        return $sortValues;
    }
}
