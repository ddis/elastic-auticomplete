<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.02.2018
 * Time: 14:28
 */

namespace App\Components\elasticsearch;


class Analyzer
{
    /**
     * List languages analyzers
     * @var array
     */
    private static $analyzers = [
        'nl'      => [
            'analyzer' => 'dutch',
        ],
        'en'      => [
            'analyzer' => 'english',
        ],
        'fr'      => [
            'analyzer' => 'french',
        ],
        'default' => [
            'analyzer' => 'standard',
        ],
    ];

    /**
     * Get analyzer by lang code
     * @param $code
     * @return mixed
     */
    public static function getAnalyzer($code)
    {
        return self::$analyzers[$code] ?? self::$analyzers['default'];
    }
}