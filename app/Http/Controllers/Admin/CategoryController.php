<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;

class CategoryController extends Controller
{
    public $data = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->data['title_head'] = __('Danh mục tin tức');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function listCategoryPost(){
        $data_category = Category::orderByDESC('id')
            ->get();
        return view('admin.category.index')->with(['data_category' => $data_category, 'data' => $this->data]);
    }

    public function createCategoryPost(){

        return view('admin.category.single', ['data' => $this->data]);
    }

    public function categoryPostDetail($id){
        $this->data['category'] = Category::find($id);
        if($this->data['category']){
            return view('admin.category.single', ['data' => $this->data]);
        } else{
            return view('404');
        }
    }

    public function postCategoryPostDetail(Request $rq){
        $data = request()->all();
        //id post
        $post_id = $data['id'];

        $name = $data['name'];

        $slug = addslashes($data['slug']);
        if(empty($slug) || $slug == ''):
           $slug = Str::slug($name);
        endif;
        

        //xử lý description
        $description = htmlspecialchars($rq->post_description);
        $description_en = htmlspecialchars($rq->post_description_en);

        $save = $rq->submit ?? 'apply';

        //update
        $data_db = array(
            'name' => $name,
            'name_en' => $data['name_en'],
            'slug' => $slug,
            'parent' => $data['category_parent'],
            'description' => $description,
            'description_en' => $description_en,

            'image' => $data['image'] ?? '',
            'cover' => $data['cover'] ?? '',
            'icon' => $data['icon'] ?? '',
            'sort' => $data['sort'] ?? 0,

            'seo_title' => $data['seo_title'] ?? '',
            'seo_keyword' => $data['seo_keyword'] ?? '',
            'seo_description' => $data['seo_description'] ?? '',

            'status' => $data['status'] ?? 0
        );

        if($post_id > 0){
            
            $respons = Category::find($post_id)->update($data_db);
            
        } else{
            $respons = Category::create($data_db);
            $post_id = $respons->id;
            
        }
        if($save=='apply'){
            $msg = "Product has been Updated";
            $url = route('admin.categoryPostDetail', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.listCategoryPost'));
        }
    }
}
