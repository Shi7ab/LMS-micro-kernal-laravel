<?php
// app/Events/LiveNotificationEvent.php  

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LiveNotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $message;
    public $data;


    public function __construct(string $userId, string $message, array $data = [])
    {
        $this->userId = $userId;
        $this->message = $message;
        $this->data = $data;
    }


    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->userId)
        ];
    }


    public function broadcastAs(): string
    {
        return 'notification.received';
    }
}
