<?php

namespace App\Models;

use App\User;

class Feedback extends \Mydnic\Kustomer\Feedback
{
    protected $fillable = ['reviewed'];

    private $user;

    public function getUser()
    {
        if (! $this->user) {
            $this->user = User::findOrFail($this->user_info['user_id']);
        }

        return $this->user;
    }
}
