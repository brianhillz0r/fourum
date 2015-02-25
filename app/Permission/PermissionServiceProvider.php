<?php

namespace Fourum\Permission;

use Fourum\Permission\Checker\CheckerSet;
use Fourum\Permission\Checker\ForumChecker;
use Fourum\Permission\Checker\GroupChecker;
use Fourum\Permission\Checker\GroupRoamingChecker;
use Fourum\Permission\Checker\ThreadChecker;
use Fourum\Permission\Checker\UserChecker;
use Fourum\Permission\Checker\UserRoamingChecker;
use Fourum\Permission\Eloquent\ForumPermissionRepository;
use Fourum\Permission\Eloquent\GroupPermissionRepository;
use Fourum\Permission\Eloquent\GroupRoamingPermissionRepository;
use Fourum\Permission\Eloquent\ThreadPermissionRepository;
use Fourum\Permission\Eloquent\UserPermissionRepository;
use Fourum\Permission\Eloquent\UserRoamingPermissionRepository;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Fourum\Permission\Checker\CheckerInterface', function ($app) {
            $forum          = new ForumChecker(new ForumPermissionRepository());
            $thread         = new ThreadChecker(new ThreadPermissionRepository());
            $groupRoaming   = new GroupRoamingChecker(new GroupRoamingPermissionRepository());
            $group          = new GroupChecker(new GroupPermissionRepository());
            $userRoaming    = new UserRoamingChecker(new UserRoamingPermissionRepository());
            $user           = new UserChecker(new UserPermissionRepository());

            /**
             * order is important here:
             *
             * - permissions the user owns (user)
             * - permissions the user has for other things (user roaming)
             * - permissions the group owns (group)
             * - permissions the group has for other things (group roaming)
             * - permissions the thread owns (thread)
             * - permissions the forum owns (forum)
             */
            $checker = new CheckerSet(array(
                $user,
                $userRoaming,
                $group,
                $groupRoaming,
                $thread,
                $forum
            ));

            return $checker;
        });

        $this->app->alias('Fourum\Permission\Checker\CheckerInterface', 'permissions');

        $this->app->bind(GroupPermissionRepositoryInterface::class, function ($app) {
            return $app->make(GroupPermissionRepository::class);
        });

        $this->app->bind(UserPermissionRepositoryInterface::class, function ($app) {
            return $app->make(UserPermissionRepository::class);
        });
    }
}