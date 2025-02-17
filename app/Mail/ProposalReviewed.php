<?php

namespace App\Mail;

use App\Models\Proposal;
use App\Models\ProposalComment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalReviewed extends Mailable
{
    use Queueable, SerializesModels;

    public $proposal;
    public $comment;
    public $status;

    /**
     * Create a new message instance.
     *
     * @param Proposal $proposal
     * @param ProposalComment $comment
     * @param string $status
     */
    public function __construct(Proposal $proposal, ProposalComment $comment, string $status)
    {
        $this->proposal = $proposal;
        $this->comment = $comment;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Proposal Review Update')
                    ->view('emails.proposal_reviewed');
    }
}
