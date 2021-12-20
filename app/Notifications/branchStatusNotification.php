<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class branchStatusNotification extends Notification
{
    use Queueable;

    protected $branch;
    protected $name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $userName)
    {
        $this->branch = $data;
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
            'branch_name' => $this->branch['branch_name'],
            'branch_code' => $this->branch['branch_code'],
            'created_at' => $this->branch['created_at'],
            'created_by' => $this->name,
            'message' => 'branch_from_api_notification_message',
            'come_from' => 'status_of_branch',
        ];
    }
}
