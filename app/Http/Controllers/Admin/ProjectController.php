<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Project, App\Model\Category, App\Model\Join_Category_Project, App\Model\Project_Join_Variable;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

class ProjectController extends Controller
{
    public $path_folder = 'project';
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
        $data_post = Project::orderByDesc('id')->paginate(20);
        return view('admin.'.$this->path_folder.'.index', compact('data_post'));
    }

    public function create(){
        $variables_selected = [];
        $category_selected = [];
        return view('admin.'.$this->path_folder.'.single', compact('category_selected', 'variables_selected'));
    }

    public function detail($id){
        $categories = \App\Model\Join_Category_Project::where('project_id', $id)->get('category_id');
        $category_selected = [];
        foreach ($categories as $key => $item) {
            $category_selected[] = $item->category_id;
        }
        $variables_join = \App\Model\Project_Join_Variable::where('project_id', $id)->get();
        // dd($variables_join);
        $variables_selected = [];
        foreach ($variables_join as $key => $item) {
            $variables_selected[] = $item->variable_id;
        }

        $post_detail = Project::findorfail($id);
        if($post_detail){
            return view('admin.'.$this->path_folder.'.single', compact('category_selected', 'variables_selected', 'post_detail', 'variables_join'));
        } else{
            return view('404');
        }
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

        $data['price'] = $rq->price ? str_replace(',', '', $rq->price) : 0;
        $data['acreage'] = $rq->acreage ? str_replace(',', '', $rq->acreage) : 0;

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

        $variables = $rq->variable ? array_filter($rq->variable) : '' ;
        if($sid > 0){
            $post_id = $sid;
            Join_Category_Project::where('project_id', $sid)->delete();
            if($variables!=''){
                $variables_id = array_column($variables, 'id');
                $test = Project_Join_Variable::whereNotIn('variable_id', $variables_id)->where('project_id', $sid)->delete();
                // dd($test);
            }
            $respons = Project::where("id", $sid)->update($data);
        } else{
            $respons = Project::create($data);
            $post_id = $respons->id;
        }
        //variable

        if($variables!=''){
            foreach ($variables as $key => $item) {
                if($item>0){
                    $datas_item = array(
                        "variable_id" => $item['id'],
                        "project_id" => $post_id
                    );
                    $db = Project_Join_Variable::firstOrNew($datas_item);
                    $db->description = $item['description'] ?? '';
                    $db->save();
                }
            }
        }

        $category_items = $rq->category ?? '' ;
        if($category_items!=''){
            foreach ($category_items as $key => $item) {
                if($item>0){
                    $datas_item = array(
                        "category_id" => $item,
                        "project_id" => $post_id
                    );
                    Join_Category_Project::create($datas_item);
                }
            }
        }
        if($save=='apply'){
            $msg = "Dự án thực hiện thành công";
            $url = route('admin.project.detail', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.project'));
        }
        
    }
}
