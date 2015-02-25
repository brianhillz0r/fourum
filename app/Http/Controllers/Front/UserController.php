<?php

namespace Fourum\Http\Controllers\Front;

use Fourum\Http\Controllers\FrontController;
use Fourum\User\UserRepositoryInterface;

class UserController extends FrontController
{
    /**
     * @param UserRepositoryInterface $users
     * @param string $username
     */
    public function profile(UserRepositoryInterface $users, $username)
    {
        return $this->render('user.profile', [
            'user' => $users->getByUsername($username)
        ]);
    }
}
