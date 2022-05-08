<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BranchStatusNotification extends Notification
{
    use Queueable;

    protected $branch;
    protected $escalation_branch_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($branch, $escalation_branch_id)
    {
        $this->branch = $branch;
        $this->escalation_branch_id = $escalation_branch_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toDatabase(): array
    {
        return [
            'branch_name' => $this->branch->name,
            'branch_code' => $this->branch->branch_code,
            'created_by' => 'System',
            'message' => 'branch_from_api_notification_message',
            'come_from' => 'status_of_branch',
            'escalation_branch_id' => $this->escalation_branch_id
        ];
    }
}
