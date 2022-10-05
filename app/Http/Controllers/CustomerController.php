<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use Auth;
use Validator;
use Redirect;
use Route;
use Hash;
use Mail;
use Illuminate\Http\Request;
use App\Model\Post;
use App\Model\Category;
use App\Model\Rating_Product;
use App\Model\Wishlist;
use App\Model\Addtocard;
use App\Model\Shipping_order;
use App\Model\Customer_forget_pass_otp;
use DB, Input, File;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Libraries\Helpers;
use App\Facades\WebService;
use App\ShopOrderStatus;
use App\ShopOrderPaymentStatus;

class CustomerController extends Controller
{

    use \App\Traits\LocalizeController;
    
    public $currency;
    public $data = [
        'error' => false,
        'success' => false,
        'message' => ''
    ];

    public function __construct()
    {
        parent::__construct();
        $this->data['statusOrder']    = ShopOrderStatus::getIdAll();
        $this->data['orderPayment']    = ShopOrderPaymentStatus::getIdAll();

    }

    public function index()
    {
       return view('customer.home');
    }

    public function showLoginForm()
    {
        if (!Auth::check()) {
            $this->localized();
            $this->data['seo'] = [
                'seo_title' => 'Đăng nhập',
            ];
            return view($this->templatePath.'.customer.login', $this->data);
        }
        return redirect(url('/'));
    }

    public function postLogin(Request $request)
    {
        $data_return = ['status'=>"success", 'message'=>'Thành công'];

        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if($request->remember_me == 1){
            $remember_me = true;
        } else{
            $remember_me = false;
        }

        $check_user = \App\User::where('email', $request->email)->first();
        if($check_user!='' && $check_user->status==0){
            if (Auth::attempt($login, $remember_me)) {
                return response()->json(
                    [
                        'error' => 0,
                        'redirect_back' => $request->url_back??'/', //redirect()->back(),
                        'view' => view($this->templatePath .'.customer.includes.login_success')->render(),
                        'msg'   => __('Login success')
                    ]
                );
            } 
            else {
                return response()->json(
                    [
                        'error' => 1,
                        'msg'   => __('Email or Password is wrong')
                    ]
                );
            }
        } 
        else {
            return response()->json(
                [
                    'error' => 1,
                    'msg'   => __('Account does not exist!')
                ]
            );
        }
    }

    public function registerCustomer(){
        $this->data['seo'] = [
            'seo_title' => 'Đăng ký thành viên',
        ];

        return view($this->templatePath .'.customer.register',  $this->data);
    }

    public function createCustomer(Request $request){
        $data_return = ['status'=>"success", 'message'=>'Thành công'];
        $validation_rules = array(
            'fullname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        );
        $messages = array(
            'fullname.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Hãy nhập vào địa chỉ Email',
            'email.email' => 'Địa chỉ Email không đúng định dạng',
            'email.max' => 'Địa chỉ Email tối đa 255 ký tự',
            'email.unique' => 'Địa chỉ Email đã tồn tại',
            'password.required' => 'Hãy nhập mật khẩu',
            'password_confirmation.same' => 'Mật khẩu và nhập lại mật khẩu chưa trùng khớp!',
        );
        $data = $request->all();
        
        $validator = Validator::make($data, $validation_rules, $messages);
        
        if($validator->fails()) {
            $error = $validator->errors()->first();
            // dd($validator->errors());

            return response()->json([
                'error' => 1,
                'msg'   => $error
            ]);
            // $view = view('customer.includes.modal_register')->render();
        }
        $dataUpdate = [
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'fullname' => $data['fullname'],
        ];
        $new_cus = (new User)->create($dataUpdate);
        // dd($new_cus);

        if($new_cus->id){
            $email_admin = Helpers::get_option_minhnn('email');
            $name_admin_email = Helpers::get_option_minhnn('name-admin');
            $url_web = url('/');
            $url_only = request()->getHttpHost();
            //email send to user
            $data = array(
                'fullname' => $new_cus->fullname,
                'phone' => $new_cus->phone,
                'email' => $new_cus->email,
                'subject' => "Đăng ký tài khoản thành công",
                'subject_sys' => "Thông báo có tài khoản vừa đăng ký",
                'title' => setting_option('company_name'),
                'email_admin' => $email_admin,
                'url_only' => $url_only,
            );
            
            Mail::send(
                'mail.thongbao_user_register', $data,
                function ($message) use ($data) {
                        $message->from($data['email'], $data['title']);
                        $message->to($data['email'])->subject($data['subject']);
                    }
            );

            //thong bao co thanh vien dang ky
            Mail::send(
                'mail.user_register_system', $data,
                function($message) use ($data) {
                    $message->from($data['email_admin'], $data['title']);
                    $message->to($data['email_admin'])
                        ->subject($data['subject_sys']." - Website: ".$data['url_only']);
                }
            );

            Auth::login($new_cus);

            return response()->json([
                'error' => 0,
                'view' => view($this->templatePath .'.customer.includes.register_success')->render(),
                'msg'   => __('Register success')
            ]);

            // return redirect(route('user.register.success'));

            // Auth::login($new_cus);
            // return redirect()->route('index');
        }
        
        
    }

    public function createCustomerSuccess()
    {
        return view($this->templatePath .'.customer.includes.register_success');
    }

    public function profile(){
        $this->data['user'] = Auth::user();
        $this->data['seo'] = [
            'seo_title' => 'Thông tin',
        ];
        return view($this->templatePath .'.customer.profile', $this->data);
    }
    public function updateProfile(Request $rq){
        $id = Auth::user()->id;
        $name_field = "avatar_upload";
        if($rq->avatar_upload){
            $image_folder="/images/avatar/";

            $file = $rq->file($name_field);
            $file_name = uniqid() . '-' . $file->getClientOriginalName();
            $name_avatar = $image_folder . $file_name;

            
            $file->move( base_path().$image_folder, $file_name );
            if(Auth::user()->avatar !='' && file_exists( base_path().Auth::user()->avatar )){
                if(file_exists(asset(base_path().Auth::user()->avatar)))
                    unlink( asset(base_path().Auth::user()->avatar) );
            }
        }
        else
            $name_avatar = Auth::user()->avatar;

        $data= array(
            'fullname' => $rq->fullname??'',
            'firstname' => $rq->firstname??'',
            'lastname' => $rq->lastname??'',
            'address' => $rq->address ?? '',
            'birthday' => $rq->birthday ?? null,
            'country' => $rq->country ?? '',
            'province' => $rq->state ?? '',
            'district' => $rq->slt_district ?? '',
            'city' => $rq->city ?? '',
            'postal_code' => $rq->postal_code ?? 0,
            'avatar' => $name_avatar,
            'phone' => $rq->phone,
        );
        $respons =(new \App\User)->find($id)->update($data);
        $msg = "Thông tin tài khoản đã được cập nhật";
        $url=  route('customer.profile');
        Helpers::msg_move_page($msg,$url);
    }

    public function myPost()
    {
        $this->localized();
        $this->data['products'] = \App\Product::where('user_id', auth()->user()->id)->orderbyDesc('id')->paginate(10);
        
        return view('theme.customer.my-post', ['data'=>$this->data]);
    }

    public function deletePost($id)
    {
        $db = \App\Product::where('id', $id)->where('user_id', auth()->user()->id)->first();
        if($db->delete())
        {
            \App\Model\ThemeInfo::where('theme_id', $id)->delete();
            \App\Model\Join_Category_Theme::where('theme_id', $id)->delete();
            return redirect()->back();
        }
    }

    public function logoutCustomer(){
        Auth::logout();
        return redirect()->route('index');
    }
    public function changePassword(){
        $this->data['user'] = Auth::user();
        return view('theme.customer.auth.change_pass')->with(['data'=>$this->data]);
    }
    public function postChangePassword(Request $rq){
        $user = Auth::user();
        $id = $user->id;
        $current_pass = $user->password;
        if(Hash::check($rq->current_password, $user->password)){
            if($rq->new_password != '' && $rq->new_password == $rq->confirm_password){
                $data = array(
                    'password' => bcrypt($rq->new_password)
                );
            } else{
                $msg = 'Mật khẩu xác nhận không trùng khớp';
                return Redirect::back()->withErrors($msg);
            }
        } else{
            $msg = 'Mật khẩu hiện tại không chính xác';
            return Redirect::back()->withErrors($msg);
        }
        $respons =DB::table('users')->where("id","=",$id)->update($data);
        $msg = "Mật khẩu đã được thay đổi";
        $url=  route('customer.profile');
        Helpers::msg_move_page($msg,$url);
    }

    public function checkWallet(Request $request)
    {
        $this->data['status'] = 'success';
        $price_post = $request->price_post;
        $wallet = auth()->user()->wallet;
        $wallet_check = 'ok';
        if($wallet < $price_post){
            $wallet_check = 'error';
            $this->data['status'] = 'error';
        }
        $this->data['view'] = view('theme.dangtin.includes.wallet_check', compact('wallet_check'))->render();
        return response()->json($this->data);
    }

    public function wishlist()
    {
        if(auth()->check()){
            $this->data['wishlist'] = \App\Model\Wishlist::with('product')->where('user_id', auth()->user()->id)->get();
            return view('theme.customer.wishlist', ['data'=>$this->data]);
        }
        else
        {
            $wishlist = json_decode(\Cookie::get('wishlist'));

            if($wishlist != ''){
                $this->data['wishlist'] = \App\Product::whereIn('id', $wishlist)->get();
                // dd($this->data['wishlist']);
            }
            return view($this->templatePath .'.customer.wishlist', ['data'=>$this->data]);
        }
    }

    public function subscription(Request $request)
    {
        $email = $request->email;
        \App\Model\User_register_email::updateOrCreate(['email'=>$email]);
        $this->data['status'] = 'success';
        $this->data['email'] = $email;
        $this->data['view'] = view($this->templatePath .'.customer.includes.subscription')->render();
        return response()->json($this->data);
    }

    //xử lý quên mật khẩu
    public function forgetPassword(){
        return view($this->templatePath .'.customer.auth.forget-password');
    }
    public function actionForgetPassword(Request $rq){
        $user = User::where('email', $rq->email)->first();
        if($user){
            session_start();
            $customer_forget_pass_otp = new Customer_forget_pass_otp();
            $customer_forget_pass_otp->email = $rq->email;
            $customer_forget_pass_otp->user_id = $user->id;
            $customer_forget_pass_otp->otp_mail = rand(100000,999999);
            $customer_forget_pass_otp->status = 0;
            $customer_forget_pass_otp->save();
            $_SESSION["otp_forget"] = $customer_forget_pass_otp->otp_mail;
            $_SESSION["email_forget"] = $customer_forget_pass_otp->email;

            $site_name = Helpers::get_option_minhnn('site-name');
            $data = array(
                'email'=>$customer_forget_pass_otp->email,
                'emailadmin'   => $email_admin = Helpers::get_option_minhnn('email'),
                'otp'=>$customer_forget_pass_otp->otp_mail,
                'name'=>$user->first_name,
                'created_at'=>$customer_forget_pass_otp->created_at,
                'site_name' => $site_name,
            );
            Mail::send($this->templatePath .'.mail.forget-password.forget-password',
                $data,
                function($message) use ($data) {
                    $message->from($data['emailadmin'], $data['site_name']);
                    $message->to($data['email'])
                    ->subject($data['otp'].' là mã OTP của '. $data['site_name']);
                }
            );
            return redirect()->route('forgetPassword_step2');
        } else{
            redirect()->back()->withErrors('Email not exist.');
        }
    }

    public function forgetPassword_step2(){
        session_start();
        if((!isset($_SESSION["otp_forget"]) && !isset($_SESSION["email_forget"])) || $_SESSION["otp_forget"] == '' || $_SESSION["email_forget"] == '' ){
            session_unset();
            session_destroy();
            return redirect()->route('forgetPassword');
        } else{
            return view('theme.customer.auth.forget-password-step-2');
        }
    }

    public function actionForgetPassword_step2(Request $rq){
        session_start();
        $customer_forget_pass_otp = Customer_forget_pass_otp::where('otp_mail', '=', $rq->otp_mail)
        ->where('otp_mail', '=', $_SESSION["otp_forget"])
        ->where('status', '=', 0)
        ->whereRaw("TIME_TO_SEC('".Carbon::now()."') - TIME_TO_SEC(created_at) < 300 ")
        ->first();
        if($customer_forget_pass_otp){
            $_SESSION["otp_true"] = 1;
            return redirect()->route('forgetPassword_step3');
        } else{
            return redirect()->back()->withErrors('OTP is not correct.');
        }
    }

    public function forgetPassword_step3(){
        session_start();
        if((!isset($_SESSION["otp_forget"]) && !isset($_SESSION["email_forget"]) && !isset($_SESSION["otp_true"])) || $_SESSION["otp_forget"] == '' || $_SESSION["email_forget"] == '' ){
            session_unset();
            session_destroy();
            return redirect()->route('forgetPassword');
        } else{
            return view('theme.customer.auth.forget-password-step-3');
        }
    }

    public function actionForgetPassword_step3(Request $rq){
        session_start();
        $customer_forget_pass_otp = Customer_forget_pass_otp::where('email', '=', $_SESSION["email_forget"])
        ->where('otp_mail', '=', $_SESSION["otp_forget"])
        ->where('status', '=', 0)
        ->first();
        if($customer_forget_pass_otp){
            $validator = Validator::make($rq->all(), [
                'new_password'     => 'required|min:6|required_with:confirm_new_password|same:confirm_new_password',
                'confirm_new_password'     => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                ->withErrors($validator);
            }
            $customer = User::where('email', '=', $_SESSION["email_forget"])->first();
            $customer->password = bcrypt($rq->new_password);
            $customer->save();

            $customer_forget_pass_otp->status = 1;
            $customer_forget_pass_otp->save();

            session_unset();
            session_destroy();
            $msg = "Mật khẩu đã được thay đổi.";
            $url=  route('user.login');
            if($msg) echo "<script language='javascript'>alert('".$msg."');</script>";
            echo "<script language='javascript'>document.location.replace('".$url."');</script>";
        } else{
            session_unset();
            session_destroy();
            return redirect()->route('forgetPassword');
        }
    }

    public function myOrder()
    {
        $this->data['data_order'] = \App\Model\Addtocard::where('user_id', Auth::user()->id)->orderByDesc('cart_id')->paginate(10);

        $this->data['seo'] = [
            'seo_title' => 'Đơn hàng của bạn',
        ];

        return view($this->templatePath .'.customer.myorder', $this->data);
    }
    
    public function myOrderDetail($id_cart){
        $this->data['order'] = \App\Model\Addtocard::find($id_cart);
        $this->data['order_detail'] = \App\Model\Addtocard_Detail::where('cart_id', $this->data['order']->cart_id)->get();

        $total_price = isset($order_detail->total) ? $order_detail->total : 0;

        if($this->data['order']){
            $this->data['seo'] = [
                'seo_title' => 'Đơn hàng - '. $this->data['order']->cart_code,
            ];
            return view($this->templatePath .'.customer.orderdetail', [ 'data'=>$this->data ]);
        }
        else
            return view('errors.404');
    }

    public function myPoint()
    {
        $user = request()->user();
        $user_point = $user->getVIP();
        // dd($user_point);

        $this->data = [
            'user'  => $user,
            'user_point'  => $user_point,
            'seo'   =>[
                'seo_title' => 'Thông tin tài khoản',
            ]
        ];


        return view($this->templatePath .'.customer.my-point', $this->data);
    }
}



