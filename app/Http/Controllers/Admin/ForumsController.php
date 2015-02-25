<?php

namespace Fourum\Http\Controllers\Admin;

use Fourum\Forum\ForumRepositoryInterface;
use Fourum\Http\Controllers\AdminController;
use Fourum\Model\Forum\Type;
use Fourum\Model\Node;
use Fourum\Tree\NodeRepositoryInterface;
use Illuminate\Http\Request;

class ForumsController extends AdminController
{
    public function index()
    {
        return view('forums.index', ['tree' => Node::root()]);
    }

    public function add()
    {
        return view('forums.add', [
            'tree' => Node::root(),
            'types' => Type::all()
        ]);
    }

    /**
     * @param Request $request
     * @param ForumRepositoryInterface $forums
     * @param NodeRepositoryInterface $nodes
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, ForumRepositoryInterface $forums, NodeRepositoryInterface $nodes)
    {
        $parent = $request->get('parent');

        $forum = $forums->createAndSave([
            'title' => $request->get('title'),
            'type' => $request->get('type')
        ]);

        $forumNode = $nodes->create(['forum_id' => $forum->id]);

        if ($parent !== "null") {
            $parent = $forums->get($parent);
            $parentNode = $parent->getNode();

            $forumNode->makeChildOf($parentNode);
        } else {
            $forumNode->makeChildOf(Node::root());
        }

        return redirect('admin/forums');
    }
}
