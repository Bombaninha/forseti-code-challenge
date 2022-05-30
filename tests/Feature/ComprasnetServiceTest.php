<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;

use Goutte\Client;

use App\Services\ComprasnetService;

class ComprasnetServiceTest extends TestCase
{
    public function test_if_comprasnet_page_is_working()
    {
        $url = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias';
        $response = Http::get($url);

        $this->assertSame(200, $response->status());
    }

    public function test_extract_date_comprasnet_service_returns_array()
    {
        $url = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias';
        $client = new Client();
        $page = $client->request('GET', $url);
        
        $dateNode = $page->filter('div#content-core article.tileItem')->first()->filter('.summary-view-icon');

        $comprasnetService = new ComprasnetService();
        $this->assertTrue(Arr::accessible($comprasnetService->extractDateInformation($dateNode)));
    }

    public function test_if_extract_date_information_comprasnet_service_is_working()
    {
        $url = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias';
        $client = new Client();
        $page = $client->request('GET', $url);
        
        $dateNode = $page->filter('div#content-core article.tileItem')->first()->filter('.summary-view-icon');

        $comprasnetService = new ComprasnetService();
        $date = $comprasnetService->extractDateInformation($dateNode);

        $this->assertSame($date['posted_at'], '2022-05-25 16:36:00');
    }

    public function test_extract_link_information_comprasnet_service_returns_array()
    {
        $url = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias';
        $client = new Client();
        $page = $client->request('GET', $url);
        
        $linkNode = $page->filter('div#content-core article.tileItem')->first()->filter('.url');

        $comprasnetService = new ComprasnetService();
        $this->assertTrue(Arr::accessible($comprasnetService->extractLinkInformation($linkNode)));
    }

    public function test_extract_link_information_comprasnet_service_link_is_working()
    {
        $url = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias';
        $client = new Client();
        $page = $client->request('GET', $url);
        
        $linkNode = $page->filter('div#content-core article.tileItem')->first()->filter('.url');

        $comprasnetService = new ComprasnetService();
        $link = $comprasnetService->extractLinkInformation($linkNode);
        
        $this->assertSame($link['link'], 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias/instrucao-normativa-rfb-no-2-082-de-18-de-maio-de-2022-prorroga-o-prazo-de-entrega-da-escrituracao-contabil-digital-ecd-referente-ao-ano-calendario-de-2021');
    }

    public function test_extract_link_information_comprasnet_service_title_is_working()
    {
        $url = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias';
        $client = new Client();
        $page = $client->request('GET', $url);
        
        $linkNode = $page->filter('div#content-core article.tileItem')->first()->filter('.url');

        $comprasnetService = new ComprasnetService();
        $title = $comprasnetService->extractLinkInformation($linkNode);
        
        $this->assertSame($title['title'], 'Instrução Normativa RFB nº 2.082, de 18 de maio de 2022 - Prorroga o prazo de entrega da Escrituração Contábil Digital (ECD) referente ao ano-calendário de 2021.');
    }

    public function test_scrap_single_page_comprasnet_service_returns_array()
    {
        $url = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias';
        $comprasnetService = new ComprasnetService();

        $this->assertTrue(Arr::accessible($comprasnetService->scrapSinglePage($url)));
    }   

    public function test_number_of_tidings_in_one_page()
    {
        $url = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias';
        $client = new Client();
        $page = $client->request('GET', $url);

        $this->assertCount(30, $page->filter('div#content-core article.tileItem'));
    }

    public function test_scrap_single_page_comprasnet_service_link_is_working()
    {
        $url = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias';
        $comprasnetService = new ComprasnetService();

        $result = $comprasnetService->scrapSinglePage($url);
        
        $this->assertSame($result[0]['link'], 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias/instrucao-normativa-rfb-no-2-082-de-18-de-maio-de-2022-prorroga-o-prazo-de-entrega-da-escrituracao-contabil-digital-ecd-referente-ao-ano-calendario-de-2021');
    }  

    public function test_scrap_single_page_comprasnet_service_title_is_working()
    {
        $url = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias';
        $comprasnetService = new ComprasnetService();

        $result = $comprasnetService->scrapSinglePage($url);
        
        $this->assertSame($result[0]['title'], 'Instrução Normativa RFB nº 2.082, de 18 de maio de 2022 - Prorroga o prazo de entrega da Escrituração Contábil Digital (ECD) referente ao ano-calendário de 2021.');
    }  

    public function test_scrap_single_page_comprasnet_service_posted_at_is_working()
    {
        $url = 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias';
        $comprasnetService = new ComprasnetService();

        $result = $comprasnetService->scrapSinglePage($url);
        
        $this->assertSame($result[0]['posted_at'], '2022-05-25 16:36:00');
    }  

    public function test_scrap_multiple_pages_with_paginator_comprasnet_service_returns_array()
    {
        $comprasnetService = new ComprasnetService();

        $result = $comprasnetService->scrapMultiplePagesWithPaginator(30, 5, 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias', 'b_start:int');
        
        $this->assertTrue(Arr::accessible($result));      
    }

    public function test_scrap_multiple_pages_with_paginator_comprasnet_service_returns_right_number_of_records()
    {
        $comprasnetService = new ComprasnetService();

        $result = $comprasnetService->scrapMultiplePagesWithPaginator(30, 5, 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias', 'b_start:int');
        
        $this->assertCount(150, $result);      
    }
}
