<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HierarchyChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $hierarchy;
    public $table;
    public $modelId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($hierarchy, $table, $modelId = null)
    {
        $this->hierarchy = $hierarchy;
        $this->table = $table;
        $this->modelId = $modelId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
