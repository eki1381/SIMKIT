<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;
use Carbon\Carbon;

class AssignmentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $recipients = User::select('reg_token')
                        ->where('id', $notifiable->user_to_id)
                        ->value('reg_token');

        return fcm()
            ->to([$recipients])
            ->priority('high')
            ->timeToLive(10)
            ->notification([
                'title' => 'Pesan Pengingat',
                'body' => $notifiable->name.' besok deadline',
                'icon' => 'https://simkit.bpsanambas.com/logo.png',
            ])
            ->send();
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
            //
        ];
    }
}
