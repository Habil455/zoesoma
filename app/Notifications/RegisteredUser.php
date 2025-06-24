<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisteredUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $email_data;
    public function __construct(array $email_data)
    {
        //
        $this->arr=$email_data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $appName= env('APP_NAME', 'ZoeSoma Consultancy Limited');
        return (new MailMessage)
            ->subject('ZoeSoma User Credentials')
            // ->to($this->arr['email'])
            // ->to($this->arr['email'])
            // ->greeting('Dear ' . $this->arr['username'])
            ->greeting('Dear '. $this->arr['fname'] . ' ' . $this->arr['lname'])
            ->line('Your '.$appName.' Account login credentials are: ')
            ->line('Username: ' . $this->arr['username'])
            ->line('Password: ' . $this->arr['password'])
            ->line('You are advised not to share your password with anyone. If you don\'t know this activity or you received this email by accident, please report this incident to the system administrator')
            ->action('Login Link', url('/login'))
            ->line('Thank you')
            ->line('ZoeSoma Team');
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
