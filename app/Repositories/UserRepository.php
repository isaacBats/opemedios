<?php

namespace App\Repositories;

use App\User;
use Validator;

class UserRepository
{
    public function all () {

        return User::all();

    }

    public function create ($data) {

        return User::create($data);
    }
}