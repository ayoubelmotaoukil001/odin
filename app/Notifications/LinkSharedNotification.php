<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Link;
use App\Models\User;


class LinkSharedNotification extends Notification
{
    use Queueable;

    /** @var \App\Models\Link */
    public $link;

    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        return [
            'link_id' => $this->link->id,
            'message' => $user->name . ' shared a link with you: ' . $this->link->title,
        ];
    }
    
}