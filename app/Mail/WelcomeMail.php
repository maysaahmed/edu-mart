<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use Mailtrap\EmailHeader\CategoryHeader;
use Mailtrap\EmailHeader\CustomVariableHeader;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Header\UnstructuredHeader;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $name;
    private string $link;

    /**
     * Create a new message instance.
     * @param string $name
     * @param string $link
     */
    public function __construct(string $name, string $link)
    {
        $this->name = $name;
        $this->link = $link;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('info@edumart.com', 'Edumart Admin'),
            subject: 'ًWelcome to Edumart',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.welcome-email',
            with: ['name' => $this->name, 'link' => $this->link],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath('https://mailtrap.io/wp-content/uploads/2021/04/mailtrap-new-logo.svg')
                ->as('logo.svg')
                ->withMime('image/svg+xml'),
        ];
    }

    /**
     * Get the message headers.
     */
    public function headers(): Headers
    {
        return new Headers(
            'custom-message-id@example.com',
            ['previous-message@example.com'],
            [
                'X-Custom-Header' => 'Custom Value',
            ],
        );
    }
}
