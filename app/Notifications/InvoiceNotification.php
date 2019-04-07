<?php

namespace App\Notifications;

use App\Client;
use App\Invoice;
use App\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;

class InvoiceNotification extends Notification
{
    use Queueable;

    /**
     * @var Invoice
     */
    protected $invoice;

    /**
     * Create a new notification instance.
     *
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return MailMessage|void
     */
    public function toMail(Client $notifiable)
    {
        if(!Storage::disk('local')->exists("invoices/invoice-{$this->invoice->id}.xls")) return;

        $mail = new MailMessage;
        $mail->subject("Invoice - Kangaroo Delivery")
            ->markdown('notifications.mail', [
                'tmpl'     => 'invoice',
                'client'   => $notifiable,
                'invoice' => $this->invoice
            ])
            ->attach(storage_path("app/invoices/invoice-{$this->invoice->id}.xls"));

        if (count($notifiable->secondary_emails))
            $mail->cc($notifiable->secondary_emails);

        return $mail;

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
