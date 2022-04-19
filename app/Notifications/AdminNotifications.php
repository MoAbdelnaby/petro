<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotifications extends Notification
{
    use Queueable;

    protected $notificationData;
    protected $name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data,$userNane)
    {
        $this->notificationData = $data;
        $this->name = $userNane;
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
            'user_name' => $this->notificationData['name'],
            'user_phone' => $this->notificationData['phone'],
            'user_type' => $this->notificationData['type'],
            'created_by' => $this->name,
            'message' => 'add_user_notification_message',
            'come_from' => 'user_model',
        ];
    }
}
