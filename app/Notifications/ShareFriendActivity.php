<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ShareFriendActivity extends Notification implements ShouldQueue
{
    use Queueable;
    public $user;
    public $friend;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $friend)
    {
        $this->user = $user;
        $this->friend = $friend;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
    public function toArray($notifiable)
    {
        return [
            'name'          =>  $this->user->name,
            'message'       =>  ' became friends with ',
            'friend_name'   =>  $this->friend->name,
            'avatar'        =>  $this->user->avatar,
            'f_avatar'      =>  $this->friend->avatar
        ];
    }
}
