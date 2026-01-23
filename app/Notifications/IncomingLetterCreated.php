<?php

namespace App\Notifications;

use App\Models\IncomingLetter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class IncomingLetterCreated extends Notification
{
    use Queueable;

    public function __construct(
        protected IncomingLetter $incomingLetter
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'incoming_letter',
            'icon' => 'mail',
            'title' => 'Surat Masuk Baru',
            'message' => sprintf(
                'Surat dari %s perihal "%s" telah diterima.',
                $this->incomingLetter->sender,
                $this->incomingLetter->subject
            ),
            'url' => route('detail-surat-masuk', $this->incomingLetter),
        ];
    }
}
