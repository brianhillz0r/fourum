<?php

namespace Fourum\Model\Permission;

class UserRoamingPermission
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'user_roaming_permissions';
}