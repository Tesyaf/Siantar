<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use iio\libmergepdf\Merger;
use iio\libmergepdf\Driver\TcpdiDriver;

class ReportController extends Controller
{
    public function index()
    {
        $currentYear = now()->year;
        $years = range($currentYear, $currentYear - 5);

        return view('laporan.index', compact('years'));
    }

    public function monthly(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $year = (int) substr($month, 0, 4);
        $monthNum = (int) substr($month, 5, 2);

        $monthName = \Carbon\Carbon::createFromDate($year, $monthNum, 1)->translatedFormat('F Y');

        // Data surat masuk per hari
        $incomingByDay = IncomingLetter::query()
            ->whereYear('received_date', $year)
            ->whereMonth('received_date', $monthNum)
            ->select(DB::raw('DAY(received_date) as day'), DB::raw('COUNT(*) as total'))
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day')
            ->toArray();

        // Data surat keluar per hari
        $outgoingByDay = OutgoingLetter::query()
            ->whereYear('letter_date', $year)
            ->whereMonth('letter_date', $monthNum)
            ->select(DB::raw('DAY(letter_date) as day'), DB::raw('COUNT(*) as total'))
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day')
            ->toArray();

        // Statistik surat masuk
        $incomingStats = [
            'total' => IncomingLetter::whereYear('received_date', $year)->whereMonth('received_date', $monthNum)->count(),
        ];

        // Statistik surat keluar
        $outgoingStats = [
            'total' => OutgoingLetter::whereYear('letter_date', $year)->whereMonth('letter_date', $monthNum)->count(),
        ];

        // Surat masuk per kategori
        $incomingByCategory = IncomingLetter::query()
            ->whereYear('received_date', $year)
            ->whereMonth('received_date', $monthNum)
            ->select('category', DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        // Surat keluar per kategori
        $outgoingByCategory = OutgoingLetter::query()
            ->whereYear('letter_date', $year)
            ->whereMonth('letter_date', $monthNum)
            ->select('category', DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        // Daftar surat masuk terbaru
        $recentIncoming = IncomingLetter::query()
            ->whereYear('received_date', $year)
            ->whereMonth('received_date', $monthNum)
            ->latest('received_date')
            ->take(10)
            ->get();

        // Daftar surat keluar terbaru
        $recentOutgoing = OutgoingLetter::query()
            ->whereYear('letter_date', $year)
            ->whereMonth('letter_date', $monthNum)
            ->latest('letter_date')
            ->take(10)
            ->get();

        $daysInMonth = \Carbon\Carbon::createFromDate($year, $monthNum, 1)->daysInMonth;

        return view('laporan.bulanan', compact(
            'month',
            'monthName',
            'incomingByDay',
            'outgoingByDay',
            'incomingStats',
            'outgoingStats',
            'incomingByCategory',
            'outgoingByCategory',
            'recentIncoming',
            'recentOutgoing',
            'daysInMonth'
        ));
    }

    public function yearly(Request $request)
    {
        $year = $request->input('year', now()->year);

        // Data surat masuk per bulan
        $incomingByMonth = IncomingLetter::query()
            ->whereYear('received_date', $year)
            ->select(DB::raw('MONTH(received_date) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Data surat keluar per bulan
        $outgoingByMonth = OutgoingLetter::query()
            ->whereYear('letter_date', $year)
            ->select(DB::raw('MONTH(letter_date) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Statistik surat masuk
        $incomingStats = [
            'total' => IncomingLetter::whereYear('received_date', $year)->count(),
        ];

        // Statistik surat keluar
        $outgoingStats = [
            'total' => OutgoingLetter::whereYear('letter_date', $year)->count(),
        ];

        // Surat masuk per kategori
        $incomingByCategory = IncomingLetter::query()
            ->whereYear('received_date', $year)
            ->select('category', DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        // Surat keluar per kategori
        $outgoingByCategory = OutgoingLetter::query()
            ->whereYear('letter_date', $year)
            ->select('category', DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        // Perbandingan dengan tahun sebelumnya
        $prevYear = $year - 1;
        $lastYearIncoming = IncomingLetter::whereYear('received_date', $prevYear)->count();
        $lastYearOutgoing = OutgoingLetter::whereYear('letter_date', $prevYear)->count();

        $comparison = [
            'lastYearIncoming' => $lastYearIncoming,
            'lastYearOutgoing' => $lastYearOutgoing,
            'incomingDiff' => $lastYearIncoming > 0 ? round((($incomingStats['total'] - $lastYearIncoming) / $lastYearIncoming) * 100) : 0,
            'outgoingDiff' => $lastYearOutgoing > 0 ? round((($outgoingStats['total'] - $lastYearOutgoing) / $lastYearOutgoing) * 100) : 0,
        ];

        $years = range(now()->year, now()->year - 5);

        return view('laporan.tahunan', compact(
            'year',
            'years',
            'incomingByMonth',
            'outgoingByMonth',
            'incomingStats',
            'outgoingStats',
            'incomingByCategory',
            'outgoingByCategory',
            'comparison'
        ));
    }

    public function print(Request $request)
    {
        $type = $request->input('type', 'monthly');

        if ($type === 'monthly') {
            $month = $request->input('month', now()->format('Y-m'));
            $year = (int) substr($month, 0, 4);
            $monthNum = (int) substr($month, 5, 2);
            $monthName = \Carbon\Carbon::createFromDate($year, $monthNum, 1)->translatedFormat('F Y');

            $allIncoming = IncomingLetter::query()
                ->whereYear('received_date', $year)
                ->whereMonth('received_date', $monthNum)
                ->orderBy('received_date')
                ->get();

            $allOutgoing = OutgoingLetter::query()
                ->whereYear('letter_date', $year)
                ->whereMonth('letter_date', $monthNum)
                ->orderBy('letter_date')
                ->get();

            // Statistik surat masuk
            $incomingStats = [
                'total' => $allIncoming->count(),
            ];

            // Statistik surat keluar
            $outgoingStats = [
                'total' => $allOutgoing->count(),
            ];

            // Kategori
            $incomingByCategory = $allIncoming->groupBy('category')->map->count()->toArray();
            $outgoingByCategory = $allOutgoing->groupBy('category')->map->count()->toArray();

            return view('laporan.print-bulanan', compact(
                'monthName',
                'allIncoming',
                'allOutgoing',
                'incomingStats',
                'outgoingStats',
                'incomingByCategory',
                'outgoingByCategory'
            ));
        } else {
            $year = (int) $request->input('year', now()->year);

            $allIncoming = IncomingLetter::query()
                ->whereYear('received_date', $year)
                ->orderBy('received_date')
                ->get();

            $allOutgoing = OutgoingLetter::query()
                ->whereYear('letter_date', $year)
                ->orderBy('letter_date')
                ->get();

            // Statistik surat masuk
            $incomingStats = [
                'total' => $allIncoming->count(),
            ];

            // Statistik surat keluar
            $outgoingStats = [
                'total' => $allOutgoing->count(),
            ];

            // Kategori
            $incomingByCategory = $allIncoming->groupBy('category')->map->count()->toArray();
            $outgoingByCategory = $allOutgoing->groupBy('category')->map->count()->toArray();

            // Per bulan
            $incomingByMonth = $allIncoming->groupBy(fn($letter) => $letter->received_date->month)->map->count()->toArray();
            $outgoingByMonth = $allOutgoing->groupBy(fn($letter) => $letter->letter_date->month)->map->count()->toArray();

            // Perbandingan dengan tahun sebelumnya
            $prevYear = $year - 1;
            $lastYearIncoming = IncomingLetter::whereYear('received_date', $prevYear)->count();
            $lastYearOutgoing = OutgoingLetter::whereYear('letter_date', $prevYear)->count();

            $comparison = [
                'lastYearIncoming' => $lastYearIncoming,
                'lastYearOutgoing' => $lastYearOutgoing,
                'incomingDiff' => $lastYearIncoming > 0 ? round((($incomingStats['total'] - $lastYearIncoming) / $lastYearIncoming) * 100) : 0,
                'outgoingDiff' => $lastYearOutgoing > 0 ? round((($outgoingStats['total'] - $lastYearOutgoing) / $lastYearOutgoing) * 100) : 0,
            ];

            return view('laporan.print-tahunan', compact(
                'year',
                'allIncoming',
                'allOutgoing',
                'incomingStats',
                'outgoingStats',
                'incomingByCategory',
                'outgoingByCategory',
                'incomingByMonth',
                'outgoingByMonth',
                'comparison'
            ));
        }
    }

    /**
     * Merge all letter PDFs into one PDF file
     */
    public function mergePdf(Request $request)
    {
        $type = $request->input('type', 'monthly');
        $pdfFiles = [];

        if ($type === 'monthly') {
            $month = $request->input('month', now()->format('Y-m'));
            $year = (int) substr($month, 0, 4);
            $monthNum = (int) substr($month, 5, 2);
            $filename = 'Laporan_Surat_' . $month . '.pdf';

            // Get all incoming letters with attachments
            $incomingLetters = IncomingLetter::query()
                ->whereYear('received_date', $year)
                ->whereMonth('received_date', $monthNum)
                ->whereNotNull('file_path')
                ->orderBy('received_date')
                ->get();

            // Get all outgoing letters with attachments
            $outgoingLetters = OutgoingLetter::query()
                ->whereYear('letter_date', $year)
                ->whereMonth('letter_date', $monthNum)
                ->whereNotNull('file_path')
                ->orderBy('letter_date')
                ->get();
        } else {
            $year = (int) $request->input('year', now()->year);
            $filename = 'Laporan_Surat_Tahun_' . $year . '.pdf';

            // Get all incoming letters with attachments
            $incomingLetters = IncomingLetter::query()
                ->whereYear('received_date', $year)
                ->whereNotNull('file_path')
                ->orderBy('received_date')
                ->get();

            // Get all outgoing letters with attachments
            $outgoingLetters = OutgoingLetter::query()
                ->whereYear('letter_date', $year)
                ->whereNotNull('file_path')
                ->orderBy('letter_date')
                ->get();
        }

        // Collect PDF file paths
        foreach ($incomingLetters as $letter) {
            $path = storage_path('app/public/' . $letter->file_path);
            if (file_exists($path) && strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf') {
                $pdfFiles[] = $path;
            }
        }

        foreach ($outgoingLetters as $letter) {
            $path = storage_path('app/public/' . $letter->file_path);
            if (file_exists($path) && strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf') {
                $pdfFiles[] = $path;
            }
        }

        if (empty($pdfFiles)) {
            return back()->with('error', 'Tidak ada file PDF yang ditemukan untuk periode ini.');
        }

        try {
            $merger = new Merger(new TcpdiDriver());

            foreach ($pdfFiles as $pdfFile) {
                $merger->addFile($pdfFile);
            }

            $mergedPdf = $merger->merge();

            return response($mergedPdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menggabungkan PDF: ' . $e->getMessage());
        }
    }

    /**
     * Preview all PDFs before merging
     */
    public function previewPdf(Request $request)
    {
        $type = $request->input('type', 'monthly');

        if ($type === 'monthly') {
            $month = $request->input('month', now()->format('Y-m'));
            $year = (int) substr($month, 0, 4);
            $monthNum = (int) substr($month, 5, 2);
            $periodName = \Carbon\Carbon::createFromDate($year, $monthNum, 1)->translatedFormat('F Y');

            // Get all incoming letters with PDF attachments
            $incomingLetters = IncomingLetter::query()
                ->whereYear('received_date', $year)
                ->whereMonth('received_date', $monthNum)
                ->whereNotNull('file_path')
                ->orderBy('received_date')
                ->get()
                ->filter(function ($letter) {
                    return strtolower(pathinfo($letter->file_path, PATHINFO_EXTENSION)) === 'pdf';
                });

            // Get all outgoing letters with PDF attachments
            $outgoingLetters = OutgoingLetter::query()
                ->whereYear('letter_date', $year)
                ->whereMonth('letter_date', $monthNum)
                ->whereNotNull('file_path')
                ->orderBy('letter_date')
                ->get()
                ->filter(function ($letter) {
                    return strtolower(pathinfo($letter->file_path, PATHINFO_EXTENSION)) === 'pdf';
                });
        } else {
            $year = (int) $request->input('year', now()->year);
            $month = null;
            $periodName = 'Tahun ' . $year;

            // Get all incoming letters with PDF attachments
            $incomingLetters = IncomingLetter::query()
                ->whereYear('received_date', $year)
                ->whereNotNull('file_path')
                ->orderBy('received_date')
                ->get()
                ->filter(function ($letter) {
                    return strtolower(pathinfo($letter->file_path, PATHINFO_EXTENSION)) === 'pdf';
                });

            // Get all outgoing letters with PDF attachments
            $outgoingLetters = OutgoingLetter::query()
                ->whereYear('letter_date', $year)
                ->whereNotNull('file_path')
                ->orderBy('letter_date')
                ->get()
                ->filter(function ($letter) {
                    return strtolower(pathinfo($letter->file_path, PATHINFO_EXTENSION)) === 'pdf';
                });
        }

        // Build PDF URLs for client-side processing
        $pdfList = [];

        foreach ($incomingLetters as $letter) {
            $pdfList[] = [
                'type' => 'Surat Masuk',
                'letter_number' => $letter->letter_number,
                'subject' => $letter->subject,
                'date' => $letter->received_date->format('d/m/Y'),
                'url' => asset('storage/' . $letter->file_path),
                'preview_url' => route('surat-masuk.preview', $letter),
            ];
        }

        foreach ($outgoingLetters as $letter) {
            $pdfList[] = [
                'type' => 'Surat Keluar',
                'letter_number' => $letter->letter_number,
                'subject' => $letter->subject,
                'date' => $letter->letter_date->format('d/m/Y'),
                'url' => asset('storage/' . $letter->file_path),
                'preview_url' => route('surat-keluar.preview', $letter),
            ];
        }

        return view('laporan.preview-pdf', compact('type', 'month', 'year', 'periodName', 'pdfList'));
    }
}
