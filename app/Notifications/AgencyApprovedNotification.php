<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AgencyApprovedNotification extends Notification
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Profile approved',
            'message' => 'Your agency profile has been approved by admin. You can now access the portal.',
            'url' => route('login'),
        ];
    }
}
