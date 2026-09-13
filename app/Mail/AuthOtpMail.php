<?php

namespace App\Mail;

use App\Services\DynamicMailConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AuthOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public string $email,
        public ?string $name = null,
        public string $purpose = 'Registration'
    ) {
        DynamicMailConfig::apply();
    }

    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address', 'support@schoolmapr.com');
        $fromName    = config('mail.from.name', 'SchoolMapr Support');

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: "Your SchoolMapr Verification Code is: {$this->otp} 🔐",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.auth-otp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
