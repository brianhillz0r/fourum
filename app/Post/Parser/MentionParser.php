<?php

namespace Fourum\Post\Parser;

use Fourum\Notification\Mention;
use Fourum\Notification\NotifiableInterface;
use Fourum\Notification\NotificationRepositoryInterface;
use Fourum\Notification\NotifierInterface;
use Fourum\Post\PostInterface;
use Fourum\User\UserRepositoryInterface;
use Illuminate\Contracts\Routing\UrlGenerator;

class MentionParser implements ParserInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $usersRepo;

    /**
     * @var NotificationRepositoryInterface
     */
    protected $notificationsRepo;

    /**
     * @var UrlGenerator
     */
    protected $urlGenerator;

    /**
     * @param UserRepositoryInterface $usersRepo
     * @param NotificationRepositoryInterface $notificationsRepo
     * @param UrlGenerator $urlGenerator
     */
    public function __construct(
        UserRepositoryInterface $usersRepo,
        NotificationRepositoryInterface $notificationsRepo,
        UrlGenerator $urlGenerator
    ) {
        $this->usersRepo = $usersRepo;
        $this->notificationsRepo = $notificationsRepo;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param PostInterface $post
     * @return PostInterface
     */
    public function parse(PostInterface $post)
    {
        $pattern = "/[@]+([A-Za-z0-9-_]+)/";
        $content = $post->getContent();

        preg_match_all($pattern, $content, $usernames);

        if (isset($usernames[1])) {
            foreach ($usernames[1] as $username) {
                $user = $this->usersRepo->getByUsername($username);

                if ($user) {
                    $url = $this->urlGenerator->route('user.profile', array($username));
                    $content = str_replace("@{$username}", "<a href=\"{$url}\">@{$username}</a>", $content);
                    $this->createNotification($user, $post);
                }
            }
        }

        $post->setContent($content);
        return $post;
    }

    /**
     * @param PostInterface $post
     * @return bool
     */
    public function supports(PostInterface $post)
    {
        return true;
    }

    /**
     * @param NotifiableInterface $user
     * @param NotifierInterface $post
     */
    protected function createNotification(NotifiableInterface $user, NotifierInterface $post)
    {
        $mention = new Mention($post, $user);
        $this->notificationsRepo->createAndSave($mention);
    }
}