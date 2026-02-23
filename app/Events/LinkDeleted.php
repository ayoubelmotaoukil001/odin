<?php

namespace App\Events;

use App\Models\Link;
use Illuminate\Queue\SerializesModels;

class LinkDeleted
{
    use SerializesModels;

    
    public $link; 

    public function __construct(Link $link)
    {
        $this->link = $link;
    }
}