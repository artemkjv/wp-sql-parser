<?php

namespace App\Events;

use App\Models\ParsingResult;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParsingCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithBroadcasting;

    /**
     * Create a new event instance.
     */
    public function __construct(
        private ParsingResult $parsingResult,
    )
    {
    }

    public function broadcastWith() {
        return [
            'resulting_files' => $this->parsingResult->resulting_files,
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'parsing.completed';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("App.Models.ParsingResult.{$this->parsingResult->uuid}"),
        ];
    }
}
