<?php

namespace App\Infrastructure\Services;
use App\Mail\WelcomeMail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use  App\Core\Interfaces\Services\IMailService;

class MailService implements IMailService
{
    public function sendMail(string $email, string $name, string $link = null): bool
    {
        Mail::to($email)->send(new WelcomeMail($name, $link));
        return true;
    }
    public function sendResetPasswordMail(string $email, string $link = null): bool
    {
        Mail::to($email)->send(new ResetPasswordMail($link));
        return true;
    }
}
