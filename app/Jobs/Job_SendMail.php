<?php
 
namespace App\Jobs;
 
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
 
class Job_SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 
    protected $mail;
 
    public function __construct($mail)
    {
        $this->mail = $mail;
    }
 
    public function handle()
    {
        Mail::send($this->mail);
        if (Mail::failures()) {
            return response()->json([
                'error' => 1,
                'message'   => 'Send mail error'
            ]);
        }
    }
}