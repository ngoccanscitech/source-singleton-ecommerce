<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post, App\Model\Category, App\Model\Join_Category_Post;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

class PostController extends Controller
{
    public $data = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->data['title_head'] = __('Tin tức');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function listPost(){
        $db = Post::with('category_post');

        if(request()->has('category') && request()->category != ''){
            $category_id = request('category');
            $db->whereHas('category_post', function($query) use($category_id){
                return $query->where('id', $category_id);
            });
        }

        if(request()->has('search_title') && request()->search_title != ''){
            $search_title = request('search_title');
            $db->where('name', 'like', '%'. $search_title .'%');
        }

        $this->data['posts'] = $db->orderByDesc('id')->paginate(20);

        return view('admin.post.index', $this->data);
    }

    public function createPost(){
        return view('admin.post.single', $this->data);
    }

    public function postDetail($id){

        $this->data['post'] = Post::find($id);
        if($this->data['post']){
            return view('admin.post.single', $this->data);
        } else{
            return view('404');
        }
    }

    public function postPostDetail(Request $rq){

        $data = request()->all();
        $post_id = $data['id'];

        $title_new = $data['name'];
        $title_slug = addslashes($data['slug']);

        if(empty($title_slug) || $title_slug == ''):
           $title_slug = Str::slug($title_new);
        endif;
        //xử lý description
        $description= htmlspecialchars($data['description']);
        $description_en = htmlspecialchars($data['description_en']);

        //xử lý content
        $content = htmlspecialchars($data['content']);
        $content_en = htmlspecialchars($data['content_en']);

        $galleries = $data['gallery'] ?? '';
        if($galleries!=''){
            $galleries = array_filter($galleries);
            $data['gallery'] = $galleries ? serialize($galleries) : '';

        }

        $save = $data['submit'] ?? 'apply';
        
        $data_db = array(
            'name' => $title_new,
            'slug' => $title_slug,
            'description' => $description,
            'content' => $content,
            'name_en' => $data['name_en'],
            'description_en' => $description_en,
            'content_en' => $content_en,

            'gallery' => $data['gallery'] ?? '',
            'image' => $data['image'] ?? '',
            'cover' => $data['cover'] ?? '',
            'icon' => $data['icon'] ?? '',
            'status' => $data['status'] ?? 0,
            'sort' => $data['sort'] ?? 0,

            'seo_title' => $data['seo_title'] ?? '',
            'seo_keyword' => $data['seo_keyword'] ?? '',
            'seo_description' => $data['seo_description'] ?? '',
        );

        if($post_id == 0){
            $respons = Post::create($data_db);
            $post_id= $respons->id;
        } else{
            $respons = Post::find($post_id)->update($data_db);
        }

        if(isset($data['category'])){
            \App\Model\PostCategoryJoin::where('post_id', $post_id)->delete();
            foreach ($data['category'] as $key => $category) {
                \App\Model\PostCategoryJoin::create([
                    'post_id'   => $post_id,
                    'category_id'   => $category
                ]);
            }
        }

        if($save=='apply'){
            $msg = "Post has been Updated";
            $url = route('admin.postDetail', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.posts'));
        }
    }
}
