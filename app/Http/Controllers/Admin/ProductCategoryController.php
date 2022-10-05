<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ShopCategory;
use App\Libraries\Helpers;
use App\Model\ShopProduct;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Support\Facades\Response;

class ProductCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $categories = ShopCategory::where('parent', 0)->orderBy('id')->paginate(20);
        
        return view('admin.product-category.index', compact('categories'));
    }

    public function create(){
        return view('admin.product-category.single');
    }

    public function edit($id){
        $category = ShopCategory::find($id);
        if($category){
            return view('admin.product-category.single', compact('category'));
        } else{
            return view('404');
        }
    }

    public function post(Request $rq){
        $data = request()->all();
        //id post
        $sid = $data['id'];
        $post_id = $sid;

        $name = $data['name'];

        $slug = addslashes($data['slug']);
        if(empty($slug) || $slug == '')
           $slug = Str::slug($name);


        $save = $rq->submit ?? 'apply';

        $data_db = array(
            'name' => $name,
            'slug' => $slug,
            'description' => $data['description'] ? htmlspecialchars($data['description']) : '',

            'name_en' => $data['name_en'],
            'description_en' => $data['description_en'] ? htmlspecialchars($data['description_en']) : '',

            'priority' => $data['post_short'] ?? 0,
            'status' => $data['status'] ?? 0,

            'image' => $data['image'] ?? '',
            'cover' => $data['cover'] ?? '',
            'icon' => $data['icon'] ?? '',

            'parent' => $data['parent'] ?? '',

            'seo_title' => $data['seo_title'] ?? '',
            'seo_keyword' => $data['seo_keyword'] ?? '',
            'seo_description' => $data['seo_description'] ?? '',
        );

        if($sid > 0){
            $respons = ShopCategory::where('id', $sid)->update($data_db);

        } else{
            $respons = ShopCategory::create($data_db);
            $post_id = $respons->id;
        }

        if($save=='apply'){
            $msg = "Product has been Updated";
            $url = route('admin.categoryProductDetail', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.listCategoryProduct'));
        }
    }

    public function getCategoryCheckList($id = 0){
        $data['success'] = false;
        $data['content'] = '';
        if($id){
            $categories = ShopCategory::where('parent', $id)->get();
            $checklist = request()->input('cat', []);
            if($categories && $categories->count()){
                $data['success'] = true;
                $data['content'] = view('admin.product-category.category-checklist', ['categories' => $categories, 'checklist' => $checklist])->render();
            }
        }
        return Response::json($data);
    }
}
