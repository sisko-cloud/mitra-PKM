<!-- SweetAlert2 Core & Custom Styling -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .swal2-popup {
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        border-radius: 1.25rem !important;
        padding: 1.75rem !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    }
    html.dark .swal2-popup {
        background-color: #0f172a !important;
        color: #f8fafc !important;
        border: 1px solid #1e293b !important;
    }
    html.dark .swal2-title {
        color: #f8fafc !important;
    }
    html.dark .swal2-html-container {
        color: #94a3b8 !important;
    }
    .swal2-title {
        font-weight: 800 !important;
        letter-spacing: -0.025em !important;
        font-size: 1.35rem !important;
    }
    .swal2-html-container {
        font-size: 0.925rem !important;
        line-height: 1.5 !important;
    }
    .swal2-styled.swal2-confirm {
        background: linear-gradient(135deg, #ea580c 0%, #f97316 100%) !important;
        border-radius: 0.75rem !important;
        font-weight: 700 !important;
        font-size: 0.875rem !important;
        padding: 0.65rem 1.5rem !important;
        box-shadow: 0 10px 15px -3px rgba(234, 88, 12, 0.3) !important;
    }
    .swal2-styled.swal2-confirm:hover {
        background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%) !important;
    }
    .swal2-styled.swal2-cancel {
        background-color: #64748b !important;
        border-radius: 0.75rem !important;
        font-weight: 600 !important;
        font-size: 0.875rem !important;
        padding: 0.65rem 1.5rem !important;
    }
    .swal2-styled.swal2-cancel:hover {
        background-color: #475569 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isDark = document.documentElement.classList.contains('dark');
        const themeBg = isDark ? '#0f172a' : '#ffffff';
        const themeColor = isDark ? '#f8fafc' : '#0f172a';

        // 1. Success Flash Message
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: {!! json_encode(session('success')) !!},
                confirmButtonColor: '#ea580c',
                confirmButtonText: 'Selesai',
                background: themeBg,
                color: themeColor,
                timer: 4500,
                timerProgressBar: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                }
            });
        @endif

        // 2. Error Flash Message
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Perhatian / Terjadi Kesalahan',
                text: {!! json_encode(session('error')) !!},
                confirmButtonColor: '#ea580c',
                confirmButtonText: 'Tutup',
                background: themeBg,
                color: themeColor
            });
        @endif

        // 3. Info Flash Message
        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: {!! json_encode(session('info')) !!},
                confirmButtonColor: '#ea580c',
                confirmButtonText: 'Mengerti',
                background: themeBg,
                color: themeColor
            });
        @endif

        // 4. Status Flash Message
        @if (session('status'))
            Swal.fire({
                icon: 'info',
                title: 'Status Pemberitahuan',
                text: {!! json_encode(session('status')) !!},
                confirmButtonColor: '#ea580c',
                confirmButtonText: 'Mengerti',
                background: themeBg,
                color: themeColor
            });
        @endif

        // 5. Validation Errors Message (menampilkan modal ringkasan kesalahan formulir secara interaktif)
        @if ($errors->any())
            Swal.fire({
                icon: 'warning',
                title: 'Periksa Formulir Anda',
                html: `
                    <div style="text-align: left; font-size: 0.875rem;">
                        <p style="margin-bottom: 0.5rem; font-weight: 600;">Terdapat beberapa data yang perlu diperbaiki:</p>
                        <ul style="list-style-type: disc; padding-left: 1.25rem; space-y: 0.25rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ addslashes($error) }}</li>
                            @endforeach
                        </ul>
                    </div>
                `,
                confirmButtonColor: '#ea580c',
                confirmButtonText: 'Perbaiki Sekarang',
                background: themeBg,
                color: themeColor
            });
        @endif

        // 6. Global Confirmation Handler for Forms with [data-confirm]
        document.querySelectorAll('form[data-confirm]').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const title = form.getAttribute('data-title') || 'Konfirmasi Tindakan';
                const message = form.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
                const confirmText = form.getAttribute('data-confirm-text') || 'Ya, Lanjutkan';
                const isDestructive = form.getAttribute('data-destructive') === 'true' || 
                                     (form.querySelector('input[name="_method"]') && form.querySelector('input[name="_method"]').value === 'DELETE');

                Swal.fire({
                    title: title,
                    text: message,
                    icon: isDestructive ? 'warning' : 'question',
                    showCancelButton: true,
                    confirmButtonColor: isDestructive ? '#dc2626' : '#ea580c',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: confirmText,
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    background: themeBg,
                    color: themeColor
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // 7. Global Confirmation Handler for Links/Buttons with [data-confirm-link]
        document.querySelectorAll('[data-confirm-link]').forEach(function(element) {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                const targetUrl = element.getAttribute('href');
                const title = element.getAttribute('data-title') || 'Konfirmasi Tindakan';
                const message = element.getAttribute('data-confirm-link') || 'Apakah Anda yakin ingin melanjutkan?';

                Swal.fire({
                    title: title,
                    text: message,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ea580c',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    background: themeBg,
                    color: themeColor
                }).then(function(result) {
                    if (result.isConfirmed && targetUrl) {
                        window.location.href = targetUrl;
                    }
                });
            });
        });
    });

    // Global utility function accessible anywhere in scripts
    window.showSweetAlert = function(type, title, message) {
        const isDark = document.documentElement.classList.contains('dark');
        return Swal.fire({
            icon: type || 'info',
            title: title || 'Pemberitahuan',
            text: message || '',
            confirmButtonColor: '#ea580c',
            confirmButtonText: 'Tutup',
            background: isDark ? '#0f172a' : '#ffffff',
            color: isDark ? '#f8fafc' : '#0f172a'
        });
    };

    window.confirmSweetAlert = function(options) {
        const isDark = document.documentElement.classList.contains('dark');
        return Swal.fire({
            title: options.title || 'Konfirmasi',
            text: options.text || 'Apakah Anda yakin?',
            icon: options.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: options.confirmColor || '#ea580c',
            cancelButtonColor: '#64748b',
            confirmButtonText: options.confirmText || 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            background: isDark ? '#0f172a' : '#ffffff',
            color: isDark ? '#f8fafc' : '#0f172a'
        });
    };
</script>
