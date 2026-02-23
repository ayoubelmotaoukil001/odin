<?php

namespace App\Events;

use App\Models\Link; 
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LinkCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Link
     */
    public $link; 

    /**
     * Create a new event instance.
     */
    public function __construct(Link $link)
    {
        $this->link = $link;
    }
}