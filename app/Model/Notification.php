<?php

namespace Fourum\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed foreign_id
 * @property mixed type
 * @property mixed foreign_key
 * @property mixed id
 * @property mixed read
 * @property mixed created_at
 */
class Notification extends Model
{
    /**
     * @var string
     */
    protected $table = 'notifications';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return int
     */
    public function getType()
    {
        return $this->belongsTo('Fourum\Model\Notification\Type', 'type', null, 'type')->first();
    }

    /**
     * @return string
     */
    public function getForeignKey()
    {
        return $this->foreign_key;
    }

    /**
     * @return int
     */
    public function getForeignId()
    {
        return (int) $this->foreign_id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @return bool
     */
    public function isRead()
    {
        return (bool) $this->read;
    }

    public function markAsRead()
    {
        $this->read = true;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}