<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->get();

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $grouped = [
            'today' => [],
            'yesterday' => [],
            'older' => [],
        ];

        foreach ($notifications as $notification) {
            $createdAt = $notification->created_at instanceof Carbon
                ? $notification->created_at
                : Carbon::parse($notification->created_at);

            if ($createdAt->isSameDay($today)) {
                $grouped['today'][] = $notification;
                continue;
            }

            if ($createdAt->isSameDay($yesterday)) {
                $grouped['yesterday'][] = $notification;
                continue;
            }

            $grouped['older'][] = $notification;
        }

        return view('surat-masuk.notifikasi', [
            'groupedNotifications' => $grouped,
        ]);
    }
}
