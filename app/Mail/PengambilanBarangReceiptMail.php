<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PengambilanBarangReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Data resi bukti pengambilan barang.
     *
     * @var array
     */
    public array $receipt;

    /**
     * Create a new message instance.
     */
    public function __construct(array $receipt)
    {
        $this->receipt = $receipt;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $recipientName = $this->receipt['nama_pengambil'] ?? ($this->receipt['recipient'] ?? 'Pengambil');
        $divisi = !empty($this->receipt['divisi']) ? " ({$this->receipt['divisi']})" : '';
        $subject = "Bukti Resi Pengambilan Barang - {$recipientName}{$divisi}";

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.receipt_pengambilan',
            with: [
                'receipt' => $this->receipt,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
