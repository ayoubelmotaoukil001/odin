<?php

namespace App\Observers;

use App\Models\Link;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class LinkObserver
{
    public function created(Link $link): void
    {
        $this->logAction('created', 'Created link: ' . $link->title);
    }

    public function updated(Link $link): void
    {
        $this->logAction('updated', 'Updated link: ' . $link->title);
    }

    public function deleted(Link $link): void
    {
        $this->logAction('deleted', 'Moved link to trash: ' . $link->title);
    }

    private function logAction(string $action, string $description): void
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'description' => $description,
            ]);
        }
    }
}