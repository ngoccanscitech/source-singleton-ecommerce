<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;

class ContactController extends Controller
{
    use \App\Traits\LocalizeController;
    
    public $data = [
        'error' => false,
        'success' => false,
        'message' => ''
    ];

    public function index(){
        $this->localized();
        $this->data['page'] = \App\Page::where('slug', 'contact')->first();
        // dd($this->data['page']);
        return view($templatePath .'.page.contact', ['data' => $this->data]);
    }

    public function getContact(Request $request,$type)
    {
        if($type == 'request-contact')
        {
            $this->data['status'] = 'success';
            $this->data['type'] = $type;
            $this->data['url_current'] = $request->url_current;
            $this->data['product_title'] = $request->product_title;
            $this->data['view'] = view('theme.page.includes.get-contact-form', ['data' => $this->data ])->render();
        }

        return response()->json($this->data);
    }
    
    public function submit(Request $rq) {
        $detail = $rq->input('contact', false);
        // dd($detail);
        if($detail){
            $email = new \App\Mail\contactMail($detail);
            $sendto =  \App\Libraries\Helpers::get_option_minhnn('email');
            try {
                Mail::to($sendto)->send($email);
            } catch (\Exception $e) {
                $this->data['message'] = 'sendMailError';
                $this->data['error'] = true;
                return $this->index();
            }
            
            $this->data['success'] = true;
            $this->data['message'] = 'sendMalSuccess';
            return $this->index();
        }
    }
}
