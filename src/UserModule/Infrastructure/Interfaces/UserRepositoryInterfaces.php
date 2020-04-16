<?php

namespace App\UserModule\Infrastructure\Interfaces;

use App\UserModule\Domain\Entities\User;

interface UserRepositoryInterfaces
{
    /**
     * @param User $user
     * @return User
     */
    public function insert(User $user): User;
}