<?php

namespace Fourum\Post;

use Fourum\Decorator\AbstractDecorator;
use Fourum\Notification\NotifierInterface;
use Fourum\Reporting\ReportableInterface;
use Fourum\Reporting\ReportRepositoryInterface;
use Fourum\Thread\ThreadInterface;
use Fourum\User\UserInterface;

class PostWithReportedCount extends AbstractDecorator implements PostInterface, ReportableInterface, NotifierInterface
{
    /**
     * @var ReportRepositoryInterface
     */
    protected $reports;

    /**
     * @var int
     */
    private $reportedCount;

    /**
     * @param PostInterface $post
     * @param ReportRepositoryInterface $reports
     */
    public function __construct(PostInterface $post, ReportRepositoryInterface $reports)
    {
        parent::__construct($post);

        $this->reports = $reports;
    }

    /**
     * @return PostInterface|ReportableInterface|NotifierInterface
     */
    public function getDecorated()
    {
        return parent::getDecorated();
    }

    /**
     * @return int
     */
    public function getReportedCount()
    {
        if (! $this->reportedCount) {
            $reports = $this->reports->getByReportable($this->getDecorated());
            $this->reportedCount = count($reports);
        }

        return $this->reportedCount;
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