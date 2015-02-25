<?php

namespace Fourum\Model;

use Fourum\Group\GroupInterface;
use Fourum\Permission\PermissibleInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed name
 * @property mixed id
 */
class Group extends Model implements GroupInterface, PermissibleInterface
{
    /**
     * @var string
     */
    protected $table = 'groups';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->belongsToMany('Fourum\Model\User', 'user_groups')->withTimestamps()->get()->all();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @return string
     */
    public function getForeignKey()
    {
        return 'group_id';
    }
}