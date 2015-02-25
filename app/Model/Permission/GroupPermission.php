<?php

namespace Fourum\Model\Permission;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int value
 */
class GroupPermission extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var string
     */
    protected $table = 'group_permissions';

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}