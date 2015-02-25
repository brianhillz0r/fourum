<?php

namespace Fourum\Model\Permission;

use Illuminate\Database\Eloquent\Model;

class ForumPermission extends Model
{
    /**
     * @var string
     */
    protected $table = 'forum_permissions';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}