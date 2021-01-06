<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderHasBeenAcceptEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order_details;
    public $order_delivery;
    public $order_user;

    public function __construct($message)
    {
        $this->order_details  = $message['my_order_detail'];
        $this->order_delivery = $message['accepted_delivery'];
        $this->order_user     = $message['user_order'];
    }

    public function broadcastOn()
    {
        return ['channel-orderClient-acc'];
    }

    public function broadcastAs()
    {
        return 'event-orderClient-acc';
    }
}
