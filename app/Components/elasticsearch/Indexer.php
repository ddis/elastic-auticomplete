<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy Sokolov
 * Date: 09.02.2018
 * Time: 15:06
 */

namespace App\Components\elasticsearch;

use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use ms\components\elasticsearch\entities\BasicEntity;
use ms\components\mapper\Mapper;
use Phalcon\Di;
use Phalcon\Exception;

class Indexer
{
    #region [properties]
    protected        $client;
    protected static $instances = [];

    #endregion

    /**
     * ElasticSearch constructor.
     */
    #region [constructor]
    public function __construct()
    {
        $this->client = ElasticClient::getInstance()->getClient();
    }
    #endregion

    #region [public methods]

    /**
     * @param array  $data
     * @param string $entity
     * @return array
     */
    public function insertBulk(array $data, string $entity): array
    {
        $params   = [];
        $instance = ElasticClient::makeEntityInstance($entity);

        foreach ($data as $id => $item) {
            $params['body'][] = [
                'index' => [
                    '_index' => $instance->getIndexName(),
                    '_type'  => $instance->getIndexType(),
                    '_id'    => $id,
                ],
            ];
            $params['body'][] = $item;
        }

        return $this->client->bulk($params);
    }

    #endregion
}