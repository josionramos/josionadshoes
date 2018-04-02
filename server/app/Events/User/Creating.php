<?php

namespace App\Events\User;

use App\User;

class Creating
{
    /**
     * Constructor.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $user->token = $this->createToken();
    }

    /**
     * Create user token.
     *
     * @return string
     */
    protected function createToken()
    {
        $random = strtoupper(str_random(4));

        return md5(date('ymd') . $random . date('His'));
    }
}
