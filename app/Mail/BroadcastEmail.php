<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BroadcastEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
//    protected $subject;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
//    protected $attachments;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $body
     * @param array $attachments
     */
    public function __construct(string $subject, string $body, array $attachments = [])
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->attachments = $attachments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject($this->subject)
            ->markdown('notifications.broadcast-email', [
                'html' => $this->body
            ]);
        if(count($this->attachments) > 0) {
            foreach ($this->attachments as $attachment) {
                $mail->attach($attachment);
            }
        }
        return $mail;
    }
}
