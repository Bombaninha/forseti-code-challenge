<?php

namespace App\Services;

use Illuminate\Support\Str;

use Goutte\Client;
use Carbon\Carbon;

use Symfony\Component\DomCrawler\Crawler;

class ComprasnetService {

    // Captura a data de um nodo e coloca no formato d-m-Y H:i:s
    public function extractDateInformation(Crawler $dateNode) : array {
        $date = $dateNode->eq(0)->text();
        $hours = Str::replace('h', ':', $dateNode->eq(1)->text());

        $timestamp = Carbon::createFromFormat('d/m/Y H:i', $date . ' ' . $hours)->toDateTimeString();

        return array(
            'posted_at' => $timestamp
        ); 
    }

    // Extraí informações de um link (link e título)
    public function extractLinkInformation(Crawler $linkNode) : array {
        $link = $linkNode->attr('href');
        $title = $linkNode->text();

        return array(
            'title' => $title,
            'link' => $link,
        );
    }

    // Extraí informações necessárias de uma única página
    public function scrapSinglePage(string $url) : array {
        $client = new Client();
        $page = $client->request('GET', $url);

        $items = collect();

        $page->filter('div#content-core article.tileItem')->each(function($node) use ($items) {
            $linkNode = $node->filter('.url');
            
            $link = $linkNode->attr('href');
            $title = $linkNode->text();
            
            $linkInfo = $this->extractLinkInformation($node->filter('.url'));
            $dateInfo = $this->extractDateInformation($node->filter('.summary-view-icon'));

            $item = array_merge($linkInfo, $dateInfo);
            
            $items->push($item);
        });

        return $items->toArray();
    }

    // Extraí informações necessárias de múltiplas páginas que possuem um paginador
    public function scrapMultiplePagesWithPaginator(int $itemsPerPage, int $totalOfPages, string $baseUrl, string $urlParam) : array {
        $allItems = collect();

        $totalNumberOfRecords = $itemsPerPage * $totalOfPages;

        for($i = 0; $i < $totalNumberOfRecords; $i = $i + $itemsPerPage) {
            $url = "$baseUrl?$urlParam=$i";
            $allItems = $allItems->merge($this->scrapSinglePage($url));
        }

        return $allItems->toArray();
    }
}