<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchiveSearchController extends Controller
{
    public function index(Request $request)
    {
        $incoming = DB::table('incoming_letters')->select([
            'id',
            DB::raw("'incoming' as source"),
            DB::raw("'Surat Masuk' as jenis"),
            'letter_number as nomor_surat',
            'letter_date as tanggal_surat',
            'subject as perihal',
            'sender as instansi',
            'status',
            'category as folder',
            'created_at',
        ]);

        $outgoing = DB::table('outgoing_letters')->select([
            'id',
            DB::raw("'outgoing' as source"),
            DB::raw("'Surat Keluar' as jenis"),
            'letter_number as nomor_surat',
            'letter_date as tanggal_surat',
            'subject as perihal',
            'recipient as instansi',
            'status',
            'category as folder',
            'created_at',
        ]);

        $archivesBase = DB::table('archives')->select([
            'id',
            DB::raw("'archive' as source"),
            'jenis',
            'nomor_surat',
            'tanggal_surat',
            'perihal',
            DB::raw('COALESCE(pengirim, penerima) as instansi'),
            'status',
            'folder',
            'created_at',
        ]);

        $union = $incoming->unionAll($outgoing)->unionAll($archivesBase);

        $query = DB::query()->fromSub($union, 'archives');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('nomor_surat', 'like', '%' . $search . '%')
                    ->orWhere('perihal', 'like', '%' . $search . '%')
                    ->orWhere('instansi', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->input('jenis'));
        }

        if ($request->filled('folder')) {
            $query->where('folder', $request->input('folder'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('date_start')) {
            $query->whereDate('tanggal_surat', '>=', $request->input('date_start'));
        }

        if ($request->filled('date_end')) {
            $query->whereDate('tanggal_surat', '<=', $request->input('date_end'));
        }

        $archives = $query
            ->orderByRaw('COALESCE(tanggal_surat, created_at) DESC')
            ->paginate(10)
            ->withQueryString();

        $jenisOptions = collect(['Surat Masuk', 'Surat Keluar'])
            ->merge(Archive::query()->whereNotNull('jenis')->distinct()->orderBy('jenis')->pluck('jenis'))
            ->unique()
            ->values();

        $folderOptions = IncomingLetter::query()->whereNotNull('category')->distinct()->pluck('category')
            ->merge(OutgoingLetter::query()->whereNotNull('category')->distinct()->pluck('category'))
            ->merge(Archive::query()->whereNotNull('folder')->distinct()->pluck('folder'))
            ->unique()
            ->values();

        $statusOptions = IncomingLetter::query()->whereNotNull('status')->distinct()->pluck('status')
            ->merge(OutgoingLetter::query()->whereNotNull('status')->distinct()->pluck('status'))
            ->merge(Archive::query()->whereNotNull('status')->distinct()->pluck('status'))
            ->unique()
            ->values();

        return view('cari-arsip', compact('archives', 'jenisOptions', 'folderOptions', 'statusOptions'));
    }
}
