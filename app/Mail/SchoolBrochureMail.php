<?php

namespace App\Mail;

use App\Models\School;
use App\Services\DynamicMailConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SchoolBrochureMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public School $school,
        public string $parentName,
        public ?string $customMessage = null,
        public ?string $uploadedFilePath = null,
        public ?string $uploadedFileName = null
    ) {
        DynamicMailConfig::apply();
    }

    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address', 'support@schoolmapr.com');
        $fromName    = $this->school->name . ' via SchoolMapr';

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: "📄 Official Admission Brochure & Fee Structure – {$this->school->name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.school-brochure',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        // 1. If a custom brochure file was uploaded specifically for this email
        if ($this->uploadedFilePath && file_exists($this->uploadedFilePath)) {
            $fileName = $this->uploadedFileName ?: (\Illuminate\Support\Str::slug($this->school->name) . '-admission-brochure.pdf');
            $mimeType = mime_content_type($this->uploadedFilePath) ?: 'application/pdf';

            $attachments[] = Attachment::fromPath($this->uploadedFilePath)
                ->as($fileName)
                ->withMime($mimeType);
        }
        // 2. Else if school's saved prospectus file exists
        elseif ($this->school->prospectus_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->school->prospectus_path)) {
            $filePath = storage_path('app/public/' . $this->school->prospectus_path);
            if (file_exists($filePath)) {
                $attachments[] = Attachment::fromPath($filePath)
                    ->as(\Illuminate\Support\Str::slug($this->school->name) . '-admission-brochure.pdf')
                    ->withMime('application/pdf');
            }
        }

        return $attachments;
    }
}
