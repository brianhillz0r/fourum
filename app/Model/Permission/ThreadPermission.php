<?php

namespace Fourum\Model\Permission;

use Illuminate\Database\Eloquent\Model;

class ThreadPermission extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'thread_permissions';
}