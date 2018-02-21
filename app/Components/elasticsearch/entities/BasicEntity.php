<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Sokolov
 * Date: 12.02.2018
 * Time: 14:51
 */

namespace App\Components\elasticsearch\entities;

abstract class BasicEntity
{
    protected $langs = [];

    /**
     * BasicEntity constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $props = array_keys(get_object_vars($this));

        foreach ($props as $prop) {
            $this->{$prop} = $params[$prop] ?? $this->{$prop};
        }
    }
    #region [public methods]

    /**
     * Return elasticsearch schema
     * @return array
     */
    public function getMapping(): array
    {
        $index = $this->getIndexName();
        $type  = $this->getIndexType();

        return [
            'index' => $index,
            'body'  => [
                'settings' => [
                    "analysis" => [
                        'analyzer' => [
                            'autocomplete' => [
                                'type' => 'custom',
                                'tokenizer' => 'standard',
                                'filter' => [
                                    'lowercase',
                                    'shingle_filter',
                                    'autocomplete_filter'
                                ]
                            ]
                        ],
                        'filter' => [
                            'autocomplete_filter' => [
                                'type' => 'edge_ngram',
                                'min_gram' => 2,
                                'max_gram' => 12,
                            ],
                            'shingle_filter' => [
                                'type' => 'shingle',
                                'min_shingle_size' => 2,
                                'max_shingle_size' => 12,
                            ]
                        ]
                    ],
                ],
                'mappings' => [
                    $type => [
                        'properties'        => $this->getProperties(),
                        'dynamic_templates' => $this->getDynamic(),
                    ],
                ],
            ],
        ];
    }

    /**
     * Get languages list
     * @return array
     */
    public function getLangs()
    {
        return $this->langs;
    }

    /**
     * Return index name
     * @return string
     */
    public function getIndexName(): string
    {
        return "sm-" . $this->getIndexType();
    }

    /**
     * Return index type
     * @return string
     */
    public function getIndexType(): string
    {
        return strtolower((new \ReflectionClass(get_called_class()))->getShortName());
    }
    #endregion

    #region [abstract methods]
    /**
     * List of fields for indexing
     * @return array
     */
    abstract function getProperties(): array;

    /**
     * Dynamic index map
     * @return array
     */
    abstract function getDynamic(): array;

    /**
     * List of required fields for indexing
     * @return array
     */
    abstract function requiredFields(): array;

    /**
     * Name of the attribute field
     * @return string
     */
    abstract function attributeName(): string;

    /**
     * List of fields for required relationship
     * @return array
     */
    abstract function scopeRelation(): array;

    /**
     * Field where has translations
     */
    abstract function translateFields(): array;
    #endregion
}