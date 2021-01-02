<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryNotifyEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $order_id;
    public $first_name;

    public function __construct($message)
    {
        $this->user_id    = $message['user_id'];
        $this->order_id   = $message['order_id'];
        $this->first_name = $message['firstName'];
    }

    public function broadcastOn()
    {
        return ['my-channel-order'];
    }

    public function broadcastAs()
    {
        return 'my-event-order';
    }
}
