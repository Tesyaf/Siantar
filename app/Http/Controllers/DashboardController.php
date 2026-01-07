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
        $incomingPending = IncomingLetter::whereIn('status', ['Baru', 'Menunggu'])->count();
        $incomingProcessed = IncomingLetter::whereIn('status', ['Diproses', 'Selesai'])->count();

        $outgoingTotal = OutgoingLetter::count();
        $outgoingPending = OutgoingLetter::where('status', 'Menunggu')->count();
        $outgoingSent = OutgoingLetter::whereIn('status', ['Terkirim', 'Selesai'])->count();

        $incomingStats = [
            ['icon' => 'bi-envelope-fill', 'label' => 'Total Surat Masuk', 'value' => $incomingTotal, 'rowClass' => 'bg-blue-50', 'iconClass' => 'text-blue-600', 'valueClass' => 'text-blue-600'],
            ['icon' => 'bi-exclamation-circle-fill', 'label' => 'Belum Diproses', 'value' => $incomingPending, 'rowClass' => 'bg-red-50', 'iconClass' => 'text-red-500', 'valueClass' => 'text-red-600'],
            ['icon' => 'bi-check-circle-fill', 'label' => 'Sudah Diproses', 'value' => $incomingProcessed, 'rowClass' => 'bg-green-50', 'iconClass' => 'text-green-500', 'valueClass' => 'text-green-600'],
        ];

        $outgoingStats = [
            ['icon' => 'bi-reply-fill', 'label' => 'Total Surat Keluar', 'value' => $outgoingTotal, 'rowClass' => 'bg-green-50', 'iconClass' => 'text-green-500', 'valueClass' => 'text-green-600', 'rotate' => true],
            ['icon' => 'bi-clock-fill', 'label' => 'Menunggu Persetujuan', 'value' => $outgoingPending, 'rowClass' => 'bg-yellow-50', 'iconClass' => 'text-yellow-500', 'valueClass' => 'text-yellow-600'],
            ['icon' => 'bi-check2-all', 'label' => 'Sudah Dikirim', 'value' => $outgoingSent, 'rowClass' => 'bg-blue-50', 'iconClass' => 'text-blue-600', 'valueClass' => 'text-blue-600'],
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
                'status' => $letter->status ?? 'Baru',
                'type' => 'incoming',
                'created_at' => $letter->created_at,
            ];
        });

        $outgoing = OutgoingLetter::latest()->take(6)->get()->map(function ($letter) {
            return [
                'icon' => 'bi-send-fill',
                'title' => 'Surat keluar: ' . $letter->subject,
                'time' => optional($letter->created_at)->diffForHumans(),
                'status' => $letter->status ?? 'Menunggu',
                'type' => 'outgoing',
                'created_at' => $letter->created_at,
            ];
        });

        return $incoming
            ->merge($outgoing)
            ->sortByDesc('created_at')
            ->take(3)
            ->map(function ($activity) {
                $styles = $this->statusActivityStyles($activity['status']);
                return array_merge($activity, $styles);
            })
            ->values();
    }

    private function buildLatestLetters(): Collection
    {
        $incoming = IncomingLetter::latest('letter_date')->take(5)->get()->map(function ($letter) {
            return [
                'no' => $letter->letter_number,
                'date' => optional($letter->letter_date)->format('d M Y'),
                'subject' => $letter->subject,
                'type' => 'Masuk',
                'status' => $letter->status ?? 'Baru',
                'link' => route('detail-surat-masuk', $letter),
                'date_sort' => $letter->letter_date ?? $letter->created_at,
            ];
        });

        $outgoing = OutgoingLetter::latest('letter_date')->take(5)->get()->map(function ($letter) {
            return [
                'no' => $letter->letter_number,
                'date' => optional($letter->letter_date)->format('d M Y'),
                'subject' => $letter->subject,
                'type' => 'Keluar',
                'status' => $letter->status ?? 'Menunggu',
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

                $statusStyles = $this->statusPillStyles($letter['status']);

                return array_merge($letter, [
                    'typeClass' => $typeStyles,
                    'statusClass' => $statusStyles,
                ]);
            })
            ->values();
    }

    private function statusPillStyles(string $status): string
    {
        return match ($status) {
            'Baru' => 'bg-blue-50 text-blue-600 border-blue-200',
            'Menunggu' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
            'Diproses' => 'bg-orange-50 text-orange-600 border-orange-200',
            'Terkirim' => 'bg-green-50 text-green-600 border-green-200',
            'Selesai' => 'bg-green-50 text-green-600 border-green-200',
            default => 'bg-gray-100 text-gray-600 border-gray-200',
        };
    }

    private function statusActivityStyles(string $status): array
    {
        return match ($status) {
            'Baru' => ['pillClass' => 'bg-blue-50 text-blue-600 border-blue-200', 'iconClass' => 'bg-blue-50 text-blue-600'],
            'Menunggu' => ['pillClass' => 'bg-yellow-50 text-yellow-700 border-yellow-200', 'iconClass' => 'bg-yellow-50 text-yellow-600'],
            'Diproses' => ['pillClass' => 'bg-orange-50 text-orange-600 border-orange-200', 'iconClass' => 'bg-orange-50 text-orange-600'],
            'Terkirim', 'Selesai' => ['pillClass' => 'bg-green-50 text-green-600 border-green-200', 'iconClass' => 'bg-green-50 text-green-600'],
            default => ['pillClass' => 'bg-gray-100 text-gray-600 border-gray-200', 'iconClass' => 'bg-gray-100 text-gray-600'],
        };
    }
}
