<?php

namespace Fourum\Model\Notification;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property int id
 */
class Type extends Model
{
    protected $table = 'notification_types';

    protected $guarded = ['id'];

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}