<?php

namespace Fourum\Http\Controllers\Admin;

use Fourum\Group\GroupRepositoryInterface;
use Fourum\Http\Controllers\AdminController;
use Fourum\Permission\Checker\CheckerInterface;
use Fourum\Permission\Eloquent\GroupPermissionRepository;
use Fourum\Permission\GroupPermissionRepositoryInterface;
use Fourum\Permission\Permission;
use Fourum\Setting\Manager;
use Fourum\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class GroupsController extends AdminController
{
    /**
     * @var CheckerInterface
     */
    protected $permission;

    /**
     * @var GroupRepositoryInterface
     */
    protected $groups;

    /**
     * @param CheckerInterface $permission
     * @param Manager $settings
     * @param GroupRepositoryInterface $groups
     */
    public function __construct(CheckerInterface $permission, Manager $settings, GroupRepositoryInterface $groups)
    {
        parent::__construct($settings);

        $this->permission = $permission;
        $this->groups = $groups;
    }

    public function index()
    {
        return view('groups.index', ['groups' => $this->groups->getAll()]);
    }

    public function add()
    {
        return view('groups.add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdd(Request $request)
    {
        $this->groups->createAndSave([
            'name' => $request->get('name')
        ]);

        return redirect('admin/groups');
    }

    /**
     * @param int $id
     */
    public function view($id)
    {
        return view('groups.view', ['group' => $this->groups->get($id)]);
    }

    /**
     * @param UserRepositoryInterface $users
     * @param \Fourum\User\Group\GroupRepositoryInterface $userGroups
     * @param int $groupId
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(
        UserRepositoryInterface $users,
        \Fourum\User\Group\GroupRepositoryInterface $userGroups,
        $groupId,
        $userId
    ) {
        $group = $this->groups->get($groupId);
        $user = $users->get($userId);

        $userGroups->remove($user, $group);

        return redirect('admin/groups/view/' . $groupId);
    }

    /**
     * @param Request $request
     * @param UserRepositoryInterface $users
     * @param \Fourum\User\Group\GroupRepositoryInterface $userGroups
     */
    public function addUser(
        Request $request,
        UserRepositoryInterface $users,
        \Fourum\User\Group\GroupRepositoryInterface $userGroups
    ) {

        $user = $users->getByUsername($request->get('username'));
        $group = $this->groups->get($request->get('groupId'));

        $userGroups->assign($user, $group);

        return redirect('admin/groups/view/' . $request->get('groupId'));
    }

    /**
     * @param GroupPermissionRepositoryInterface $groupPermissions
     * @param int $id
     */
    public function edit(GroupPermissionRepositoryInterface $groupPermissions, $id)
    {
        $group = $this->groups->get($id);
        $permissionNames = $groupPermissions->getPermissionNames();

        $permissions = [];
        $hardPermissions = [
            GroupPermissionRepository::CAN_ADMINISTRATE,
            GroupPermissionRepository::CAN_MODERATE
        ];

        foreach ($permissionNames as $name) {
            $permissions[$name] = $this->permission->check(
                $name,
                $group,
                null,
                in_array($name, $hardPermissions)
            );
        }

        $data['group'] = $group;
        $data['permissions'] = $permissions;

        return view('groups.edit', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $group = $this->groups->get($request->get('groupId'));
        $group->setName($request->get('name'));

        $this->groups->save($group);

        return redirect('admin/groups/edit/' . $request->get('groupId'));
    }

    /**
     * @param Request $request
     * @param GroupPermissionRepositoryInterface $groupPermissions
     * @return \Illuminate\Http\RedirectResponse
     */
    public function permissionsSave(Request $request, GroupPermissionRepositoryInterface $groupPermissions)
    {
        $groupId = $request->get('groupId');
        $group = $this->groups->get($groupId);

        foreach ($groupPermissions->getPermissionNames() as $name) {
            $value = $request->get($name) ? true : false;
            $permission = new Permission($name, $value, $group);
            $groupPermissions->save($permission);
        }

        return redirect('/admin/groups/edit/' . $groupId);
    }
}
