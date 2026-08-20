<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class QueuedResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $token)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Réinitialisation du mot de passe')
            ->line('Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe.')
            ->action('Réinitialiser le mot de passe', $url)
            ->line('Si vous n\'avez pas demandé de réinitialisation, aucune action n\'est requise.');
    }
}