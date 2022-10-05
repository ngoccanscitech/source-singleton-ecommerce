<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\News;
use App\Page;
use App\NewsCategory as Category;

class NewsController extends Controller
{
    use \App\Traits\LocalizeController;
    
    public $data = [];
    
    public function index() {
        return $this->categoryDetail('news');
    }
    
    public function newsDetail($slug){
        $this->localized();
        $news = (new News)->getDetail($slug, $type = 'slug');
        $this->data['category'] = $news->category->first();
        $this->data['category_child'] = Category::where('parent', 1)->get();
        $this->data['news'] = $news;
        // $this->data['news_featured'] = News::orderbyDesc('id')->limit(3)->get();
        $tintuc = Category::find(1);
        $this->data['news_featured'] = $tintuc->news()->where('status', 1)->limit(3)->get();

        $this->data['seo'] = [
            'seo_title' => $news->seo_title!=''? $news->seo_title : $news->name,
            'seo_image' => $news->image,
            'seo_description'   => $news->seo_description ?? '',
            'seo_keyword'   => $news->seo_keyword ?? '',

        ];
        // dd($this->data['seo']);
        return view($this->templatePath .'.news.single', $this->data);
    }
    
    public function categoryDetail($slug){
        $this->localized();
        $this->data['category'] = Category::all();
        $category_current = Category::where('slug', $slug)->first();
        if($category_current){
            $this->data['category_current'] = $category_current;
            $this->data['category_child'] = Category::where('parent', 1)->get();
            // $this->data['page'] = $this->data['current'];
            $this->data['news'] = $this->data['category_current']->news()->where('status', 1)->paginate(12);

            $news = Category::find(1);
            $this->data['news_featured'] = $news->news()->where('status', 1)->limit(3)->get();

            $this->data['seo'] = [
                'seo_title' => $category_current->seo_title!=''? $category_current->seo_title : $category_current->name,
                'seo_image' => $category_current->image,
                'seo_description'   => $category_current->seo_description ?? '',
                'seo_keyword'   => $category_current->seo_keyword ?? '',

            ];
            // dd($this->data['category_current']);
            return view($this->templatePath .'.news.index', $this->data);
        }
        else
            return $this->newsDetail($slug);
    }
}
