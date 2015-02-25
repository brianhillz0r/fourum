<?php

namespace Fourum\Model\Permission;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int value
 */
class UserPermission extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'user_permissions';

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}