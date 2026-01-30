<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RestockAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $lowStockItems;

    public function __construct(array $lowStockItems)
    {
        $this->lowStockItems = $lowStockItems;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Peringatan Stok Menipis - Fiwrin Fashion',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.restock-alert',
        );
    }
}