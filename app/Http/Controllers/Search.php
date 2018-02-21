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
    {        $query = $request->get('query');

        $elastic = ElasticClient::getInstance()->getClient();
        $entity = ElasticClient::makeEntityInstance('wiki');

        $index = $entity->getIndexName();
        $type  = $entity->getIndexType();

        $params = [
            'index' => $index,
            'type' => $type,
            'body' => [
                '_source' => ['title', '_id'],
                'size' => 10,
                'query' => [
                    'match' => [
                        'title.autocomplete' => $query,
                    ]
                ],
                'highlight' => [
                    'pre_tags' => '<em style="color: #bf5329">',
                    'post_tags' => '</em>',
                    'fields' => [
                        'title.autocomplete' => [
                            'type' => 'fvh'
                        ]
                    ]
                ]
            ]
        ];

        return $elastic->search($params);
    }
}