<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminStatusChanged implements ShouldBroadcast
{
    public $adminId;
    public $online;

    public function __construct($adminId, $online)
    {
        $this->adminId = $adminId;
        $this->online = $online;
    }

    public function broadcastOn()
    {
        return new Channel('online-admins');
    }
    
}

