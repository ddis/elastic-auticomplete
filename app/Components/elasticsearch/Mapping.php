<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15.02.2018
 * Time: 10:17
 */

namespace App\Components\elasticsearch;

class Mapping
{
    private $client         = null;
    private $entityInstance = null;
    private $langs          = [];

    /**
     * Mapping constructor.
     * @param string $entity
     * @param array  $langs
     */
    public function __construct(string $entity, array $langs = [])
    {
        $this->client         = ElasticClient::getInstance()->getClient();
        $this->langs          = $langs;
        $this->entityInstance = ElasticClient::makeEntityInstance($entity, ['langs' => $this->langs]);
    }

    /**
     * Create map
     * @param bool $deleteMap
     * @return array
     */
    public function create(bool $deleteMap = false): array
    {
        if ($deleteMap) {
            $this->delete();
        }

        return $this->client->indices()->create($this->entityInstance->getMapping());
    }

    /**
     * Update map
     * @param $props
     * @return array|bool
     */
    public function update(array $props)
    {
        if (!$props) {
            return false;
        }

        $params = [
            'index' => $this->entityInstance->getIndexName(),
            'type'  => $this->entityInstance->getIndexType(),
            'body'  => [
                $this->entityInstance->getIndexType() => [
                    '_source'    => [
                        'enabled' => true,
                    ],
                    'properties' => $props,
                ],
            ],
        ];

        return $this->client->indices()->putMapping($params);
    }

    /**
     * Delete map
     * @return bool
     */
    public function delete()
    {
        $params = ['index' => $this->entityInstance->getIndexName()];
        if ($this->getMapping()) {
            $this->client->indices()->delete($params);
        }

        return true;
    }

    /**
     * Get map
     * @return array|bool
     */
    public function getMapping()
    {
        try {
            $params = ['index' => $this->entityInstance->getIndexName()];

            return $this->client->indices()->getMapping($params);
        } catch (\Exception $e) {
            return false;
        }
    }
}