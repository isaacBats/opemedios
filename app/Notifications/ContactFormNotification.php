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
        $serviceLabels = [
            'monitoreo'  => 'Monitoreo de Medios',
            'redes'      => 'Redes Sociales',
            'reputacion' => 'Gestión de Reputación',
            'reportes'   => 'Reportes Personalizados',
        ];

        $mail = (new MailMessage)
            ->subject('Nuevo Lead - Formulario de Contacto Opemedios')
            ->from('no-reply@opemedios.com.mx', 'Opemedios')
            ->greeting('¡Nuevo contacto recibido!')
            ->line("**Nombre:** {$this->contactMessage->name}");

        if ($this->contactMessage->company) {
            $mail->line("**Empresa:** {$this->contactMessage->company}");
        }

        $mail->line("**Email:** {$this->contactMessage->email}");

        if ($this->contactMessage->phone) {
            $mail->line("**Teléfono:** {$this->contactMessage->phone}");
        }

        if ($this->contactMessage->service_interest) {
            $serviceLabel = $serviceLabels[$this->contactMessage->service_interest] ?? $this->contactMessage->service_interest;
            $mail->line("**Servicio de Interés:** {$serviceLabel}");
        }

        if ($this->contactMessage->message) {
            $mail->line('---')
                 ->line('**Mensaje:**')
                 ->line($this->contactMessage->message);
        }

        $mail->line('---')
             ->line('Este mensaje fue enviado desde el formulario de contacto de opemedios.com.mx')
             ->salutation('— Opemedios');

        return $mail;
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
