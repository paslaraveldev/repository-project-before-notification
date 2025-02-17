<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ProposalReviewed extends Notification
{
     use Queueable;

    protected $proposal;
    protected $comment;
    protected $status;

    public function __construct($proposal, $comment, $status)
    {
        $this->proposal = $proposal;
        $this->comment = $comment;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your proposal has been reviewed by your supervisor.',
            'proposal_id' => $this->proposal->id,
            'reviewed_by' => $this->proposal->reviewed_by,
            'comment' => $this->comment->comment,
            'status' => $this->status,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'Your proposal has been reviewed by your supervisor.',
            'proposal_id' => $this->proposal->id,
            'reviewed_by' => $this->proposal->reviewed_by,
            'comment' => $this->comment->comment,
            'status' => $this->status,
        ]);
    }
}
