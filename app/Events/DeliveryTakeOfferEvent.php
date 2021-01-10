<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryTakeOfferEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
 

    public $userData;
    public $offerData;
    public $deliveryData;

    public function __construct($message)
    {
        $this->userData       = $message['user_data'];
        $this->offerData      = $message['offer_data'];
        $this->deliveryData   = $message['delivery_data'];
    }

    public function broadcastOn()
    {
        return ['my-channel-DTakeOffer'];
    }

    public function broadcastAs()
    {
        return 'my-event-DTakeOffer';
    }
}
