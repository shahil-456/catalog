<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class OrderStatusNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userID;
    public $type;
 

    public function __construct($message,$type = 'status-notify', $userID = null)
    {
        $this->message = $message;
        $this->userID = $userID;
        $this->type = $type;    
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('amer-leads.' . $this->userID);
    }

    public function broadcastAs()
    {
        return 'status-notify';
    }
}
