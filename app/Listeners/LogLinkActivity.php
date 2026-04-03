<?php

namespace App\Listeners;

use App\Events\LinkCreated;
use App\Events\LinkDeleted; 
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class LogLinkActivity
{
    public function handle($event): void
    {
        $action = '';
        $description = '';
        $user = Auth::user();

               if (!$user) {
            return;
        }

        if ($event instanceof LinkCreated) {
            $action = 'creation';
            $description = 'User ' . $user->name . " added a new link: " . $event->link->title;
        } 
        elseif ($event instanceof LinkDeleted) {
            $action = 'deletion';
            $description = 'The user ' . $user->name . " deleted the link: " . $event->link->title;
        }

       
        if ($action !== '') {
            ActivityLog::create([
                'user_id'     => $user->id,
                'action'      => $action,
                'description' => $description,
            ]);
        }
    }
}