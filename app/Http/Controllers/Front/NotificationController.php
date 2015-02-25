<?php

namespace Fourum\Http\Controllers\Front;

use Fourum\Http\Controllers\FrontController;
use Fourum\Notification\NotificationRepositoryInterface;

class NotificationController extends FrontController
{
    /**
     * @param NotificationRepositoryInterface $notifications
     */
    public function index(NotificationRepositoryInterface $notifications)
    {
        return $this->render('notification.index', [
            'notifications' => $notifications->getAll($this->getUser())
        ]);
    }

    /**
     * @param NotificationRepositoryInterface $notifications
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markRead(NotificationRepositoryInterface $notifications)
    {
        $notifications->markAllRead($this->getUser());
        return redirect()->back();
    }
}