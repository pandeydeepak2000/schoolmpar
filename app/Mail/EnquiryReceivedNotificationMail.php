<?php

namespace App\Mail;

use App\Models\Enquiry;
use App\Models\School;
use App\Services\DynamicMailConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryReceivedNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Enquiry $enquiry,
        public School $school,
        public string $recipientRole = 'school_owner' // 'school_owner', 'admin', 'parent'
    ) {
        DynamicMailConfig::apply();
    }

    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address', 'support@schoolmapr.com');
        $fromName    = config('mail.from.name', 'SchoolMapr Support');

        $subject = match ($this->recipientRole) {
            'parent'       => 'Inquiry Confirmation: ' . $this->school->name,
            'admin'        => '[Admin Alert] New Parent Lead for ' . $this->school->name,
            default        => 'New Parent Inquiry Received for ' . $this->school->name,
        };

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
