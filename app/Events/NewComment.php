<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Comment;

class NewComment implements ShouldBroadcastNow // ShouldBroadcastNow => no queue (NOT recommended for production)
{ // ShouldBroadcast => queue (recommended for production)
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $post_id = $this->comment->post->id;
        return new Channel('post.'.$post_id);
    }
    
    /**
     * By default, Laravel will broadcast the event using the event's class name.
     * However, you may customize the broadcast name
     * by defining a broadcastAs method on the event: 
     * @return string
     */
//    public function broadcastAs() {
//        return 'NewComment';
//    }
    
    public function broadcastWith() {
        return [
            'body' => $this->comment->body,
            'created_at' => $this->comment->created_at->toFormattedDateString(),
            'user' => [
                'id' => $this->comment->user->id,
                'name' => $this->comment->user->name,
                'avatar' => 'http://placeimg.com/50/50/people'
            ]
        ];
    }
}
