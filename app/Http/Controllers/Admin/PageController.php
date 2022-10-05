<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Page;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image;


class PageController extends Controller
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

    public function listPage(){
        $data_page = Page::get();
        return view('admin.page.index')->with(['data_page' => $data_page]);
    }

    public function createPage(){
        return view('admin.page.single');
    }

    public function pageDetail($id){
        $page_detail = Page::where('page.id', '=', $id)->first();
        if($page_detail){
            return view('admin.page.single')->with(['page_detail' => $page_detail]);
        } else{
            return view('404');
        }
    }

    public function postPageDetail(Request $rq){
        //id page
        $sid = $rq->sid;
        $post_id = $sid;

        $title_new = $rq->post_title;
        $title_slug = addslashes($rq->post_slug);
        $title_en = $rq->post_title_en;

        $show_main_post = $rq->show_main_post;

        if(empty($title_slug) || $title_slug == '')
            if($title_new)
                $title_slug = Str::slug($title_new);
        //xử lý description
        $description= htmlspecialchars($rq->post_description);
        $description_en = htmlspecialchars($rq->post_description_en);

        //xử lý content
        $content = htmlspecialchars($rq->post_content);
        $content_en = htmlspecialchars($rq->post_content_en);

        //template
        $template = $rq->template ?? 'page';

        //show footer
        $show_footer = $rq->show_footer ?? 0;

        $image = $rq->image ?? '';
        $cover = $rq->cover ?? '';
        $icon = $rq->icon ?? '';
        // dd($image);

        $save = $rq->submit ?? 'apply';
        
        if($sid == 0){
            $data = array(
                'title' => $title_new,
                'slug' => $title_slug,
                'description' => $description,
                'content' => $content,
                'title_en' => $title_en,
                'description_en' => $description_en,
                'content_en' => $content_en,
                'template' => $template,
                'show_footer' => $show_footer,
                'image' => $image,
                'cover' => $cover,
                'icon' => $icon,
                'status' => $rq->status,

                'seo_title' => request('seo_title') ?? '',
                'seo_keyword' => request('seo_keyword') ?? '',
                'seo_description' => request('seo_description') ?? '',
            );
            $respons = Page::create($data);
            $post_id= $respons->id;
        } else{
            $data = array(
                'title' => $title_new,
                'slug' => $title_slug,
                'description' => $description,
                'content' => $content,
                'title_en' => $title_en,
                'description_en' => $description_en,
                'content_en' => $content_en,
                'template' => $template,
                'image' => $image,
                'cover' => $cover,
                'icon' => $icon,
                'show_footer' => $show_footer,
                'status' => $rq->status,

                'seo_title' => request('seo_title') ?? '',
                'seo_keyword' => request('seo_keyword') ?? '',
                'seo_description' => request('seo_description') ?? '',
            );
            $respons = Page::where ("id","=",$sid)->update($data);
        }
        if($save=='apply'){
            $msg = "Product has been Updated";
            $url = route('admin.pageDetail', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.pages'));
        }
    }
}
