<?php

namespace Fourum\Http\Controllers\Admin;

use Fourum\Effect\EffectConfiguration;
use Fourum\Effect\EffectRegistry;
use Fourum\Effect\EffectRepositoryInterface;
use Fourum\Http\Controllers\AdminController;
use Fourum\Menu\TabbedMenu;
use Fourum\Model\Effect;
use Fourum\Permission\Checker\CheckerInterface;
use Fourum\Permission\Permission;
use Fourum\Permission\UserPermissionRepositoryInterface;
use Fourum\Setting\Manager;
use Fourum\User\UserRepositoryInterface;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;

class UsersController extends AdminController
{
    /**
     * @var UserRepositoryInterface
     */
    protected $users;

    /**
     * @param Manager $settings
     * @param UserRepositoryInterface $users
     */
    public function __construct(Manager $settings, UserRepositoryInterface $users)
    {
        parent::__construct($settings);

        $this->users = $users;
    }

    public function index()
    {
        return view('users.index', ['users' => $this->users->getAll()]);
    }

    /**
     * @param UserPermissionRepositoryInterface $userPermissions
     * @param EffectRepositoryInterface $effects
     * @param EffectRegistry $effectsRegistry
     * @param CheckerInterface $permission
     * @param Dispatcher $dispatcher
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function manage(
        UserPermissionRepositoryInterface $userPermissions,
        EffectRepositoryInterface $effects,
        EffectRegistry $effectsRegistry,
        CheckerInterface $permission,
        Dispatcher $dispatcher,
        $id
    ) {
        $user = $this->users->get($id);
        $this->setTitle($user->getUsername());
        $permissionNames = $userPermissions->getPermissionNames();

        $permissions = [];

        foreach ($permissionNames as $name) {
            $permissions[$name] = $permission->check($name, $user);
        }

        $profileMenu = new TabbedMenu();
        $dispatcher->fire('admin.user.manage.menu', [$profileMenu, $user]);

        $currentEffects = [];

        foreach ($effects->getEffectsForEffectable($user) as $effectModel) {
            $genericEffect = new \StdClass;
            $genericEffect->effect = $effectsRegistry->get($effectModel->effect);
            $genericEffect->effectModel = $effectModel;
            $currentEffects[$genericEffect->effect->getInternalName()] = $genericEffect;
        }

        $availableEffects = $effectsRegistry->filter(function ($effect) use ($user, $currentEffects) {
            return $effect->supports($user) && ! array_key_exists($effect->getInternalName(), $currentEffects);
        });

        $data = [
            'user' => $user,
            'permissions' => $permissions,
            'menu' => $profileMenu,
            'availableEffects' => $availableEffects,
            'currentEffects' => $currentEffects
        ];

        return view('users.view', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $user = $this->users->get($request->get('id'));
        $user->fill($request->only(['username', 'email']));

        $this->users->save($user);

        return redirect('/admin/users/manage/' . $request->get('id'));
    }

    /**
     * @param Request $request
     * @param UserPermissionRepositoryInterface $userPermissions
     * @return \Illuminate\Http\RedirectResponse
     */
    public function permissionsSave(Request $request, UserPermissionRepositoryInterface $userPermissions)
    {
        $user = $this->users->get($request->get('id'));

        foreach ($userPermissions->getPermissionNames() as $name) {
            $value = $request->get($name) ? true : false;
            $permission = new Permission($name, $value, $user);
            $userPermissions->save($permission);
        }

        return redirect('/admin/users/manage/' . $request->get('id'));
    }

    /**
     * @param Request $request
     * @param EffectRegistry $effects
     * @return \Illuminate\Http\RedirectResponse
     */
    public function applyEffect(Request $request, EffectRegistry $effects)
    {
        $user = $this->users->get($request->get('user_id'));
        $effect = $effects->get($request->get('effect'));

        $config = new EffectConfiguration([
            'unit' => $request->get('unit'),
            'length' => $request->get('length')]
        );

        $effect->apply($user, $config);

        return redirect('/admin/users/manage/' . $user->getId());
    }
}
