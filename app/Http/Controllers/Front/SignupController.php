<?php

namespace Fourum\Http\Controllers\Front;

use Fourum\Http\Controllers\FrontController;
use Fourum\Http\Requests\User\UserRegistrationRequest;
use Fourum\User\UserRepositoryInterface;
use Illuminate\Auth\Guard;

class SignupController extends FrontController
{
    public function getRegister()
    {
        return $this->render('signup.register');
    }

    /**
     * @param UserRegistrationRequest $request
     * @param UserRepositoryInterface $users
     * @param Guard $auth
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(UserRegistrationRequest $request, UserRepositoryInterface $users, Guard $auth)
    {
        $user = $users->createAndSave($request->only(['username', 'email', 'password']));
        $auth->login($user);
        return redirect('/');
    }
}
