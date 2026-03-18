<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAgencyRegistrationNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly User $agency)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'New agency registration pending approval',
            'message' => sprintf('%s (%s) has registered and is waiting for approval.', $this->agency->name, $this->agency->email),
            'url' => route('admin.users.index'),
            'agency_user_id' => $this->agency->id,
        ];
    }
}
