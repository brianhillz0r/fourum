<?php

namespace Fourum\Http\Controllers\Front;

use Fourum\Http\Controllers\FrontController;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class AuthController extends FrontController
{
    public function getLogin()
    {
        return $this->render('auth.login');
    }

    /**
     * @param Request $request
     * @param Guard $auth
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request, Guard $auth, Redirector $redirect)
    {
        if ($auth->attempt($request->only('email', 'password'))) {
            return $redirect->intended();
        } else {
            return $redirect->to('auth/login')->with('message', 'Login failed: Incorrect email/password combination');
        }
    }

    /**
     * @param Guard $auth
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout(Guard $auth)
    {
        $auth->logout();
        return redirect('auth/login');
    }

    /**
     * @param Guard $auth
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogout(Guard $auth)
    {
        $auth->logout();
        return redirect('auth/login');
    }

    public function getBanned()
    {
        return $this->render('errors.banned');
    }
}