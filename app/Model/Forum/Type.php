<?php

namespace Fourum\Model\Forum;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
     * @var string
     */
    protected $table = 'forum_type';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getForums()
    {
        return $this->hasMany('Fourum\Model\Forum');
    }

    /**
     * @return Type
     */
    public static function getCategoryType()
    {
        return self::where('name', 'category')->first();
    }

    /**
     * @return Type
     */
    public static function getForumType()
    {
        return self::where('name', 'forum')->first();
    }
}