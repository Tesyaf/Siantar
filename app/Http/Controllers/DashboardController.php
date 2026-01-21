<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $incomingTotal = IncomingLetter::count();

        $outgoingTotal = OutgoingLetter::count();

        $incomingStats = [
            ['icon' => 'bi-envelope-fill', 'label' => 'Total Surat Masuk', 'value' => $incomingTotal, 'rowClass' => 'bg-blue-50', 'iconClass' => 'text-blue-600', 'valueClass' => 'text-blue-600'],
        ];

        $outgoingStats = [
            ['icon' => 'bi-reply-fill', 'label' => 'Total Surat Keluar', 'value' => $outgoingTotal, 'rowClass' => 'bg-green-50', 'iconClass' => 'text-green-500', 'valueClass' => 'text-green-600', 'rotate' => true],
        ];

        $activities = $this->buildActivities();
        $latestLetters = $this->buildLatestLetters();

        return view('dashboard', compact('incomingStats', 'outgoingStats', 'activities', 'latestLetters'));
    }

    private function buildActivities(): Collection
    {
        $incoming = IncomingLetter::latest()->take(6)->get()->map(function ($letter) {
            return [
                'icon' => 'bi-inbox-fill',
                'title' => 'Surat masuk: ' . $letter->subject,
                'time' => optional($letter->created_at)->diffForHumans(),
                'type' => 'incoming',
                'created_at' => $letter->created_at,
            ];
        });

        $outgoing = OutgoingLetter::latest()->take(6)->get()->map(function ($letter) {
            return [
                'icon' => 'bi-send-fill',
                'title' => 'Surat keluar: ' . $letter->subject,
                'time' => optional($letter->created_at)->diffForHumans(),
                'type' => 'outgoing',
                'created_at' => $letter->created_at,
            ];
        });

        return $incoming
            ->merge($outgoing)
            ->sortByDesc('created_at')
            ->take(3)
            ->map(function ($activity) {
                $iconClass = $activity['type'] === 'incoming'
                    ? 'bg-blue-50 text-blue-600'
                    : 'bg-green-50 text-green-600';

                return array_merge($activity, [
                    'iconClass' => $iconClass,
                ]);
            })
            ->values();
    }

    private function buildLatestLetters(): Collection
    {
        $incoming = IncomingLetter::latest('letter_date')->take(5)->get()->map(function ($letter) {
            return [
                'id' => $letter->id,
                'no' => $letter->letter_number,
                'date' => optional($letter->letter_date)->format('d M Y'),
                'subject' => $letter->subject,
                'type' => 'Masuk',
                'link' => route('detail-surat-masuk', $letter),
                'date_sort' => $letter->letter_date ?? $letter->created_at,
            ];
        });

        $outgoing = OutgoingLetter::latest('letter_date')->take(5)->get()->map(function ($letter) {
            return [
                'id' => $letter->id,
                'no' => $letter->letter_number,
                'date' => optional($letter->letter_date)->format('d M Y'),
                'subject' => $letter->subject,
                'type' => 'Keluar',
                'link' => route('detail-surat-keluar', $letter),
                'date_sort' => $letter->letter_date ?? $letter->created_at,
            ];
        });

        return $incoming
            ->merge($outgoing)
            ->sortByDesc('date_sort')
            ->take(5)
            ->map(function ($letter) {
                $typeStyles = $letter['type'] === 'Masuk'
                    ? 'bg-blue-50 text-blue-600'
                    : 'bg-green-50 text-green-600';

                return array_merge($letter, [
                    'typeClass' => $typeStyles,
                ]);
            })
            ->values();
    }
}
