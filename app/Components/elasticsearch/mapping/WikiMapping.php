<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Sokolov
 * Date: 12.02.2018
 * Time: 14:55
 */

namespace App\Components\elasticsearch\mapping;

use App\Components\elasticsearch\Analyzer;

trait WikiMapping
{
    #region [public methods]
    /**
     * List of fields for indexing
     * @return array
     */
    public function getProperties(): array
    {
        $map = [
            'title' => [
                'type' => 'text',
                'fields' => [
                    'edgengram' => [
                        'type' => 'text',
                        'analyzer' => 'edge_ngram_analyzer',
                        'search_analyzer' => 'edge_ngram_search_analyzer',
                    ]
                ]
            ],
            'text' => [
                'type' => 'text',
                'analyzer' => Analyzer::getAnalyzer('en')['analyzer'],
            ]
        ];

        return $map;
    }

    /**
     * Dynamic index map
     * @return array
     */
    public function getDynamic(): array
    {
        return [];
    }
    #endregion
}