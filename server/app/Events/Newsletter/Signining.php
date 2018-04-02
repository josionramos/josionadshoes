<?php

namespace App\Events\Newsletter;

use App\Models\Newsletter\Lead;

class Signining
{
    protected $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
        $this->createToken();
    }

    public function createToken()
    {
        $date = date('ymd');
        $time = date('Hms');
        $str = strtoupper(str_random(5));

        $token = $date . $str . $time;

        $this->lead->token = $token;
    }
}
