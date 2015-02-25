<?php

namespace Fourum\Http\Controllers\Admin;

use Fourum\Http\Controllers\AdminController;

class IndexController extends AdminController
{
    public function index()
    {
        return view('index');
    }
}
