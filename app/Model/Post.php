<?php

namespace Fourum\Model;

use Carbon\Carbon;
use Fourum\Notification\NotifierInterface;
use Fourum\Post\PostInterface;
use Fourum\Reporting\ReportableInterface;
use Fourum\User\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\URL;

/**
 * @property string content
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed user_id
 */
class Post extends Model implements PostInterface, ReportableInterface, NotifierInterface
{
    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function getThread()
    {
        return $this->belongsTo('Fourum\Model\Thread', null, null, 'thread')->first();
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = nl2br($content, "<br>");
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return UserInterface
     */
    public function getAuthor()
    {
        return $this->getUser();
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
        return 'post_id';
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function isAuthor(UserInterface $user)
    {
        return $this->user_id === $user->getId();
    }

    /**
     * @return bool
     */
    public function isEdited()
    {
        return $this->created_at != $this->updated_at;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt()
    {
        return $this->updated_at->format('d/m/Y H:i:s');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return URL::route('post.view', array($this->getId()));
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return 'post';
    }

    /**
     * @return BelongsTo
     */
    public function getUser()
    {
        return $this->belongsTo('Fourum\Model\User', null, null, 'user')->first();
    }
}