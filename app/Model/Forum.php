<?php

namespace Fourum\Model;

use Fourum\Forum\ForumInterface;
use Fourum\Model\Forum\Type;
use Fourum\Tree\NodeRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

/**
 * @property mixed id
 * @property mixed type
 * @property mixed title
 */
class Forum extends Model implements ForumInterface
{
    /**
     * @var string
     */
    protected $table = 'forums';

    /**
     * @var NodeRepositoryInterface
     */
    private $nodeRepository;

    public function __construct()
    {
        parent::__construct();

        $this->nodeRepository = App::make('Fourum\Tree\NodeRepositoryInterface');
    }

    /**
     * Get the Type of the Forum
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('Fourum\Model\Forum\Type');
    }

    /**
     * @return HasMany
     */
    public function getThreads()
    {
        return $this->hasMany('Fourum\Model\Thread')->get();
    }

    public function getNode()
    {
        return $this->nodeRepository->getByForum($this->id);
    }

    /**
     * @return boolean
     */
    public function isCategory()
    {
        return $this->type === Type::getCategoryType()->id;
    }

    /**
     * @return boolean
     */
    public function isForum()
    {
        return $this->type === Type::getForumType()->id;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return url("/forum/{$this->getId()}/{$this->getUrlFriendlyTitle()}");
    }

    /**
     * @return string
     */
    public function getUrlFriendlyTitle()
    {
        return strtolower(str_replace(' ', '-', preg_replace("/[^A-Za-z0-9 ]/", '', $this->getTitle())));
    }
}