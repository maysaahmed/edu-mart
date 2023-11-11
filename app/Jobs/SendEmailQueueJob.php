<?php

namespace App\Jobs;

use App\Core\Interfaces\Services\IMailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendEmailQueueDemo;
use Mail;

class SendEmailQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected string $send_mail, $send_name, $link;
    private IMailService $mail;
    /**
     * Create a new job instance.
     *
     * @param $send_mail
     * @param $send_name
     * @param $link
     */
    public function __construct($send_mail, $send_name, $link)
    {
        $this->send_mail = $send_mail;
        $this->send_name = $send_name;
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->mail->sendMail($this->send_mail,$this->send_name,$this->link);

//        $email = new SendEmailQueue();
//        Mail::to($this->send_mail)->send($email);
    }
}
