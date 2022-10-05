<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page as Page;
use Illuminate\Support\Facades\View;
use Gornymedia\Shortcodes\Facades\Shortcode;
use Carbon\Carbon;
use App\Product;

class PageController extends Controller {
    use \App\Traits\LocalizeController;
    
    public $data = [];


    // $this->templatePath
    public function index() {
        $this->localized();
        $page = Page::where('slug', 'home')->first();
        $this->data['page'] = $page;
        $this->data['news'] = \App\News::with('category')
            ->whereHas('category', function($query){
                return $query->where('id', 1);
            })
            ->where('status', 1)->orderbyDesc('id')->limit(4)->get();
        
        $this->data['project'] = \App\Model\Project::where('status', 0)->orderbyDesc('id')->limit(10)->get();
        $this->data['categories'] = \App\ProductCategory::where('status', 1)->where('parent', 0)->orderby('priority')->limit(12)->get();

        $this->data['products'] = \App\Product::orderbyDesc('id')->limit(10)->get();
        $this->data['flash_sale'] = (new Product)->FlashSale();

        $this->data['seo'] = [
            'seo_title' => $page->seo_title!=''? $page->seo_title : $page->title,
            'seo_image' => $page->image,
            'seo_description'   => $page->seo_description ?? '',
            'seo_keyword'   => $page->seo_keyword ?? '',

        ];
        
        return view($this->templatePath .'.home', $this->data);
    }

    public function page($slug) {
        $this->localized();
        if ('home' == $slug || 'trangchu' == $slug) {
            return $this->index();
        }

        $this->data['listLocation'] = $this->listLocation();


        $page = Page::where('slug', $slug)->first();
        // dd($page);
        if($page->template=='project')
            return $this->project($slug);

        $this->data['page'] = $page;
        $templateName = $this->templatePath .'.page.' . $slug;
        if (View::exists($templateName)) {
            return view($templateName,  $this->data)->compileShortcodes();
        } else {
            return view($this->templatePath .'.page.index', ['data' => $this->data]);
        }
    }

    public function project($slug)
    {
        return \App::call('App\Http\Controllers\ProjectController@index',  [
            "slug" => $slug
        ]);
    }

    public function listLocation()
    {
        $data = array(
            'mienbac'   => 'Miền Bắc',
            'mientrung'   => 'Miền Trung',
            'miennam'   => 'Miền Nam'
        );
        return $data;
    }

}
