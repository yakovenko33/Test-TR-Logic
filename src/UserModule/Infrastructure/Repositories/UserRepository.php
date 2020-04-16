<?php

namespace App\UserModule\Infrastructure\Interfaces;


use App\UserModule\Domain\Entities\User;
use TestFramework\Components\Database\DB;

class UserRepository implements UserRepositoryInterfaces
{
    /**
     * @param User $user
     * @return User
     */
    public function insert(User $user): User
    {

    }
}