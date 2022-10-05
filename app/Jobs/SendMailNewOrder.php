<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Model\Theme;
use Cart;



class SendMailNewOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $tries = 1;
    public $data=[];
    public function __construct($data=[])
    {
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data_mail = $this->data;
        if(isset($data_mail['type']) && $data_mail['type']=="rating") {
            //send mail admin when user rating product
            Mail::send('email.user_rating',
                $data_mail,
                function($message) use ($data_mail) {
                    $message->from($data_mail['email_admin']);
                    $message->to($data_mail['email_admin'])//$data_mail['email_admin']
                    ->subject('Đánh giá sản phẩm từ khách hàng');
                });
        }
        else{

            $cart_decode = $data_mail['cart_content'];
        //send mail admin
            $data_admin = $data_mail['data_admin'];
            $data_admin['cart1'] = $cart_decode;
            Mail::send('email.cart',
                $data_admin,
                function($message) use ($data_admin) {
                    $message->from($data_admin['email_admin'],$data_admin['name']);
                    $message->to($data_admin['email_admin'])//$data_admin['email_admin']
                    ->subject("Đơn hàng mới từ: ".$data_admin['name']);
                }
            );

        //send mail customer
            $data = $data_mail['data_customer'];
            $data['cart2'] = $cart_decode;
            Mail::send('email.customer_cart',
                $data,
                function($message) use ($data) {
                    $message->from($data['email'],'Siêu thị Miền Nam');
                    $message->to($data['email'])
                    ->subject($data['subject_default']);
                }
            );


            //send mail to user admin
            $cart_decode = $data_mail['cart_content'];
            $info_cart_detail = $data_mail['info_cart_detail'];
            $data_send_mail=[];
            $user_info_user=[];

            foreach($cart_decode as $key => $value){
                foreach($info_cart_detail as $value_inf){
                    if($value->id==$value_inf->product_id){
                        $user_id = $value_inf->admin_id;
                        $data_send_mail[$user_id][]=$value;
                        $user_info_user[$user_id]['email']=$value_inf->email_info;
                        $user_info_user[$user_id]['name']=$value_inf->name;
                        break;
                    }
                }
            }

            foreach($data_send_mail as $key_sm => $value_sm){
                $data = $data_mail['data_customer'];
                $data['cart3'] = $value_sm;
                $email_user = $user_info_user[$key_sm]['email'];
                $data['name_user'] = $user_info_user[$key_sm]['name'];
                Mail::send('email.staff_order',
                    $data,
                    function($message) use ($data, $email_user) {
                        $message->from($email_user,'Siêu thị Miền Nam');
                        $message->to($email_user)
                        ->subject("Đơn hàng mới từ: Siêu thị Miền Nam");
                    }
                );
            }
    } //end
    }//end handle
}
