<?php

namespace TuaWebsite\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use TuaWebsite\Domain\Identity\User;

/**
 * Welcome Notification
 *
 * @package TuaWebsite\Notifications
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 */
class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    private $password;

    /**
     * Create a new notification instance
     *
     * @param string $password
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  User $user
     * @return array
     */
    public function via(User $user)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  User $user
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $user)
    {
        return (new MailMessage)
            ->subject('Welcome to Teesside University Archers')
            ->greeting('Hi ' . $user->first_name)
            ->line('Welcome to Teesside University Archers! You can now log in with the details below.')
            ->line('Email: ' . $user->email)
            ->line('Password: ' . $this->password)
            ->action('Login', url('/'));
    }
}
