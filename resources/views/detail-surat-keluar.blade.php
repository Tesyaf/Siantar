<x-app-layout>
  <div class="min-h-screen bg-[#f5f7fb]">
    <main class="max-w-[1180px] mx-auto px-4 sm:px-6 py-6">
      <a href="{{ route('surat-keluar.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-orange-500 font-semibold text-sm no-underline transition-colors">
        <i class="bi bi-arrow-left"></i> Kembali ke Surat Keluar
      </a>

      <h1 class="mt-4 mb-1 text-2xl font-extrabold text-gray-900">{{ $outgoingLetter->subject }}</h1>
      <p class="text-gray-500 text-sm mb-6">Informasi lengkap mengenai surat keluar ({{ $outgoingLetter->letter_number }})</p>

      <section class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
        <div class="flex items-start justify-between flex-wrap gap-3 mb-5">
          @if ($outgoingLetter->category)
          <div class="flex flex-col gap-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700 border border-orange-200">{{ $outgoingLetter->category }}</span>
          </div>
          @endif
          @if (auth()->user()->hasAnyRole(['sekretariat', 'admin']))
          <div class="flex gap-2">
            <a href="{{ route('surat-keluar.edit', $outgoingLetter) }}" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 transition no-underline">
              <i class="bi bi-pencil-square me-2"></i> Edit Surat
            </a>
            <form action="{{ route('surat-keluar.destroy', $outgoingLetter) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini? Tindakan ini tidak dapat dibatalkan.')">
              @csrf
              @method('DELETE')
              <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-xl text-sm font-bold hover:bg-red-600 transition">
                <i class="bi bi-trash me-2"></i> Hapus
              </button>
            </form>
          </div>
          @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">No Index</div>
            <div class="font-bold text-gray-900">{{ $outgoingLetter->index_no ?? '-' }}</div>
          </div>
          <div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Nomor Surat</div>
            <div class="font-bold text-gray-900">{{ $outgoingLetter->letter_number }}</div>
          </div>
          <div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Tujuan</div>
            <div class="font-bold text-gray-900">{{ $outgoingLetter->recipient }}</div>
          </div>

          <div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Tanggal Surat</div>
            <div class="font-bold text-gray-900">{{ optional($outgoingLetter->letter_date)->format('d M Y') }}</div>
          </div>
          <div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Perihal</div>
            <div class="font-bold text-gray-900">{{ $outgoingLetter->subject }}</div>
          </div>

          <div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Jenis Surat</div>
            <div class="font-bold text-gray-900">Surat Keluar</div>
          </div>
          <div>
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Kategori</div>
            <div class="font-bold text-gray-900">{{ $outgoingLetter->category ?? '-' }}</div>
          </div>
        </div>
      </section>

      <section class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mt-4">
        <div class="flex items-center gap-3 font-bold text-gray-900 mb-4">
          <span class="w-8 h-8 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-sm">
            <i class="bi bi-file-earmark-text"></i>
          </span>
          Ringkasan Isi Surat
        </div>
        <p class="text-gray-600 text-sm">
          {{ $outgoingLetter->summary ?? 'Ringkasan surat belum tersedia.' }}
        </p>
      </section>

      <section class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mt-4">
        <div class="flex items-center gap-3 font-bold text-gray-900 mb-4">
          <span class="w-8 h-8 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-sm">
            <i class="bi bi-paperclip"></i>
          </span>
          Lampiran Dokumen
        </div>
        @if ($attachment)
        @php
        $extension = strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION));
        $fileBadge = $extension === 'pdf' ? 'PDF' : strtoupper(substr($extension, 0, 1));
        $fileBadgeClass = match (true) {
        in_array($extension, ['doc', 'docx'], true) => 'bg-blue-100 text-blue-700',
        $extension === 'pdf' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700',
        };
        $isPreviewable = in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif'], true);
        @endphp
        <div class="flex items-center gap-4 border border-gray-200 rounded-xl p-4">
          <div class="inline-flex items-center justify-center px-3 py-1 rounded-lg font-bold text-xs {{ $fileBadgeClass }}">{{ $fileBadge }}</div>
          <div class="flex-1">
            <div class="font-bold text-gray-900">{{ $attachment['name'] }}</div>
            <div class="text-gray-500 text-xs">{{ strtoupper($extension) }} - {{ $attachment['size'] }}</div>
          </div>
          <div class="flex gap-2">
            @if (!empty($attachment['is_gdrive']) && !empty($attachment['view_url']))
            <a class="inline-flex items-center px-4 py-2 border border-orange-500 text-orange-500 rounded-lg text-sm font-bold hover:bg-orange-50 transition no-underline" href="{{ $attachment['view_url'] }}" target="_blank" rel="noopener">Lihat</a>
            @else
            <a class="inline-flex items-center px-4 py-2 border border-orange-500 text-orange-500 rounded-lg text-sm font-bold hover:bg-orange-50 transition no-underline" href="{{ $attachment['url'] }}" target="_blank" rel="noopener">Lihat</a>
            @endif
            <a class="inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-lg text-sm font-bold hover:bg-orange-600 transition no-underline" href="{{ route('surat-keluar.download', $outgoingLetter) }}">Unduh</a>
          </div>
        </div>

        {{-- Preview File untuk Google Drive --}}
        @if (!empty($attachment['is_gdrive']) && !empty($attachment['preview_url']) && $isPreviewable)
        <div class="mt-4">
          <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Preview Dokumen</div>
          <div class="w-full rounded-xl overflow-hidden border border-gray-200" style="height: 600px;">
            <iframe src="{{ $attachment['preview_url'] }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
        @elseif (empty($attachment['is_gdrive']) && !empty($attachment['preview_url']) && $isPreviewable)
        {{-- Preview File Lokal --}}
        <div class="mt-4">
          <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Preview Dokumen</div>
          <div class="w-full rounded-xl overflow-hidden border border-gray-200 bg-gray-50" style="height: 600px;">
            @if ($extension === 'pdf')
            <object data="{{ $attachment['preview_url'] }}" type="application/pdf" class="w-full h-full">
              <p class="p-4 text-center text-gray-500">Browser tidak mendukung preview PDF. <a href="{{ $attachment['preview_url'] }}" target="_blank" class="text-orange-500 hover:underline">Klik di sini untuk melihat</a></p>
            </object>
            @else
            <img src="{{ $attachment['preview_url'] }}" alt="Preview" class="w-full h-full object-contain">
            @endif
          </div>
        </div>
        @endif
        @else
        <div class="text-gray-500 text-sm">Tidak ada lampiran untuk surat ini.</div>
        @endif
      </section>
    </main>
  </div>
</x-app-layout>
