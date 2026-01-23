<?php

namespace App\Notifications;

use App\Models\OutgoingLetter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OutgoingLetterCreated extends Notification
{
    use Queueable;

    public function __construct(
        protected OutgoingLetter $outgoingLetter
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'outgoing_letter',
            'icon' => 'send',
            'title' => 'Surat Keluar Baru',
            'message' => sprintf(
                'Surat untuk %s perihal "%s" telah dibuat.',
                $this->outgoingLetter->recipient,
                $this->outgoingLetter->subject
            ),
            'url' => route('detail-surat-keluar', $this->outgoingLetter),
        ];
    }
}
