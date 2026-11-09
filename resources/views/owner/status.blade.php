@extends('layouts.app')

@section('title', 'Status Verifikasi Akun')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header Status -->
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Status Pendaftaran Mitra</h1>
        <p class="text-sm text-slate-600 mt-1">Pantau perkembangan status verifikasi usaha Anda oleh tim Superadmin Mitra PKM.</p>
    </div>

    <!-- KONDISI 1: PENDING (MENUNGGU VERIFIKASI) -->
    @if ($user->isPending())
        <div class="bg-white rounded-2xl border border-amber-200 shadow-md p-6 sm:p-8 mb-8 overflow-hidden relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-100 rounded-bl-full opacity-50 pointer-events-none"></div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-3xl shadow-lg shadow-amber-500/30 animate-pulse">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold uppercase tracking-wider mb-1">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span> Menunggu Verifikasi
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Pendaftaran Sedang Ditinjau</h2>
                    <p class="text-sm text-slate-600 mt-0.5">Berkas usaha Anda telah masuk dalam antrean verifikasi tim Superadmin.</p>
                </div>
            </div>

            <div class="bg-amber-50/70 border border-amber-200 rounded-xl p-4 text-xs sm:text-sm text-amber-900 leading-relaxed mb-6">
                <p class="font-semibold mb-1"><i class="fa-solid fa-clock-rotate-left mr-1.5 text-amber-600"></i> Estimasi Proses Verifikasi: 1 x 24 Jam Kerja</p>
                <p>Begitu akun disetujui, template website promosi akan dibuat secara otomatis dan menu editor (Beranda, Tentang, Produk, Kontak) akan langsung terbuka untuk Anda kelola.</p>
            </div>

            <!-- Ringkasan Data Usaha yang Diajukan -->
            @if ($mitra)
                <div class="border-t border-slate-200 pt-6">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-700 mb-4">Ringkasan Data Usaha yang Diajukan:</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl text-xs sm:text-sm">
                        <div>
                            <span class="text-slate-500 block text-xs">Nama Usaha:</span>
                            <span class="font-bold text-slate-900">{{ $mitra->nama_usaha }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs">Jenis Usaha:</span>
                            <span class="font-bold uppercase text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded text-xs inline-block">{{ $mitra->jenis }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs">Nomor Kontak / WhatsApp:</span>
                            <span class="font-semibold text-slate-800">{{ $mitra->kontak }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs">Slug Alamat Web yang Disiapkan:</span>
                            <span class="font-mono text-emerald-600">/mitra/{{ $mitra->slug }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-slate-500 block text-xs">Alamat Usaha:</span>
                            <span class="text-slate-700">{{ $mitra->alamat }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    <!-- KONDISI 2: REJECTED (DITOLAK DENGAN ALASAN & FORM AJUKAN ULANG) -->
    @elseif ($user->isRejected())
        <div class="bg-white rounded-2xl border border-rose-300 shadow-md p-6 sm:p-8 mb-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-rose-600 text-white flex items-center justify-center text-3xl shadow-lg shadow-rose-600/30">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-bold uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-circle-xmark"></i> Pendaftaran Ditolak
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Perlu Perbaikan Data Pendaftaran</h2>
                    <p class="text-sm text-slate-600 mt-0.5">Superadmin telah meninjau pengajuan Anda dan memerlukan klarifikasi/perbaikan data.</p>
                </div>
            </div>

            <!-- Alasan Penolakan -->
            <div class="p-4 bg-rose-50 border-l-4 border-rose-600 rounded-r-xl text-xs sm:text-sm text-rose-900 mb-8">
                <span class="font-bold block mb-1 text-rose-800"><i class="fa-solid fa-comment-dots mr-1"></i> Catatan / Alasan Penolakan dari Superadmin:</span>
                <p class="text-slate-800 italic font-medium leading-relaxed">"{{ $user->rejection_reason ?? 'Data berkas pendaftaran belum memenuhi kelengkapan verifikasi.' }}"</p>
            </div>

            <!-- Form Perbaikan & Pengajuan Ulang -->
            <div class="border-t border-slate-200 pt-6">
                <h3 class="text-base font-bold text-slate-900 mb-1">Perbaiki Data dan Ajukan Ulang</h3>
                <p class="text-xs text-slate-500 mb-6">Silakan perbarui data di bawah ini sesuai catatan superadmin, lalu klik tombol "Ajukan Ulang Verifikasi".</p>

                <form method="POST" action="{{ route('owner.status.resubmit') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Usaha</label>
                            <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $mitra?->nama_usaha) }}" required
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Jenis Usaha</label>
                            <select name="jenis" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="umkm" {{ old('jenis', $mitra?->jenis) === 'umkm' ? 'selected' : '' }}>UMKM</option>
                                <option value="koperasi" {{ old('jenis', $mitra?->jenis) === 'koperasi' ? 'selected' : '' }}>Koperasi</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nomor Kontak / WhatsApp</label>
                        <input type="text" name="kontak" value="{{ old('kontak', $mitra?->kontak) }}" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Alamat Lengkap Usaha</label>
                        <textarea name="alamat" rows="2" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500">{{ old('alamat', $mitra?->alamat) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-3 border border-dashed border-slate-300 rounded-lg bg-slate-50">
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Unggah Ulang Logo (Opsional)</label>
                            <input type="file" name="logo" accept="image/png,image/jpeg,image/webp" class="text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white">
                        </div>
                        <div class="p-3 border border-dashed border-slate-300 rounded-lg bg-slate-50">
                            <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Unggah Ulang Dokumen (Opsional)</label>
                            <input type="file" name="dokumen_pendukung" accept="image/png,image/jpeg,image/webp,application/pdf" class="text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-slate-700 file:text-white">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md transition shadow-emerald-600/30">
                            <i class="fa-solid fa-paper-plane"></i> Simpan Perbaikan & Ajukan Ulang
                        </button>
                    </div>
                </form>
            </div>
        </div>

    <!-- KONDISI 3: SUSPENDED (DINONAKTIFKAN SUPERADMIN) -->
    @elseif ($user->isSuspended())
        <div class="bg-white rounded-2xl border border-slate-300 shadow-md p-6 sm:p-8 mb-8 text-center">
            <div class="w-16 h-16 rounded-2xl bg-slate-800 text-white flex items-center justify-center text-3xl mx-auto mb-4">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-800 text-xs font-bold uppercase tracking-wider mb-2">
                Akun Ditangguhkan (Suspended)
            </div>
            <h2 class="text-xl font-bold text-slate-900 mb-2">Akun Anda Sedang Dinonaktifkan</h2>
            <p class="text-sm text-slate-600 max-w-md mx-auto mb-6">
                Akses editor dan halaman publik website mitra ini sementara dinonaktifkan oleh Superadmin Mitra PKM. Untuk mengaktifkan kembali, silakan hubungi tim administrasi kami.
            </p>
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold">
                <i class="fa-solid fa-envelope text-emerald-600"></i> Kontak Bantuan: admin@mitrapkm.id
            </div>
        </div>
    @endif

    <!-- Riwayat Notifikasi Akun -->
    @if ($notifications->count() > 0)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-700 mb-4 flex items-center gap-2">
                <i class="fa-regular fa-bell text-emerald-600"></i> Riwayat Pemberitahuan Sistem
            </h3>
            <div class="space-y-3">
                @foreach ($notifications as $notif)
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs flex items-start justify-between gap-3">
                        <div class="flex items-start gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5"></span>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $notif->data['message'] ?? 'Pembaruan akun' }}</p>
                                @if(!empty($notif->data['reason']))
                                    <p class="text-slate-600 mt-0.5 italic">"{{ $notif->data['reason'] }}"</p>
                                @endif
                            </div>
                        </div>
                        <span class="text-[10px] text-slate-400 whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
