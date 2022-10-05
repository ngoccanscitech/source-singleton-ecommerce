<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CategoryProject;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;

class CategoryProjectController extends Controller
{
    public $path_folder = 'category-project';
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

    public function list(){
        $data_category = CategoryProject::orderByDesc('id')->paginate(20);
        return view('admin.'.$this->path_folder.'.index', compact('data_category'));
    }

    public function create(){
        return view('admin.'.$this->path_folder.'.single');
    }

    public function detail($id){
        $post_category = CategoryProject::findorfail($id);
        if($post_category){
            return view('admin.'.$this->path_folder.'.single')->with(['post_category' => $post_category]);
        } else{
            return view('404');
        }
    }

    public function delete(Request $request){
        $post_list = $request->post_list;
        if(count($post_list)>0){
            foreach ($post_list as $key => $item) {
                $this->delete_submit($item);
            }
            return 'success';
        }
        return '';
    }

    public function delete_id($id)
    {
        $this->delete_submit($id);
        return 'success';    
    }
    public function delete_submit($id)
    {
        CategoryProject::findorfail($id)->delete();
        \App\Model\Join_Category_Project::where('category_id')->delete();
    }

    public function post(Request $rq){
        $datetime_now = date('Y-m-d H:i:s');
        $datetime_convert = strtotime($datetime_now);
        // $data = $rq->all();
        $data = request()->except(['_token', 'gallery', 'variable', 'created', 'submit', 'category']);
        //id post
        $sid = $rq->id ?? 0;
        $data['title'] = $rq->title ?? '';

        $data['slug'] = addslashes($rq->post_slug);
        if($data['slug'] == '')
           $data['slug'] = Str::slug($data['title']);


        $data['description'] = $rq->description ? htmlspecialchars($rq->description) : '' ;
        $data['content'] = $rq->content ? htmlspecialchars($rq->content) : '' ;

        //xử lý gallery
        $galleries = $rq->gallery ?? '';
        if($galleries!=''){
            $galleries = array_filter($galleries);
            $data['gallery'] = $galleries ? serialize($galleries) : '';

        }
        //end xử lý gallery

        $data['stt'] = $rq->stt ? addslashes($rq->stt) : 0;
        // $data['admin_id'] = Auth::guard('admin')->user()->id;

        $save = $rq->submit ?? 'apply';

        if($sid > 0){
            $post_id = $sid;
            $respons = CategoryProject::where("id", $sid)->update($data);
        } else{
            $respons = CategoryProject::create($data);
            $id_insert = $respons->id;
            $post_id = $id_insert;
        }

        if($save=='apply'){
            $msg = "Danh mục Dự án thực hiện thành công";
            $url = route('admin.project.category.edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.project.category'));
        }
    }
}
