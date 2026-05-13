<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminActionNotification extends Notification
{
    use Queueable;

    public $details;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->details = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable)
    {
        return match ($this->details['action']) {
            'updateRole' => [
                'action' => 'Update Role',
                'message' => "{$this->details['admin_name']} telah merubah role {$this->details['target_name']} dari {$this->details['old_role']} ke {$this->details['new_role']}",
            ],
            'destroyUser' => [
                'action' => 'Destroy User',
                'message' => "{$this->details['admin_name']} telah menghapus akun {$this->details['target_name']} dengan role {$this->details['role']}",
            ],
            default => [
                'message' => 'aksi tidak dikenal'
            ],
        };
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
