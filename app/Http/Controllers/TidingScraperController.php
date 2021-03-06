<?php

namespace App\Http\Controllers;

use App\Models\Tiding;

use App\Services\ComprasnetService;

class TidingScraperController extends Controller
{
    public function scrap()
    {

        $comprasnetService = new ComprasnetService();
        $newTidings = $comprasnetService->scrapMultiplePagesWithPaginator(30, 5, 'https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias', 'b_start:int');
        
        Tiding::insert($newTidings);
        return redirect()->back();
    }
}