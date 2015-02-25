<?php

namespace Fourum\Http\Controllers\Front;

use Fourum\Http\Controllers\FrontController;
use Fourum\Model\Node;

class HomeController extends FrontController
{
    public function index()
    {
        $data['tree'] = Node::root();
        return $this->render('index', $data);
    }
}
