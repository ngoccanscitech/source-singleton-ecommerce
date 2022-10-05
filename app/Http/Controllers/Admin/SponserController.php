<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Sponser;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Cache;

class SponserController extends Controller
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

    public function listSponser(){
        $data_slider = Sponser::orderbyDesc('order')->orderbyDesc('id')->get();
        return view('admin.sponser.index')->with(['data_slider' => $data_slider]);
    }

    public function createSponser(){
        return view('admin.sponser.single');
    }

    public function sponserDetail($id){
        $data_slider = Sponser::where('sponser.id', '=', $id)->first();
        if($data_slider){
            return view('admin.sponser.single')->with(['data_slider' => $data_slider]);
        } else{
            return view('404');
        }
    }

    public function postSponserDetail(Request $rq){
        //id page
        $sid = $rq->sid;
        $post_id = $sid;
        $datetime_now=date('Y-m-d H:i:s');
        $datetime_convert=strtotime($datetime_now);

        $title_new = $rq->post_title;

        $image = $rq->image ?? '';
        $cover = $rq->cover ?? '';

        /*PC up load*/
        $name_thumb_pc="";
        $name_field_pc="csv_slishow";
        $name_text_pc="slishow_upload";
        if($rq->hasFile($name_field_pc)):
            $file = $rq->file($name_field_pc);
            $timestamp = $datetime_convert;
            $name = "sponser-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_pc=$name;
            $file->move(base_path().'/public/images/sponser/',$name);
        else:
            if($rq->input($name_text_pc) !=""):
                $name_thumb_pc = $rq->input($name_text_pc);
            else:
                $name_thumb_pc = "";
            endif;
        endif;
        /*End pc upload*/

        $save = $rq->submit ?? 'apply';
        
        if($sid == 0){
            $data = array(
                'name' => $title_new,
                'image' => $image,
                'cover' => $cover,
                'order' => $rq->order,
                'link' => $rq->link,
                'status' => $rq->status,
                'updated' => $rq->created,
                'created' => $rq->created,
            );
            $respons = Sponser::create($data);
            $id_insert= $respons->id;
            $post_id = $id_insert;
            //Cache::forget('sponser');
            
        } else{
            $data = array(
                'name' => $title_new,
                'image' => $image,
                'cover' => $cover,
                'order' => $rq->order,
                'link' => $rq->link,
                'status' => $rq->status,
                'updated' => date('Y-m-d h:i:s')
            );
            $respons = Sponser::where ("id","=", $sid)->update($data);
            //Cache::forget('sponser');
        }
        if($save=='apply'){
            $msg = "Silder has been Add or Updated";
            $url = route('admin.sponserDetail', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.sponser'));
        }
    }
}
