<?php

namespace App\Modules\Core\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataTableFormEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public $oldRecord;
     public $newRecord;
     public $eventName;

    /**
     * Create a new event instance.
     *
     * @param array $oldRecord
     * @param array $newRecord
     */
    public function __construct($eventName, $oldRecord, $newRecord)
    {
        $this->oldRecord = $oldRecord;
        $this->newRecord = $newRecord;
        $this->eventName = $eventName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}