<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactFormNotification extends Notification
{
    use Queueable;

    public $contactMessage;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
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
        return (new MailMessage)
                    ->subject('Alguien te busca en Opemedios - Contacto')
                    ->from('no-reply@opemedios.com.mx', 'no-reply')
                    ->greeting('Detalles:')
                    ->line("Nombre: {$this->contactMessage->name}")
                    ->line("Email: {$this->contactMessage->email}")
                    ->line("Télefono: {$this->contactMessage->phone}")
                    ->line("Mensaje:")
                    ->line($this->contactMessage->message)
                    ->salutation(' ');
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
