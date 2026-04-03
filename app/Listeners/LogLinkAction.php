<?php

namespace App\Listeners;

use App\Events\LinkActionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogLinkAction
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LinkActionEvent $event): void
    {
        \App\Models\ActivityLog::create([
            'user_id' => $event->user->id,
            'action' => $event->action,
            'description' => "{$event->user->name} has {$event->action} the link: {$event->link->title}",
        ]);
    }
}
