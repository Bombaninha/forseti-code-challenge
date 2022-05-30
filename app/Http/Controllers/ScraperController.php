<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use Goutte\Client;
use Carbon\Carbon;

use App\Models\Tiding;

class ScraperController extends Controller
{
    private $results = array();

    public function index()
    {
        $tidings = Tiding::all();
        return view('scraper.scraper', compact('tidings'));
    }

    public function scraper()
    {
        $itemsPerPage = 30;
        $totalPages = 5;

        $totalRecords = $itemsPerPage * $totalPages;

        for($i = 0; $i < $totalRecords; $i = $i + $itemsPerPage) {
            $client = new Client();
            $url = "https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias?b_start:int=$i";
            $page = $client->request('GET', $url);
    
            $page->filter('.tileItem')->each(function($node) {
                $linkNode = $node->filter('.url');
                $dateNode = $node->filter('.summary-view-icon');
    
                $link = $linkNode->attr('href');
                $title = $linkNode->text();
    
                $date = $dateNode->eq(0)->text();
                $hours = Str::replace('h', ':', $dateNode->eq(1)->text());
    
                $timestamp = Carbon::createFromFormat('d/m/Y H:i', $date . ' ' . $hours)->toDateTimeString();
                
                $item = array(
                    'title' => $title,
                    'link' => $link,
                    'posted_at' => $timestamp
                );
                
                array_push($this->results, $item);
            });
        }

        Tiding::insert($this->results);

        return redirect()->route('index');
        /*
        foreach($this->results as $tiding) {
            Tiding::create([
                'title' => $tiding['title'],
                'link' => $tiding['link'],
                'posted_at' => $tiding['']
            ]);
        }
        */
        //$temp = array_unique(array_column($this->results, 'link'));
        //$unique_arr = array_intersect_key($this->results, $temp);
        //return view('scraper.scraper');
        //dd($this->results, $unique_arr);
    }
}