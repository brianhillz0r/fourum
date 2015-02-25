<?php

namespace Fourum\Model\Permission;

use Illuminate\Database\Eloquent\Model;

class GroupRoamingPermission extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'group_roaming_permissions';
}