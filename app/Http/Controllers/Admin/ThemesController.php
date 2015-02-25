<?php

namespace Fourum\Http\Controllers\Admin;

use Fourum\Http\Controllers\AdminController;

class ThemesController extends AdminController
{
    public function index()
    {
        return view('themes.index');
    }
}
