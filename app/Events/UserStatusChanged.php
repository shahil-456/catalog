<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserStatusChanged implements ShouldBroadcast
{
    public $userId;
    public $online;

    public function __construct($userId, $online)
    {
        $this->userId = $userId;
        $this->online = $online;
    }

    public function broadcastOn()
    {
        return new Channel('online-users');
    }
    
}

