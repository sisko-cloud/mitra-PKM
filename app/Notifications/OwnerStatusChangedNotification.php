<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OwnerStatusChangedNotification extends Notification
{
    use Queueable;

    public string $status;
    public ?string $reason;

    public function __construct(string $status, ?string $reason = null)
    {
        $this->status = $status;
        $this->reason = $reason;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        if ($this->status === 'approved') {
            return (new MailMessage)
                ->subject('Selamat! Pendaftaran Mitra PKM Anda Telah Disetujui')
                ->greeting('Halo, ' . $notifiable->name . '!')
                ->line('Kabar gembira! Akun usaha Anda telah diverifikasi dan disetujui oleh Superadmin Mitra PKM.')
                ->line('Template website promosi Anda telah dibuat secara otomatis dan siap untuk diedit serta dipublikasikan.')
                ->action('Buka Dashboard Mitra', route('owner.dashboard'))
                ->line('Terima kasih telah bergabung bersama ekosistem Mitra PKM.');
        }

        if ($this->status === 'rejected') {
            return (new MailMessage)
                ->subject('Pemberitahuan Status Pendaftaran Mitra PKM')
                ->greeting('Halo, ' . $notifiable->name . '.')
                ->line('Mohon maaf, pendaftaran usaha Anda belum dapat disetujui karena:')
                ->line('"' . ($this->reason ?? 'Data pendaftaran belum memenuhi persyaratan.') . '"')
                ->action('Perbaiki Data & Ajukan Ulang', route('owner.status'))
                ->line('Anda dapat memperbaiki data yang diperlukan dan mengajukan ulang verifikasi kapan saja.');
        }

        return (new MailMessage)
            ->subject('Pembaruan Status Akun Mitra PKM')
            ->line('Status akun Anda telah diperbarui menjadi: ' . ucfirst($this->status));
    }

    public function toArray(object $notifiable): array
    {
        $message = match ($this->status) {
            'approved' => 'Pendaftaran Anda telah disetujui! Website promosi Anda siap dikelola.',
            'rejected' => 'Pendaftaran Anda ditolak: ' . ($this->reason ?? 'Silakan tinjau kembali data pendaftaran Anda.'),
            'suspended' => 'Akun usaha Anda telah dinonaktifkan sementara oleh administrator.',
            default => 'Status akun Anda diperbarui: ' . $this->status,
        };

        return [
            'status' => $this->status,
            'reason' => $this->reason,
            'message' => $message,
            'url' => $this->status === 'approved' ? route('owner.dashboard') : route('owner.status'),
        ];
    }
}
