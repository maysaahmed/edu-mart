<?php

namespace App\Infrastructure\Services;

use Carbon\Carbon;


class MailService implements IMailService
{
    public function sendMail(): string
    {
        return Carbon::parse($datetime)->diffForHumans();
    }
}
