<?php

namespace App\Mail;

use App\Models\User;
use App\Services\DynamicMailConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeParentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
        DynamicMailConfig::apply();
    }

    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address', 'support@schoolmapr.com');
        $fromName    = config('mail.from.name', 'SchoolMapr Support');

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: 'Welcome to SchoolMapr – Your Gateway to Top Schools in Patna 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome-parent',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
