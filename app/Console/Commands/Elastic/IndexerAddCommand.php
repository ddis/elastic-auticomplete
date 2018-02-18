<?php

namespace App\Console\Commands\Elastic;

use App\Articles;
use App\Components\elasticsearch\ElasticClient;
use App\Components\elasticsearch\Indexer;
use App\Components\elasticsearch\Mapping;
use Curl\Curl;
use FastSimpleHTMLDom\Document;
use Illuminate\Console\Command;

class IndexerAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic-indexer:add {entity : The name of entity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add data to index';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $entity = $this->argument('entity');

        $mapper = new Mapping($entity);

        if ($mapper->getMapping()){
            $mapper->delete();
        }
        $mapper->create();

        $indexer = new Indexer();

        Articles::where('display', 1)->chunk(200, function ($items) use ($indexer, $entity){
            $data = [];
            foreach ($items as $item) {
                $data[$item->id] = [
                    'text' => $item->text,
                    'title' => $item->title
                ];
            }
            $indexer->insertBulk($data, $entity);
        });
    }
}
