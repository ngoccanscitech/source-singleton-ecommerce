<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ShopElement;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;

class ElementController extends Controller
{
    public $data;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->data['title_head'] = 'Thành phần';
        $this->data['listLocation'] = $this->listLocation();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $this->data['brands'] = ShopElement::orderByDESC('id')->paginate(20);
        return view('admin.element.index', $this->data);
    }

    public function create(){
        return view('admin.element.single', $this->data);
    }

    public function edit($id){
        
        $this->data['post_brand'] = ShopElement::find($id);
        if($this->data['post_brand']){
            return view('admin.element.single', $this->data);
        } else{
            return view('404');
        }
    }

    public function post(){
        $data = request()->all();

        //id post
        $sid = $data['id'];
        $post_id = $data['id'];
        $title_new = $data['name'];

        $slug = isset($data['slug']) ? addslashes($data['slug']) : '';
        if(empty($slug) || $slug == ''):
           $slug = Str::slug($title_new);
        endif;

        $galleries = $data['gallery'] ?? '';
        if($galleries!=''){
            $galleries = array_filter($galleries);
            $data['gallery'] = $galleries ? serialize($galleries) : '';

        }
        // dd($data);

        $data_db = array(
            'link' => $data['link'] ?? '',
            'slug' => $slug,
            'name' => $title_new ?? '',
            'content' => $data['content'] ? htmlspecialchars($data['content']) : '',

            'phone' => $data['phone'] ?? '',
            'email' => $data['email'] ?? '',
            'address' => $data['address'] ?? '',
            'addr_lat' => $data['addr_lat'] ?? '',
            'addr_long' => $data['addr_long'] ?? '',
            'location' => $data['location'] ?? '',

            'image' => $data['image'] ?? '',
            'icon' => $data['icon'] ?? '',
            'cover' => $data['cover'] ?? '',
            'gallery' => $data['gallery'] ?? '',
            'status' => $data['status'] ?? 0,
            'sort' => $data['preority'] ?? 0,

            'seo_title' => $data['seo_title'] ?? 0,
            'seo_keyword' => $data['seo_keyword'] ?? 0,
            'seo_description' => $data['seo_description'] ?? 0,

        );

        if($sid > 0){
            $respons = ShopElement::find($sid)->update($data_db);
        } else{
            $respons = ShopElement::create($data_db);
            $post_id= $respons->id;
        }

        $save = $data['submit'] ?? 'apply';
        if($save=='apply'){
            $msg = "Product has been Updated";
            $url = route('admin_element.edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_element.index'));
        }
        
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
