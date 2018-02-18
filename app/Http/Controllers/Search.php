<?php
/**
 * Created by PhpStorm.
 * User: ddis
 * Date: 18.02.2018
 * Time: 15:02
 */

namespace App\Http\Controllers;


use App\Components\elasticsearch\ElasticClient;
use Illuminate\Http\Request;

class Search extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function find(Request $request)
    {
        $query = $request->get('query');

        $elastic = ElasticClient::getInstance()->getClient();
        $entity = ElasticClient::makeEntityInstance('wiki');

        $index = $entity->getIndexName();
        $type  = $entity->getIndexType();

        $params = [
            'index' => $index,
            'type' => $type,
            'body' => [
                '_source' => ['title', '_id'],
                'suggest' => [
                    'suggest' => [
                        'prefix' => $query,
                        'completion' => [
                            'field' => 'title_suggest'
                        ]
                    ]
                ]
            ]
        ];

        return $elastic->search($params);
    }
}