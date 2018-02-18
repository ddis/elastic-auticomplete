<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.02.2018
 * Time: 10:56
 */

namespace App\Components\elasticsearch;


use App\Components\elasticsearch\entities\BasicEntity;
use Elasticsearch\ClientBuilder;

final class ElasticClient
{
    /**
     * @var null
     */
    private static $instance = null;
    protected static $instances = [];
    private $client;

    /**
     * ElasticClient constructor.
     */
    private function __construct()
    {
        $config = [
            'host' => 'localhost',
            'port' => '9200',
            'scheme' => 'http',
            'user' => '',
            'pass' => ''
        ];

        $this->client = ClientBuilder::create()
            ->setHosts([$config])
            ->build();
    }

    /**
     * @return bool
     */
    private function __clone()
    {
        return false;
    }

    /**
     * @return \Elasticsearch\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return ElasticClient|null
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param $index
     * @return object|BasicEntity
     */
    public static function makeEntityInstance($index, $params = [])
    {
        if (!isset(self::$instances[$index])) {
            $instance = new \ReflectionClass("App\\Components\\elasticsearch\\entities\\" . ucfirst($index));
            self::$instances[$index] = $instance->newInstance($params);
        }

        return self::$instances[$index];
    }

}