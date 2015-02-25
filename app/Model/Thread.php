<?php

namespace Fourum\Model;

use Fourum\Reporting\ReportableInterface;
use Fourum\Thread\ThreadInterface;
use Fourum\User\UserInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string title
 */
class Thread extends Model implements ThreadInterface, ReportableInterface
{
    /**
     * @var string
     */
    protected $table = 'threads';

    /**
     * @var array
     */
    protected $guarded = ['id'];

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
        return 'thread_id';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return url("thread/{$this->id}/{$this->getUrlFriendlyTitle()}");
    }

    /**
     * @return string
     */
    public function getUrlFriendlyTitle()
    {
        return strtolower(str_replace(' ', '-', preg_replace("/[^A-Za-z0-9 ]/", '', $this->getTitle())));
    }

    /**
     * @return UserInterface
     */
    public function getAuthor()
    {
        return $this->user()->get();
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return Post::where('thread_id', '=', $this->getId())->paginate(10);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getForum()
    {
        return $this->belongsTo('Fourum\Model\Forum', null, null, 'forum')->first();
    }
}