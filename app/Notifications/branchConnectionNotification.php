<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class branchConnectionNotification extends Notification
{
    use Queueable;

    protected $branch;
    protected $duration;
    protected $custData;
    protected $name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $custom ,$min, $userName)
    {
        $this->branch = $data;
        $this->duration = $min;
        $this->custData = $custom;
        $this->name = $userName;
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
            'branch_name' => $this->branch->name,
            'branch_code' => $this->branch->branch_code,
            'last_connected' => $this->custData['last_connected'],
            'status' => $this->custData['status'],
            'duration' => $this->duration,
            'message' => 'branch_connection_notification_message',
            'created_by' => $this->name,
            'come_from' => 'branch_connection',
        ];
    }
}
