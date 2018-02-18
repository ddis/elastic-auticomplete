<?php

namespace App\Console\Commands\Elastic;

use App\Articles;
use App\Components\elasticsearch\ElasticClient;
use App\Components\elasticsearch\Mapping;
use Curl\Curl;
use FastSimpleHTMLDom\Document;
use Illuminate\Console\Command;

class CreateMapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic-mapper:create {entity : The name of entity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create map';

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
        $mapping = new Mapping($entity);

        return $mapping->create();
    }
}
