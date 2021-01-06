<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserUrgencyOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order_details;
    public $order_delivery;
    public $order_user;
    public $alert;
    public $order_id;

    public function __construct($message)
    {
        $this->order_details     = $message['order_details'];
        $this->order_delivery    = $message['delivery_order'];
        $this->order_user        = $message['client_order'];
        $this->alert             = $message['message'];
        $this->order_id          = $message['order_id'];
    }

    public function broadcastOn()
    {
        return ['channel-userUrgOrder'];
    }

    public function broadcastAs()
    {
        return 'event-userUrgOrder';
    }
}
