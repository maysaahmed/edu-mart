<?php

namespace App\Core\Interfaces\Services;

interface IMailService
{
    public function sendMail(string $email, string $name, string $link = null): bool;
    public function sendUserVerifyMail(string $email, string $name, string $link = null): bool;
    public function sendResetPasswordMail(string $email, string $link = null): bool;
}
