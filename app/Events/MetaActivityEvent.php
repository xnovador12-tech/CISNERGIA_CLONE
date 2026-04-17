<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MetaActivityEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $change;

    /**
     * Create a new event instance.
     */
    public function __construct(array $change)
    {
        $this->change = $change;
        Log::info("MetaActivityEvent: Nuevo evento preparado para broadcast.", ['change' => $change]);
    }

    /**
     * Get the channels the event should broadcast on.
     * Este nombre ('meta-activity') debe coincidir EXACTAMENTE con el de tu JavaScript en el Blade.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('meta-activity');
    }

    /**
     * El nombre del evento que escuchará JavaScript.
     */
    public function broadcastAs(): string
    {
        return 'App\\Events\\MetaActivityEvent';
    }
}