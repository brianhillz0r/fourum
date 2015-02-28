<?php

namespace Fourum\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int permission_value
 */
class Effect extends Model
{
    protected $table = 'effects';
    protected $guarded = ['id'];
    protected $dates = ['expires'];

    /**
     * @return int
     */
    public function getPermissionValue()
    {
        return $this->permission_value;
    }
}