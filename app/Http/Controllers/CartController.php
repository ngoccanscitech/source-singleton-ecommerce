<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Cart, Auth;

use ShipEngine\ShipEngine;

use App\Model\ShopEmailTemplate;
use App\Mail\SendMail;
use App\Jobs\Job_SendMail;
use App\ShopOrderStatus;
use App\ShopOrderPaymentStatus;
use Illuminate\Support\Str;

class CartController extends Controller
{
    use \App\Traits\LocalizeController;
    public $currency,
    $statusOrder,
    $orderPayment;
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

    public function cart(){
        $this->localized();
        $this->data['carts'] = Cart::content();
        $this->data['seo'] = [
            'seo_title' => 'Giỏ hàng',
        ];
        return view($this->templatePath .'.cart.cart', $this->data);
    }

    public function addCart()
    {
        $data = request()->all();
        $optionPrice = 0;

        $product = \App\Product::find($data['product']);
        if (!$product) {
            return response()->json(
                [
                    'error' => 1,
                    'msg' => 'Product not found',
                ]
            );
        }
        $variables = \App\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->get();
        // dd($variables);
        $attr = $data['option'] ?? '';
        foreach($variables as $variable){
            if(isset($attr[$variable->id])){
                $form_attr[$variable->id] = $attr[$variable->id];

                $variable_data = explode('__', $attr[$variable->id]);
                
                $optionPrice = isset($variable_data[2]) && $variable_data[2] > 0 ? $variable_data[2] : $variable_data[1];
            }
        }
        $price = $optionPrice > 0 ? $optionPrice : $product->getFinalPrice();
        
        //Check product allow for sale
        Cart::add(
            array(
                'id'      => $product->id,
                'name'    => $product->name,
                'qty'     => $data['qty'],
                'price'   => $price,
                'options' => $form_attr ?? []
            )
        );
        
        return response()->json(
            [
                'error' => 0,
                'count_cart' => Cart::count(),
                'view' => view($this->templatePath .'.cart.cart-mini')->render(),
                'msg' => 'Add to cart success',
            ]
        );
    }

    public function updateCarts()
    {
        $data = request()->all();
        
        Cart::update($data['rowId'], ['qty' => $data['qty']]);
        // dd($carts);
        $carts = Cart::content();
        $variable_group = \App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->pluck('name', 'id');
        return response()->json([
            'error' => 0,
            'count_cart' => Cart::count(),
            'view_cart_mini' => view($this->templatePath .'.cart.cart-mini')->render(),
            'view' => view($this->templatePath .'.cart.cart-list', compact('carts', 'variable_group'))->render(),
            'msg'   => 'Update cart success'
        ]);
        // $carts = Cart::find($data['rowId']);
    }

    public function removeCarts()
    {
        Cart::destroy();
        return redirect(route('cart'));
    }

    public function removeCart()
    {
        $rowId = request('rowId');
        if (array_key_exists($rowId, Cart::content()->toArray())) {
            Cart::remove($rowId);

            return response()->json(
                [
                    'error' => 0,
                    'count_cart' => Cart::content()->count(),
                    'total' => number_format(Cart::total()),
                    'msg' => 'Delete success',
                ]
            );
        }
        return response()->json(
            [
                'error' => 1,
                'msg' => 'Delete error',
            ]
        );
    }

    public function checkout()
    {
        $this->localized();
        if(Cart::count()){
            session()->forget('option');

            if(session()->has('cart-info')){
                $data = session()->get('cart-info')[0];
                $this->data["cart_info"] = $data;
            }

            $this->data['seo'] = [
                'seo_title' => 'Đặt hàng',
            ];
            return view($this->templatePath .'.cart.checkout', $this->data);
        }
        else
            return $this->cart();
    }

    public function checkPayment($cart_id)
    {
        $this->localized();
        $this->data['cart'] = \App\Model\Addtocard::where('cart_id', $cart_id)->first();
        // dd($cart);
        if($this->data['cart'] && $this->data['cart']['cart_status'] =='waiting-payment')
            return view($this->templatePath .'.cart.check-payment', $this->data);
        else
            return redirect(url('/'));
    }

    public function checkoutConfirm()
    {
        $this->localized();
        $data = request()->all();

        if($data){
            if($data['delivery'] == 'shipping'){
                $data['name'] = $data['ship_name'];
                $data['email'] = $data['ship_email'];
                $data['phone'] = $data['ship_phone'];
            }
            // dd($data);
            session()->forget('cart-info');
            session()->push('cart-info', $data);
            // return view($this->templatePath .'.cart.cart-confirm', $this->$data);
            return redirect()->route('cart.checkout.get.confirm');
        }
        else
        {
            if(session()->has('order-waiting')){
                if(session()->has('order-waiting')){
                    $cart_id = session('order-waiting')[0];
                    session()->forget('order-waiting');
                    return redirect()->route('cart.check_payment', $cart_id);
                }   
            }
            elseif(!session()->has('cart-info')){
                return redirect()->route('cart.checkout');
            }

            $data = session()->get('cart-info')[0];
        }
        // dd($data);
        $this->data['data'] = $data;
        if(isset($data['postal_code'])){
            $ships = $this->USPS($data['pounds'], $data['ounces'], setting_option('postal_code'), $data['postal_code']);
            // dd($ships);
            if(is_array($ships)){
                // $this->data['ships'] = array_slice($ships, 0, 4);
                $this->data['ships'] = $ships;
                $ship_first = current($this->data['ships']);
                $ship_rate = $ship_first['Rate'] ?? 0;
                $cart_total = $ship_rate + Cart::total(2);
                $this->data['data_shipping'] = [
                    'shipping_cost' => $ship_first['Rate'],
                    'shipment_amount' => render_price($ship_first['Rate']),
                    'cart_total' => render_price($cart_total),
                ];
            }
        }
        else{
            $this->data['data_shipping'] = [
                'shipping_cost' => 0,
                'shipment_amount' => 0,
                'cart_total' => 0,
            ];
        }
        // dd($this->data);
        $this->data['seo'] = [
            'seo_title' => 'Xác nhận đơn hàng',
        ];
        return view($this->templatePath .'.cart.cart-confirm', $this->data);
    }
    public function quickBuyConfirm()
    {
        $this->localized();
        $data = request()->all();
        if($data){
            if($data['delivery'] == 'shipping'){
                $data['name'] = $data['ship_name'];
                $data['email'] = $data['ship_email'];
                $data['phone'] = $data['ship_phone'];
            }
            session()->forget('cart-info');
            session()->push('cart-info', $data);
            return redirect()->route('quick_buy.get.confirm');
        }
        else
        {
            if(session()->has('order-waiting')){
                if(session()->has('order-waiting')){
                    $cart_id = session('order-waiting')[0];
                    session()->forget('order-waiting');
                    return redirect()->route('cart.check_payment', $cart_id);
                }   
            }
            elseif(!session()->has('cart-info')){
                return redirect()->route('cart.checkout');
            }

            $data = session()->get('cart-info')[0];
        }
        // dd($data);
        $this->data['data'] = $data;
        $this->data['product'] = \App\Product::find($data['product_id']);
        if($this->data['product']){
            $this->data['data_shipping'] = [
                'shipping_cost' => 0,
                'shipment_amount' => 0,
                'cart_total' => 0,
            ];

            $this->data['seo'] = [
                'seo_title' => 'Xác nhận đơn hàng',
            ];
            // dd($this->data);
            return view($this->templatePath .'.cart.quick-buy-confirm', $this->data);
        }
    }
    

    public function checkoutProcess(Request $request){

        $data = session()->get('cart-info')[0];
        if(!$data)
            return redirect(url('/'));
        
        $data_request = request()->all();
        // dd($data_request);

        $shipping_cost = $data_request['shipping_cost'] ?? 0;

        $option_session = session()->get('option');
        if($option_session){
            $option = json_decode($option_session[0], true);
            $total = $option['price'] * $option['qty'];

            $cart_content[] = $option;

            $price = $total;// + $shipping_cost;
        }
        else{
            $price = Cart::total(2);// + $shipping_cost;
            $total = Cart::total(2);
            $cart_content = Cart::content();
        }

        if(isset($data_request['ship'])){
            $shipping_type = explode('__', $data_request['ship'])[1] ?? '';
        }

        $database = array(
            'firstname' => $data['firstname'] ?? '',
            'lastname' => $data['lastname'] ?? '',
            'name' => $data['name'] ?? '',
            'cart_phone' => $data['phone'],
            'cart_email' => $data['email'],
            'cart_address' => $data['address_line1'],
            'shipping_type' => $data['delivery'] ?? '',
            'shipping_cost' => $shipping_cost,
            'cart_note' => $data['cart_note'],
            'payment_method'=> $data_request['payment_method']??'',
            'cart_total' => $total,
            'user_id' => Auth::check() ? Auth::user()->id : 0,
            'cart_code' => auto_code(),
            'cart_payment' => 2, //chua thanh toan
            'cart_status' => 1 // cho xac nhan
        );
        // dd($database);

        if($data['delivery'] == 'shipping'){
            $database['cart_address'] = $data['address_line1']?? '';
            $database['cart_address2'] = $data['address_line2'] ?? '';
            $database['city'] = $data['city_locality'] ?? '';
            $database['province'] = $data['state_province'] ?? '';
            $database['country_code'] = $data['country_code'] ?? '';
            $database['postal_code'] = $data['postal_code'] ?? '';
            $database['company'] = $data['company'] ?? '';
        }

        $respons = \App\Model\Addtocard::create($database);
        // dd($respons);
        $order_id = auto_code('Order', $respons->cart_id);
        \App\Model\Addtocard::where('cart_id', $respons->cart_id)->update(['cart_code' => $order_id]);
        $cart = \App\Model\Addtocard::where('cart_id', $respons->cart_id)->first();
        // dd($cart);
        //insert in Addtocard_Detail
        if($option_session){
            foreach($cart_content as $key => $value){
                $product_ = \App\Product::find($value['id']);
                $data_addcard_detal = [
                    'product_id' => $value['id'],
                    'cart_id'   => $respons->cart_id,
                    'admin_id'      => $product_->admin_id ?? 0,
                    'name'          => $product_->name,
                    'quanlity'      => $value['qty'],
                    'subtotal'      => $value['subtotal'] ?? ($value['price'] * $value['qty'])
                ];
                \App\Model\Addtocard_Detail::create($data_addcard_detal);
            }
        }
        else{
            foreach($cart_content as $key => $value){
                $data_addcard_detal = [
                    'product_id' => $value->id,
                    'cart_id'   => $respons->cart_id,
                    'admin_id'      => \App\Product::find($value->id)->admin_id ?? 0,
                    'name'          => $value->name,
                    'quanlity'      => $value->qty,
                    'subtotal'      => $value->subtotal
                ];
                // dd($data_addcard_detal);
                \App\Model\Addtocard_Detail::create($data_addcard_detal);
            }
        }

        
        $id_post = $respons->cart_id;
        $title = 'Order payment '. $order_id;
        
        if(Cart::count() || $option_session){
            if($price){
                try {
                    $data_email = $cart->toArray();
                    $data_email['email_admin'] = setting_option('email_admin');
                    $data_email['subject_default'] = 'Payment success';

                    $checkContent = ShopEmailTemplate::where('group', 'order_to_user')->where('status', 1)->first();
                    $checkContent_admin = ShopEmailTemplate::where('group', 'order_to_admin')->where('status', 1)->first();
                    if($checkContent || $checkContent_admin){
                        $email_admin       = setting_option('email_admin');
                        $company_name      = setting_option('company_name');
                        
                        $content = htmlspecialchars_decode($checkContent->text);
                        $content_admin = htmlspecialchars_decode($checkContent_admin->text);

                        $order_detail = \App\Model\Addtocard_Detail::where('cart_id', $id_post)->get();
                        $orderDetail = '';
                        foreach ($order_detail as $key => $detail) {
                            $product = $detail->getProduct;
                            $nameProduct = $detail->name;
                            $product_attr = '';
                            
                            if ($detail->attribute){
                                $attribute = json_decode(htmlspecialchars_decode($detail->attribute), true);
                                $attributesGroup = \App\Variable::where('status', 0)->where('parent', 0)->pluck('name', 'id')->all();
                                
                                foreach ($attribute as $groupAtt => $att){
                                    $product_attr .= '<tr><td>' . $attributesGroup[$groupAtt] .'</td><td><strong>'. render_option_name($att) .'</strong></td></tr>';
                                }
                            }
                            $orderDetail .= '<tr><td colspan="2"><b>' . ($key + 1) .'.'. $detail->name .'</b></td></tr>';
                            $orderDetail .= $product_attr;
                            $orderDetail .= '<tr><td width="150">Price:</td><td><strong>' .render_price($detail->subtotal/$detail->quanlity) . '</strong></td></tr>';
                            $orderDetail .= '<tr><td>Qty:</td><td><strong>' . number_format($detail->quanlity) . '</strong></td></tr>';
                            $orderDetail .= '<tr><td>Total:</td><td><strong>' . render_price($detail->subtotal) . '</strong></td></tr>';
                            $orderDetail .= '<tr><td colspan="2"><hr></td></tr>';
                        }

                        //Phương thức nhận hàng
                        $receive = $cart->shipping_type ? '' : 'pick_up';
                        // $receive_method = $cart->shipping_type ? 'Nhận hàng: '.$cart->shipping_type : 'Pick up';
                        // $receive_html = '<p>- '. $receive_method .'</p>';
                        $receive_html = '';
                        if($receive == 'pick_up'){
                            $address_full = '';
                            $receive_html .= '<div>- Nhận tại cửa hàng: </div>'. htmlspecialchars_decode(setting_option('pickup_address'));
                        }
                        else{
                            $address_full = implode(', ', array_filter([$cart->cart_address , $cart->city, $cart->province, $cart->country_code]));
                            $receive_html .= '<p>- Vận chuyển đến: '. $address_full .'<p>';
                        }

                        //phuong thuc thanh toan
                        $payment_method = $cart->payment_method ?? 'cash';
                        $payment_method_html = '';
                        if($payment_method == 'cash')
                            $payment_method_html = '<div>- Thanh toán bằng tiền mặt khi nhận hàng</div>';
                        else{
                            $payment_method_html = '<div class="mb-3">- '. __('bank_transfer') .'</div>';
                            $payment_method_html .= htmlspecialchars_decode(setting_option('banks'));
                        }

                        $dataFind = [
                            '/\{\{\$orderID\}\}/',
                            '/\{\{\$toname\}\}/',
                            '/\{\{\$email\}\}/',
                            '/\{\{\$address\}\}/',
                            '/\{\{\$phone\}\}/',
                            '/\{\{\$comment\}\}/',
                            '/\{\{\$subtotal\}\}/',
                            '/\{\{\$total\}\}/',
                            '/\{\{\$receive\}\}/',
                            '/\{\{\$orderDetail\}\}/',
                            '/\{\{\$payment_method\}\}/',
                        ];
                        $dataReplace = [
                            $order_id ?? '',
                            $data_email['name'] ?? '',
                            $data_email['cart_email'] ?? '',
                            $data_email['cart_address']??'',
                            $data_email['cart_phone']??'',
                            $data_email['cart_note']??'',
                            render_price($cart->cart_total - $cart->shipping_cost),
                            render_price($cart->cart_total),
                            $receive_html,
                            $orderDetail,
                            $payment_method_html,
                        ];
                        $content = preg_replace($dataFind, $dataReplace, $content);
                        $content_admin = preg_replace($dataFind, $dataReplace, $content_admin);
                        // dd($content);
                        $dataView = [
                            'content' => $content,
                        ];
                        $config = [
                            'to' => $data_email['cart_email'],
                            'subject' => 'Đơn hàng mới - Mã đơn hàng: '.$order_id,
                        ];

                        $dataView_sys = [
                            'content' => $content_admin,
                        ];
                        $config_sys = [
                            'to' => $email_admin,
                            'subject' => 'Đơn hàng mới - Mã đơn hàng: '.$order_id,
                        ];

                        $send_mail = new SendMail( 'email.content', $dataView, $config );
                        $sendEmailJob = new Job_SendMail($send_mail);
                        dispatch($sendEmailJob)->delay(now()->addSeconds(5));

                        $send_mail_admin = new SendMail( 'email.content', $dataView_sys, $config_sys );
                        $sendEmailJob_admin = new Job_SendMail($send_mail_admin);
                        dispatch($sendEmailJob_admin)->delay(now()->addSeconds(3));
                    }

                    Cart::destroy();
                    session()->forget('option');
                    session()->forget('cart-info');
                    if($option_session){
                        session()->forget('option_session');
                    }
                    session()->forget('cart_code');
                    session()->push('cart_code', $cart->cart_code);
                    return redirect()->route('cart.checkout.success');

                    /*$content_success = \App\Model\Page::find(94);

                    $link = '<a href="'. route('cart.view', $cart->cart_code) .'" title="">'. $cart->cart_code .'</a>';
                    $content_success->content = str_replace('{$order_link}', $link, $content_success->content);
                    // dd($content_success);
                    $this->data['seo'] = [
                        'seo_title' => $content_success->title,

                    ];
                    return view($this->templatePath .'.cart.checkout-success', ['content_success'=>$content_success]);*/
                } catch(Exception $e) {
                    return $e->getMessage();
                }
            }
        }
    }

    public function success()
    {
        $cart_code = session()->get('cart_code');
        if($cart_code){
            $cart = \App\Model\Addtocard::where('cart_code', $cart_code)->first();

            $content_success = \App\Model\Page::find(94);

            $link = '<a href="'. route('cart.view', $cart->cart_code) .'" title="">'. $cart->cart_code .'</a>';
            $content_success->content = str_replace('{$order_link}', $link, $content_success->content);
            // dd($content_success);
            $this->data['cart'] = $cart;
            $this->data['seo'] = [
                'seo_title' => $content_success->title,

            ];
            $this->data['content_success'] = $content_success;
            return view($this->templatePath .'.cart.checkout-success', $this->data);
        }
        return redirect(url('/'));
    }



    public function view($id)
    {
        if($id){
            // $this->data['order_status'] = $this->orderStatus();
            // $this->data['orderPayment'] = $this->orderPayment();
            // dd($this->orderPayment);
            $this->data['order'] = \App\Model\Addtocard::where('cart_code', $id)->first();
            $this->data['order_detail'] = \App\Model\Addtocard_Detail::where('cart_id', $this->data['order']->cart_id)->get();

            $total_price = isset($order_detail->total) ? $order_detail->total : 0;

            // $data = Addtocard::where('user_id', Auth::user()->id)->where('cart_id', $id_cart)->first();
            if($this->data['order']){
                $this->data['seo'] = [
                    'seo_title' => 'Đơn hàng - '. $this->data['order']->cart_code,

                ];
                return view($this->templatePath .'.cart.view', $this->data);
            }
            else
                return view('errors.404');
        }

    }

    public function requestPaymentSuccess($cart_code)
    {
        $cart = \App\Model\Addtocard::where('cart_code', $cart_code)->first();
        // dd($cart);
        if($cart)
        {
            $this->data['cart'] = $cart;
            $this->data['seo'] = [
                'seo_title' => 'Yêu cầu đã thanh toán cho đơn hàng '. $cart_code,
            ];
            return view($this->templatePath .'.cart.request_payment', $this->data);
        }
        else
            return view('errors.404');
    }

    public function post_requestPaymentSuccess()
    {
        $data_email = request()->all();

        $checkContent = ShopEmailTemplate::where('group', 'request_payment_success')->where('status', 1)->first();
        if($checkContent){
            $email_admin       = 'huunamtn@gmail.com';// setting_option('email_admin');
            $company_name      = setting_option('company_name');
            
            $content = htmlspecialchars_decode($checkContent->text);
            $orderID_link = '<a href="'. route('cart.view', $data_email['cart_code']) .'">'. $data_email['cart_code'] .'</a>';
            $dataFind = [
                '/\{\{\$orderID_link\}\}/',
                '/\{\{\$orderID\}\}/',
                '/\{\{\$toname\}\}/',
                '/\{\{\$email\}\}/',
                '/\{\{\$phone\}\}/',
                '/\{\{\$comment\}\}/',
            ];
            $dataReplace = [
                $orderID_link ?? '',
                $data_email['cart_code'] ?? '',
                $data_email['request_name'] ?? '',
                $data_email['request_email'] ?? '',
                $data_email['request_phone']??'',
                $data_email['request_message']??'',
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);

            $dataView = [
                'content' => $content,
            ];
            $config = [
                'to' => $email_admin,
                'subject' => 'Thông báo đơn hàng '.$data_email['cart_code'] . ' đã được thanh toán.',
            ];

            $file_path = '';
            $attach = [];
            $folderPath = '/images/paid-file';
            if(isset($data_email['request_file'])){
                $file = request()->file("request_file");

                $filename_original = $file->getClientOriginalName();
                $filename_ = pathinfo($filename_original, PATHINFO_FILENAME);
                $extension_ = pathinfo($filename_original, PATHINFO_EXTENSION);

                $file_slug = Str::slug($filename_);
                $file_name = uniqid() . '-' . $file_slug . '.' . $extension_;
                $img_name = $folderPath . '/' . $file_name;
                $file_path = $img_name;

                $attach['fileAttach'][] = [
                        'file_path' => asset($img_name),
                        'file_name' => $filename_
                ];
                
                $file->move(base_path().$folderPath, $file_name);
            }

            \App\Model\ContactPayment::create([
                'name' => $data_email['request_name'] ?? '',
                'email' => $data_email['request_email'] ?? '',
                'phone' => $data_email['request_phone']??'',
                'content' => $data_email['request_message']??'',
                'file' => $file_path,
            ]);

            $send_mail = new SendMail( 'email.content', $dataView, $config , $attach);
            $sendEmailJob = new Job_SendMail($send_mail);
            dispatch($sendEmailJob)->delay(now()->addSeconds(5));

            return response()->json(
                [
                    'error' => 0,
                    'view' => view($this->templatePath .'.cart.includes.send_request_payment_success')->render(),
                    'msg'   => __('Login success')
                ]
            );
        }
    }

    public function getStamps(Request $request)
    {
        dd($request->all());
    }

    public function stampsForm($value='')
    {
        return view($this->templatePath .'.stamps.form');
    }

    public function orderStatus()
    {
        $data = [
            '0' => 'Chờ xác nhận',
            '1' => 'Đã hủy',
            '2' => 'Đã nhận',
            '3' => 'Đang giao hàng',
            '4' => 'Hoàn thành',
        ];

        return $data;
    }

    public function orderPayment()
    {
        $data = [
            '0' => 'Chưa thanh toán',
            '1' => 'Đã thanh toán',
        ];

        return $data;
    }
}
