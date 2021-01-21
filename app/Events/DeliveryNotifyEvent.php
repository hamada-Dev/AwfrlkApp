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

    public $orderId;
    public $userOrder;
    public $orderData;
    public $activeDelivery;

    public function __construct($message)
    {
        $this->orderId         = $message['order_id'];
        $this->userOrder       = $message['user_Order'];
        $this->orderData       = $message['order_Data'];
        $this->activeDelivery  = $message['active_Delivery'];
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
