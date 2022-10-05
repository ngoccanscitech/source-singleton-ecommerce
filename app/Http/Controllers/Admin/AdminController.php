<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Setting, App\Model\Admin, App\Model\Addtocard;
use App\Model\Theme, App\Model\Category_Theme, App\Model\Join_Category_Theme, App\Model\Rating_Product;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use App\User;
use Auth, DB, File, Image, Redirect, Cache;
use App\Exports\CustomerExport;
use App\Exports\OrderExport;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\WebService\WebService;

class AdminController extends Controller
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
    public function error(){
        return view('errors.404');
    }
    public function changePassword(){
        return view('admin.change-password');
    }

    public function userDetail($id){
    	$user = User::find($id);

    	return view('admin.users.detail', ['user' => $user]);
    }

    public function deleteUser($id)
    {
        //$loadDelete = User::find($id)->delete();

        //delete products
        // $productDelete = Theme::all();
        // if($loadDelete){
        //   foreach($productDelete as $value){
        //     if($value->admin_id==$id){
        //             $value->delete();
        //         }
        //     }     
        // }
        
        $msg = "Customer account has been Delete";
        $url = route('admin.listUsers');
        Helpers::msg_move_page($msg,$url);
    }

    public function postChangePassword(Request $rq){
        // echo $rq->check_pass;
        // echo '<pre>';
        // print_r($rq->all());
        // echo '</pre>';die();
        $user = Auth::guard('admin')->user();
        $id = $user->id;
        $current_pass = $user->password;
        if($rq->check_pass_value=='off'){
            //no change pass
           $data = array(
                    'email' => $rq->email,
                    'name' => $rq->name,
                    'phone' => $rq->phone,
                    'address' => $rq->address,
                    'email_info' => $rq->email,
                ); 
        }
        else{
            //change pass
        if(Hash::check($rq->current_password, $user->password)){
            if($rq->new_password == $rq->confirm_password){
                $data = array(
                    'email' => $rq->email,
                    'name' => $rq->name,
                    'password' => bcrypt($rq->new_password),
                    'phone' => $rq->phone,
                    'address' => $rq->address,
                    'email_info' => $rq->email,
                );
            } else{
                $msg = 'Mật khẩu xác nhận không trùng khớp';
                return Redirect::back()->withErrors($msg);
            }
        } else{
            $msg = 'Mật khẩu hiện tại không chính xác';
            return Redirect::back()->withErrors($msg);
        }
        }
        $respons =DB::table('admins')->where("id","=",$id)->update($data);
        $msg = "Thông tin cập nhật thành công!";
        $url=  route('admin.changePassword');
        Helpers::msg_move_page($msg,$url);
    }
    
    public function listUsers(){
        $data_user = User::get();
        return view('admin.users.index')->with(['data_user' => $data_user]);
    }

    public function getMenu(){
        return view('admin.setting.menu');
    }

    public function getThemeOption(){
        return view('admin.setting.theme-option');
    }

    public function postThemeOption(Request $rq){
        $data = request()->all();
        // dd($data);
        $data_option = $data['header_option'];
        $i = 0;
        $list_option = [];
        // dd($data_option);
        if($data_option){
            foreach ($data_option as $key => $option) {
                $type = $key;
                foreach($option['name'] as $index => $item){
                    $content = htmlspecialchars($option['value'][$index]);
                    if($type == 'editor')
                        $content = htmlspecialchars($content);
                    $option_db = Setting::updateOrCreate(
                        [
                            'name'  => $item
                        ],
                        [
                            'content'   => $content,
                            'type'   => $type,
                            'sort'   => $i,
                        ]
                    );
                    $list_option[] = $option_db->id;
                    $i++;
                }
            }
        }
        //delete;
        Setting::whereNotIn('id', $list_option)->delete();
        Cache::forget('theme_option');
        $msg = "Option has been registered";
        $url= route('admin.themeOption');
        Helpers::msg_move_page($msg,$url);
    }

    public function exportProduct(Request $rq){
    	$data = Theme::where('theme.status', '=', 0)
    		->orderBy('theme.title', 'ASC')
    		->select('theme.id', 'theme.title', 'theme.price_origin', 'theme.price_promotion', 'theme.start_event', 'theme.end_event', 'theme.product_detail_weight', 'theme.seo_keyword')
    		->get();
    	$arr = array();
    	foreach ($data as $row ) {
    		$categories = Theme::where('theme.id', '=', $row->id)
                ->join('join_category_theme','theme.id','=','join_category_theme.id_theme')
                ->join('category_theme','join_category_theme.id_category_theme','=','category_theme.categoryID')
                ->select('category_theme.categoryName')
                ->orderBy('category_theme.categoryParent','ASC')
                ->get(); 
            $cate_txt = "";
            $count_cate_txt = 0;
            if($categories){
            	foreach ($categories as $cate) {
            		if($count_cate_txt == 0){
            			$cate_txt .= $cate->categoryName;
            		} else{
            			$cate_txt .= ', '.$cate->categoryName;
            		}
            		$count_cate_txt++;
            	}
            }
            $o_arr = array(
                'ID' => $row->id,
                'Title' => $row->title,
                'Category' => $cate_txt,
                'Price_Origin' => $row->price_origin,
                'Price_Promotion' => $row->price_promotion,
                'Start_Event' => $row->start_event,
                'End_Event' => $row->end_event,
                'Weight' => $row->product_detail_weight,
                'Keyword' => $row->seo_keyword
            );
            array_push($arr, $o_arr);
    	}
        return (new ProductExport($arr))->download('product.xlsx');
    }

    public function exportCustomer(Request $rq){
        $from = date('Y-m-d H:i:s',strtotime($rq->cus_from));
        $to = date('Y-m-d H:i:s',strtotime($rq->cus_to));
        return (new CustomerExport($from, $to))->download('customer.xlsx');
    }

    public function exportOrder(Request $rq){
        $from = date('Y-m-d H:i:s',strtotime($rq->order_from));
        $to = date('Y-m-d H:i:s',strtotime($rq->order_to));
        $data = Addtocard::whereBetween('addtocard.created', [$from, $to])->orderBy('created', 'DESC')->get();
        $arr = array();
        foreach ($data as $row ) {
            $cart_content_cart = unserialize($row->cart_content);
            if($cart_content_cart):
            try{
                $j=0;
                $cart_id=0;
                $List_cart="";
                $product_name = "";
                $product_option = "";
                $qty=0;
                $count_item = count($cart_content_cart);
                $k=1;
                foreach($cart_content_cart as $List_cart):
                    if($count_item == 1){
                        $line_break = '';
                    }elseif($count_item == $k){
                        $line_break = '';
                    }else{
                        $line_break = ' | ';
                    }
                    $k++;
                    if(isset($List_cart->id)):
                        $cart_id=$List_cart->id;
                        $avariable=$List_cart->options;
                        $Products=Helpers::get_product_by_id($cart_id);
                        $avariable_html = "";
                        $group_combo = "";
                        $product_name .= $List_cart->name." x".$List_cart->qty;
                        $qty += $List_cart->qty;
                        if(isset($avariable) && count($avariable)>0):
                            $count_option_arr = count($avariable);
                            $id_variable_parrent = 0;
                            $id_variable_child = 0;
                            for ($j=0; $j < $count_option_arr; $j++):
                                $string_json_variable = \GuzzleHttp\json_decode($avariable[$j]);
                                if(!WebService::objectEmpty($string_json_variable)):
                                    $id_variable_parrent = $string_json_variable->parent_id;
                                    $id_variable_child = $string_json_variable->id;
                                    if($id_variable_parrent > 0 && $id_variable_child > 0):
                                        $avariable_html .= "(".$string_json_variable->parent_title.": ".$string_json_variable->title.")";
                                    endif;
                                endif;
                            endfor;
                            $product_name .= $avariable_html."(".Helpers::GetEmailOwnerProduct($cart_id).")".$line_break;
                        else:
                            $product_name .= "(".Helpers::GetEmailOwnerProduct($cart_id).")".$line_break;
                        endif;

                        $order_status = "";
                        switch ($row->cart_status) {
                            case '1':
                                $order_status = "Mới đặt";
                                break;
                            case '2':
                                $order_status = "Giao J&T";
                                break;
                            case '3':
                                $order_status = "Đã hủy";
                                break;
                            case '4':
                                $order_status = "Đợi xử lý";
                                break;
                            case '5':
                                $order_status = "Liên hệ sau";
                                break;
                            default:
                                break;
                        }
                        $o_arr = array(
                            'Order_Code' => $row->cart_code,
                            'Order_Date' => $row->created,
                            'Customer' => $row->cart_hoten,
                            'Email' => $row->cart_email,
                            'Tel' => $row->cart_phone,
                            'Address' => $row->cart_address,
                            'Ward' => $row->cart_ward,
                            'District' => $row->cart_district,
                            'Province' => $row->cart_province,
                            'Product_Code' => $Products['theme_code'],
                            'Product_Name' => $product_name,
                            'Product_Quantity' => $qty,
                            'Pay_Method' => $row->cart_pay_method,
                            'Total' => $row->cart_total,
                            'Shipping_Fee' => $row->shipping_fee,
                            'Status' => $order_status,
                        );
                    endif;
                endforeach;
                array_push($arr, $o_arr);
            }catch(Exception $ex) {
                echo "Lỗi:".$ex;
            }
            endif;
        }
        return (new OrderExport($arr))->download('order.xlsx');
    }

    public function listRating(){
        $rating = Rating_Product::get();
        return view('admin.rating.index')->with(['rating' => $rating]);
    }

    public function ratingDetail($id){
        $rating = Rating_Product::find($id);

    	return view('admin.rating.single', ['rating' => $rating]);
    }

    public function postRating(Request $rq){
        $id     = $rq->id_rating;
        $rating_product = Rating_Product::where('id', '=', $id)->update(['status' => $rq->status]);
        $msg = "Đánh giá khách hàng đã cập nhật";
        $url = route('admin.ratingDetail', [$id]);
        Helpers::msg_move_page($msg,$url);
    }
}
