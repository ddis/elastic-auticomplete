<?php

namespace App\Console\Commands\Elastic;

use App\Articles;
use App\Components\elasticsearch\Mapping;
use Curl\Curl;
use FastSimpleHTMLDom\Document;
use Illuminate\Console\Command;

class DeleteMapCommand extends Command
{
    protected $curl;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic-mapper:delete {entity : The name of entity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Map map';

    public function getArguments()
    {
        return ['name'];
    }

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

        return $mapping->delete();
    }
}
