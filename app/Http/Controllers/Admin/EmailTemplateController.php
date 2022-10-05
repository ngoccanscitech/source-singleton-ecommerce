<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

use App\Model\ShopEmailTemplate;

class EmailTemplateController extends Controller
{
    public $path_folder;
    public $data;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->path_folder = 'admin.email_template';
        $this->data['title_head'] = 'Email template';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $this->data['datas'] = ShopEmailTemplate::orderByDesc('id')->paginate(20);
        return view($this->path_folder .'.index', $this->data);
    }

    public function create(){
        $variables_selected = [];
        $category_selected = [];
        $this->data['arrayGroup'] = $this->arrayGroup();
        return view($this->path_folder.'.single', $this->data);
    }

    public function edit($id){
        $this->data['data'] = ShopEmailTemplate::findorfail($id);
        $this->data['arrayGroup'] = $this->arrayGroup();
        return view($this->path_folder . '.single', $this->data);
    }

    public function post(Request $rq){
        $data = request()->all();

        $data_db = array(
            'name'  => $data['title'],
            'group'  => $data['group'],
            'text'  => htmlspecialchars($data['content']),
            'status'  => $data['status'] ?? 0,
        );

        if($data['id'])
            $response = ShopEmailTemplate::find($data['id'])->update($data_db);
        else{
            $response = ShopEmailTemplate::create($data_db);
            $data['id'] = $response->id;
        }

        if($data['submit'] == 'apply'){
            $msg = "Success";
            $url = route('admin.email_template.edit', array($data['id']));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.email_template'));
        }
    }

    public function arrayGroup()
    {
        return  [
            'order_payment_success' => 'Thông báo thanh toán thành công',
            'order_to_admin' => 'Thông báo có đơn hàng tới Admin',
            'order_to_user' => 'Thông báo có đơn hàng tới User',
            'forgot_password' => trans('email.email_action.forgot_password'),
            'welcome_customer_sys' =>  trans('email.email_action.welcome_customer_to_admin'),
            'welcome_customer' =>  trans('email.email_action.welcome_customer'),
            'contact_to_admin' =>  trans('email.email_action.contact_to_admin'),
            // 'baogia' =>  "Thông báo có báo giá tới user",
            // 'baogia_to_admin' =>  "Thông báo có báo giá tới admin",
            'request_payment_success' =>  'Thông báo thanh toán đơn hàng thành công',
            'other' =>  trans('email.email_action.other'),
        ];
    }
}
