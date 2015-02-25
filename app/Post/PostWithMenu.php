<?php

namespace Fourum\Post;

use Fourum\Decorator\AbstractDecorator;
use Fourum\Menu\MenuInterface;
use Fourum\Notification\NotifierInterface;
use Fourum\Reporting\ReportableInterface;
use Fourum\Thread\ThreadInterface;
use Fourum\User\UserInterface;

class PostWithMenu extends AbstractDecorator implements PostInterface, ReportableInterface, NotifierInterface
{
    /**
     * @var MenuInterface
     */
    protected $menu;

    /**
     * @param PostInterface $post
     * @param MenuInterface $menu
     */
    public function __construct(PostInterface $post, MenuInterface $menu)
    {
        parent::__construct($post);

        $this->menu = $menu;
    }

    /**
     * @return PostInterface|ReportableInterface|NotifierInterface
     */
    public function getDecorated()
    {
        return parent::getDecorated();
    }

    /**
     * @return MenuInterface
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * @return ThreadInterface
     */
    public function getThread()
    {
        return $this->getDecorated()->getThread();
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->getDecorated()->setContent($content);
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function isAuthor(UserInterface $user)
    {
        return $this->getDecorated()->isAuthor($user);
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->getDecorated()->getEntityName();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getDecorated()->getId();
    }

    /**
     * @return string
     */
    public function getForeignKey()
    {
        return $this->getDecorated()->getForeignKey();
    }

    /**
     * @return UserInterface
     */
    public function getAuthor()
    {
        return $this->getDecorated()->getAuthor();
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->getDecorated()->getUrl();
    }
}