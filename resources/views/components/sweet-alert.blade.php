<script>
    /**
     * SweetAlert2 Global Mixins
     */

    // 1. Toast Mixin (Feedback Cepat)
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#1f2937',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // 2. Alert Mixin (Konfirmasi/Aksi Penting)
    const Alert = Swal.mixin({
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FBBF24', // kuning
        cancelButtonColor: '#6B7280',  // abu
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
        color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#1f2937',
        customClass: {
            confirmButton: 'hover:opacity-90 transition-opacity',
            cancelButton: 'hover:opacity-90 transition-opacity'
        }
    });

    // Helper function for delete confirmation
    window.confirmDelete = function(formId, title = 'Yakin hapus data?', text = 'Data yang dihapus tidak bisa dikembalikan!') {
        Alert.fire({
            title: title,
            text: text,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    };

    // Laravel Session Integration
    document.addEventListener('DOMContentLoaded', () => {
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif

        @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                title: "{{ session('warning') }}"
            });
        @endif

        @if(session('info'))
            Toast.fire({
                icon: 'info',
                title: "{{ session('info') }}"
            });
        @endif
    });
</script>
