<?php

namespace App\Core\Interfaces\Services;

interface IMailService
{
    public function sendMail(): string;
}
