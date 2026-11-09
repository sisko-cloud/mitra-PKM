@extends('layouts.app')

@section('title', 'Tinjau Verifikasi - ' . $mitra->nama_usaha)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ showRejectModal: false }">

    <!-- Breadcrumb & Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.verifications.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-emerald-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Antrean Verifikasi
        </a>
        @if ($mitra->user?->isApproved())
            <a href="{{ route('mitra.show', ['slug' => $mitra->slug]) }}" target="_blank" class="text-xs font-bold text-emerald-600 hover:underline inline-flex items-center gap-1">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Website Promosi Mitra Live
            </a>
        @endif
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Kolom Kiri: Detail Berkas Usaha (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Card Profil Usaha -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
                <div class="flex items-start gap-4 pb-6 border-b border-slate-200 mb-6">
                    @if ($mitra->logo)
                        <img src="{{ asset('storage/' . $mitra->logo) }}" alt="Logo" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-xs">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-slate-100 text-slate-500 font-extrabold text-2xl flex items-center justify-center shrink-0 border border-slate-200">
                            {{ substr($mitra->nama_usaha, 0, 2) }}
                        </div>
                    @endif
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $mitra->jenis === 'umkm' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $mitra->jenis }}
                            </span>
                            <span class="text-xs text-slate-400">&bull; Terdaftar: {{ $mitra->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <h1 class="text-2xl font-extrabold text-slate-900">{{ $mitra->nama_usaha }}</h1>
                        <span class="text-xs font-mono text-emerald-600">/mitra/{{ $mitra->slug }}</span>
                    </div>
                </div>

                <div class="space-y-4 text-xs sm:text-sm">
                    <div>
                        <span class="font-bold uppercase tracking-wider text-slate-400 text-[11px] block mb-0.5">Alamat Lengkap Usaha:</span>
                        <p class="text-slate-700 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100">{{ $mitra->alamat }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <span class="font-bold uppercase tracking-wider text-slate-400 text-[11px] block mb-0.5">Kontak WhatsApp:</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $mitra->kontak) }}" target="_blank" class="font-semibold text-emerald-700 hover:underline flex items-center gap-1.5">
                                <i class="fa-brands fa-whatsapp text-base"></i> {{ $mitra->kontak }}
                            </a>
                        </div>
                        <div>
                            <span class="font-bold uppercase tracking-wider text-slate-400 text-[11px] block mb-0.5">Penanggung Jawab:</span>
                            <span class="font-semibold text-slate-800">{{ $mitra->user?->name }} ({{ $mitra->user?->email }})</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Dokumen Pendukung -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
                <h3 class="text-base font-bold text-slate-900 mb-2 flex items-center gap-2">
                    <i class="fa-regular fa-file-lines text-emerald-600"></i> Dokumen Pendukung Pendaftaran
                </h3>
                <p class="text-xs text-slate-500 mb-4">Berkas legalitas atau KTP yang diunggah oleh pendaftar saat registrasi.</p>

                @if ($mitra->dokumen_pendukung)
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-circle-check text-emerald-600 text-2xl"></i>
                            <div>
                                <span class="font-bold text-xs text-slate-800 block">Berkas Dokumen Pendukung</span>
                                <span class="text-[11px] text-slate-400">{{ basename($mitra->dokumen_pendukung) }}</span>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $mitra->dokumen_pendukung) }}" target="_blank"
                            class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg transition shadow-xs flex items-center gap-1.5">
                            <i class="fa-solid fa-eye text-xs"></i> Buka Dokumen
                        </a>
                    </div>
                @else
                    <div class="p-4 bg-slate-50 border border-dashed border-slate-200 rounded-xl text-center text-xs text-slate-400">
                        <i class="fa-regular fa-circle-question text-xl mb-1 text-slate-300 block"></i>
                        Pendaftar tidak mengunggah dokumen pendukung opsional.
                    </div>
                @endif
            </div>

            <!-- Tinjau Konten Template jika sudah ada -->
            @if ($mitra->websiteContent)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-emerald-600"></i> Ringkasan Template Website (4 Section)
                    </h3>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Judul Website:</span>
                            <span class="font-semibold text-slate-800">{{ $mitra->websiteContent->judul }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Jumlah Produk:</span>
                            <span class="font-semibold text-slate-800">{{ $mitra->products()->count() }} Produk terdaftar</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- Kolom Kanan: Panel Keputusan Verifikasi (1 Col) -->
        <div class="space-y-6">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sticky top-24">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-700 mb-4 pb-3 border-b border-slate-200">
                    Keputusan Verifikasi
                </h3>

                <!-- Status Badge -->
                <div class="mb-6">
                    <span class="text-xs text-slate-400 block mb-1">Status Saat Ini:</span>
                    @php $status = $mitra->user?->status ?? 'pending'; @endphp
                    @if ($status === 'approved')
                        <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 font-bold text-xs flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                            <div>
                                <span class="block">Telah Disetujui</span>
                                <span class="text-[10px] font-normal text-emerald-700">Template website aktif</span>
                            </div>
                        </div>
                    @elseif ($status === 'rejected')
                        <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs">
                            <div class="flex items-center gap-2 font-bold mb-1">
                                <i class="fa-solid fa-circle-xmark text-rose-600 text-base"></i> Ditolak
                            </div>
                            <span class="text-[11px] text-rose-700 italic block">"{{ $mitra->user?->rejection_reason }}"</span>
                        </div>
                    @else
                        <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 font-bold text-xs flex items-center gap-2">
                            <i class="fa-solid fa-hourglass-half text-amber-600 text-base animate-pulse"></i>
                            <div>
                                <span class="block">Menunggu Verifikasi</span>
                                <span class="text-[10px] font-normal text-amber-700">Memerlukan persetujuan admin</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Form Approve -->
                <form method="POST" action="{{ route('admin.verifications.approve', $mitra->id) }}" class="mb-3">
                    @csrf
                    <button type="submit" onclick="return confirm('Setujui pendaftaran mitra ini? Template 4-section akan otomatis dibuat dan notifikasi dikirim.');"
                        class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-emerald-600/20">
                        <i class="fa-solid fa-check"></i>
                        <span>Setujui Pendaftaran</span>
                    </button>
                </form>

                <!-- Trigger Reject Modal -->
                <button type="button" @click="showRejectModal = true"
                    class="w-full flex items-center justify-center gap-2 py-2.5 px-4 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-xl border border-rose-200 transition">
                    <i class="fa-solid fa-xmark"></i>
                    <span>Tolak dengan Alasan</span>
                </button>

                <p class="text-[11px] text-slate-400 mt-4 leading-relaxed">
                    Setiap perubahan status akan secara otomatis memicu notifikasi database di akun owner serta pengiriman email pemberitahuan.
                </p>
            </div>

        </div>

    </div>

    <!-- Modal Form Tolak Pendaftaran -->
    <div x-show="showRejectModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200" @click.away="showRejectModal = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
                <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600"></i> Tolak Pendaftaran Mitra
                </h3>
                <button @click="showRejectModal = false" class="text-slate-400 hover:text-slate-600 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.verifications.reject', $mitra->id) }}">
                @csrf
                <p class="text-xs text-slate-600 mb-3">
                    Wajib menuliskan alasan penolakan agar owner mengetahui bagian mana yang perlu diperbaiki (misal: foto dokumen tidak jelas, kontak tidak valid):
                </p>

                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Alasan Penolakan <span class="text-rose-500">*</span></label>
                    <textarea name="rejection_reason" rows="4" required minlength="5"
                        placeholder="Contoh: Foto dokumen pendukung atau KTP buram dan tidak terbaca. Mohon unggah ulang foto yang jelas dan pastikan nomor kontak WhatsApp aktif."
                        class="w-full px-3 py-2 border border-slate-300 rounded-xl text-xs focus:ring-rose-500 focus:border-rose-500">{{ old('rejection_reason', $mitra->user?->rejection_reason) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-2">
                    <button type="button" @click="showRejectModal = false" class="px-4 py-2 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                        Kirim Penolakan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
