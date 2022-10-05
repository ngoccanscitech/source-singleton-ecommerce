<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Variable;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;

class VariableProductController extends Controller
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

    public function listVariableProduct(){
        $data_variable = Variable::where('parent', 0)
            ->orderByDesc('id')
            ->paginate(20);
        return view('admin.variable.index')->with(['data_variable' => $data_variable]);
    }
    public function searchVariableProduct(Request $rq){
        if($rq->search_title != ''){
            $data_variable = Variable::where('name', 'LIKE', '%'.$rq->search_title.'%')
                ->orderByDesc('id')
                ->paginate(20);
        } else{
            $data_variable = Variable::orderByDesc('id')->paginate(20);
        }
        return view('admin.variable.search')->with(['data_variable' => $data_variable]);
    }
    public function createVariableProduct(){
        return view('admin.variable.single');
    }

    public function variableProductDetail($id){
        $post_variable = Variable::findorfail($id);
        if($post_variable){
            return view('admin.variable.single')->with(['post_variable' => $post_variable]);
        } else{
            return view('404');
        }
    }

    public function postVariableProductDetail(Request $rq){
        //id post
        $sid = $rq->sid;
        $post_id = $sid;

        $title_new = $rq->post_title;

        $title_slug = addslashes($rq->post_slug);
        if(empty($title_slug) || $title_slug == ''):
           $title_slug = Str::slug($title_new);
        endif;
        $category_parent = (int)$rq->category_parent;

        //xử lý description
        $description = $rq->post_description;
        $description_en = $rq->post_description_en;

        //xử lý thumbnail
        $save = $rq->submit ?? 'apply';

        $data = array(
            'name' => $title_new,
            'name_en' => $rq->post_title_en ?? '',
            'slug' => $title_slug,
            'parent' => $category_parent,
            'description' => $description,
            'description_en' => $description_en,
            'image' => $rq->image ?? '',
            'cover' => $rq->cover ?? '',
            'icon' => $rq->icon ?? '',
            'seo_title' => $rq->seo_title ?? '',
            'seo_keyword' => $rq->seo_keyword ?? '',
            'seo_description' => $rq->seo_description ?? '',
            'status' => $rq->status ?? 0,
            'type' => $rq->type ?? '',
            'stt' => $rq->stt ?? 0,
        );
        if($sid > 0){
            $respons = Variable::where ("id", $sid)->update($data);
        } else{
            $respons = Variable::create($data);
            $id_insert= $respons->id;
            $post_id= $respons->id;
        }

        if($save=='apply'){
            $msg = "Post has been Updated";
            $url = route('admin.variableProductDetail', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.listVariableProduct'));
        }
        
    }
}
