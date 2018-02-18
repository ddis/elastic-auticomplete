<?php

namespace App\Console\Commands;

use App\Articles;
use Curl\Curl;
use FastSimpleHTMLDom\Document;
use Illuminate\Console\Command;

class ParseCommand extends Command
{
    protected $curl;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->curl = $this->initCurl();

        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        for ($i =0; $i < 100000; $i++) {
            $data = $this->getData(100);
            try {
                Articles::insert($data);
            } catch (\Exception $exception) {
                continue;
            }
        }
    }

    /**
     * @param int $limit
     * @return array
     * @throws \Exception
     */
    protected function getData($limit = 1)
    {
        $data = [];
        for ($i = 1; $i <= $limit; $i++) {
            $document = $this->getRandArticle();
            list($title, $text) = $this->parseInfo($document);
            $data[] = [
                'title' => $title,
                'text' => $text
            ];
        }
        return $data;
    }

    protected function parseInfo(string $document): array
    {
        $doc = (new Document())->load($document);

        $title = $doc->find('#firstHeading')->plaintext;
        $text = $doc->find('#mw-content-text')->plaintext;

        return [$title, $text];
    }

    protected function getRandArticle()
    {
        $response = $this->curl->get('https://en.wikipedia.org/wiki/Special:Random');

        if ($response->error) {
            throw new \Exception($response->error_message);
        }

        return $response->response;
    }

    protected function initCurl()
    {
        $curl = new Curl();

        $curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);

        return $curl;
    }
}
