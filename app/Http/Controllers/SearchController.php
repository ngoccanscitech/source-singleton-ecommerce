<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\News;
use App\Product;
use Carbon\Carbon;

class SearchController extends Controller
{
     use \App\Traits\LocalizeController;
    public $data = [];

    public function index(Request $rq){
        $this->localized();
        $this->data['keyword'] = $rq->input('keyword', '');
        
        if($this->data['keyword']){
            $this->data['result'] = true;
            $this->data['products'] = Product::search($this->data['keyword']);
            
            return view('theme.search', $this->data);
        } else {
            $this->data['result'] = false;
            return view('theme.search', $this->data);
        }
    }
}
