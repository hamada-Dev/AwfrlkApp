<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryArrivalOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order_details;
    public $order_delivery;
    public $order_user;
    public $order_total_price;

    public function __construct($message)
    {
        $this->order_details     = $message['order_detail'];
        $this->order_delivery    = $message['delivery_data'];
        $this->order_user        = $message['user_data'];
        $this->order_total_price = $message['order_details_total_price'];
    }

    public function broadcastOn()
    {
        return ['channel-delArrivalOrder'];
    }

    public function broadcastAs()
    {
        return 'event-delArrivalOrder';
    }
}
