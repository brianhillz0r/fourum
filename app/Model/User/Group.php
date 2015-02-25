<?php

namespace Fourum\Model\User;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_groups';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}