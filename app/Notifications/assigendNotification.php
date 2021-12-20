<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class assigendNotification extends Notification
{
    use Queueable;

    protected $branches;
    protected $assignerName;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $name)
    {
        $this->branches = $data;
        $this->assignerName = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'created_by' => $this->assignerName,
            'branches' => $this->branches,
            'message' => 'assign_notification_message',
            'come_from' => 'user_assign',
        ];
    }
}
