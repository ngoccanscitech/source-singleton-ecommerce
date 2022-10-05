<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Investor;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Cache;

class InvestorController extends Controller
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
        $investor = Investor::orderByDesc('id')->paginate(20);
        return view('admin.investor.index', compact('investor'));
    }

    public function create(){
        return view('admin.investor.single');
    }

    public function edit($id){
        $investor = Investor::findorfail($id);
        if($investor){
            return view('admin.investor.single', compact('investor'));
        } else{
            return view('404');
        }
    }

    public function post(Request $rq){
        $data = request()->except(['_token', 'created', 'submit']);
        $id = $rq->id;

        $data['slug'] = addslashes($rq->post_slug);
        if($data['slug'] == '')
           $data['slug'] = Str::slug($data['title']);

        $data['content'] = $rq->content ? htmlspecialchars($rq->content) : '' ;
        $save = $rq->submit ?? 'apply';

        $investor = Investor::updateOrCreate(
            ['id' => $id],
            $data
        );

        if($save=='apply'){
            $msg = "Investor has been Updated";
            $url = route('admin.investor.edit', array($investor->id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.investor.index'));
        }
    }

    public function deleteSlider(Request $request)
    {
        Cache::forget('slider_home');
        $id = $request->id ? $request->id : 0;
        if($id){
            $slider = Slider::findorfail($id);
            $slider_id = $slider->slider_id;
            $slider->delete();
            $view = view('admin.slider-home.includes.slider-items', compact('slider_id'))->render();
            return response()->json($view);
        }
    }
}
