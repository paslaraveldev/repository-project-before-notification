<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupervisorAssigned extends Notification
{
     use Queueable;

    protected $supervisorName;
    protected $groupName;

    public function __construct($supervisorName, $groupName)
    {
        $this->supervisorName = $supervisorName;
        $this->groupName = $groupName;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Sends via email and saves in the database
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Supervisor Assigned')
                    ->line("You have been assigned a new supervisor: **{$this->supervisorName}** for the group **{$this->groupName}**.")
                    ->action('View Group', url('/groups'))
                    ->line('Please contact your supervisor if needed.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "You have been assigned a new supervisor: {$this->supervisorName} for the group {$this->groupName}.",
            'supervisor' => $this->supervisorName
        ];
    }
}
