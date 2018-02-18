<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Sokolov
 * Date: 12.02.2018
 * Time: 14:52
 */

namespace App\Components\elasticsearch\entities;


use App\Components\elasticsearch\mapping\WikiMapping;

class Wiki extends BasicEntity
{
    use WikiMapping;

    #region [public methods]

    /**
     * List of required fields for indexing
     * @return array
     */
    public function requiredFields(): array
    {
        return [
            'title',
            'text',
        ];
    }

    /**
     * Name of the attribute field
     * @return string
     */
    public function attributeName(): string
    {
        return '';
    }

    /**
     * List of fields for required relationship
     * @return array
     */
    public function scopeRelation(): array
    {
        return [];
    }

    /**
     * List of fields for translate
     * @return array
     */
    public function translateFields(): array
    {
        return [];
    }
    #endregion
}