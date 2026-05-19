@extends('layouts.admin')

@section('content')
    <div class="space-y-8">

        <!-- HEADER SECTION -->
       <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-yellow-50 dark:bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 rounded-xl border border-yellow-100 dark:border-yellow-500/20">
                    <i data-lucide="circle-star" class="w-7 h-7 text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-semibold text-gray-800 dark:text-gray-100">Manajemen Lapangan</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kelola dan monitor semua aktivitas lapangan</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('courts.create') }}"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2.5 bg-yellow-500 hover:bg-yellow-600 active:scale-95 text-white px-6 py-3 rounded-2xl font-medium transition-all shadow-lg shadow-yellow-500/10">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    Tambah Lapangan
                </a>
            </div>
        </div>

        <!-- STATS / OVERVIEW -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Total Lapangan</p>
                <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $courts->count() }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Indoor</p>
                <p class="text-2xl font-black text-blue-500">{{ $courts->where('type', 'Indoor')->count() }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Semi-Indoor</p>
                <p class="text-2xl font-black text-amber-500">{{ $courts->where('type', 'Semi-Indoor')->count() }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Aktif</p>
                <p class="text-2xl font-black text-green-500">{{ $courts->where('status', 1)->count() }}</p>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white dark:bg-gray-900 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            
            <div class="p-6 border-b border-gray-50 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Lapangan</h3>
                <div class="relative group max-w-sm w-full">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 group-focus-within:text-yellow-500 transition-colors"></i>
                    </div>
                    <input type="text" placeholder="Cari nama lapangan..." 
                        class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-sm focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-yellow-500/10 focus:border-yellow-500 transition-all outline-none">
                </div>
            </div>

            <div class="overflow-x-auto scrollbar-hide">
                <table class="w-full min-w-[800px] text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-800/50 text-gray-400 dark:text-gray-500 text-[10px] uppercase tracking-[0.15em] font-black">
                            <th class="px-8 py-5">Lapangan</th>
                            <th class="px-8 py-5">Jenis</th>
                            <th class="px-8 py-5">Harga Sewa</th>
                            <th class="px-8 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Manajemen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @forelse($courts as $court)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="relative w-14 h-14 shrink-0 overflow-hidden rounded-2xl bg-gray-100 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                            @if ($court->image)
                                                <img src="{{ asset('storage/' . $court->image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                    <i data-lucide="image" class="w-6 h-6"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white text-base tracking-tight leading-none mb-1.5">{{ $court->name }}</p>
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded-md">ID: {{ $court->id }}</span>
                                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">• Tennis Court</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $type = strtolower($court->type);
                                        $typeColor = $type == 'indoor' ? 'blue' : ($type == 'semi-indoor' ? 'amber' : 'purple');
                                        $typeIcon = $type == 'indoor' ? 'home' : ($type == 'semi-indoor' ? 'cloud-rain' : 'sun');
                                    @endphp
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-{{ $typeColor }}-50 dark:bg-{{ $typeColor }}-500/10 text-{{ $typeColor }}-600 dark:text-{{ $typeColor }}-400 border border-{{ $typeColor }}-100 dark:border-{{ $typeColor }}-500/20">
                                        <i data-lucide="{{ $typeIcon }}" class="w-3.5 h-3.5 text-{{ $typeColor }}-500"></i>
                                        <span class="text-xs font-bold uppercase tracking-wider">{{ $court->type }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-base font-medium text-gray-900 dark:text-white">Rp {{ number_format($court->price, 0, ',', '.') }}</span>
                                        <span class="text-[10px] font-medium text-gray-400 uppercase tracking-widest mt-1">Net per jam</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    @if($court->status == 1)
                                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 border border-green-100 dark:border-green-500/20">
                                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
                                            <span class="text-xs font-bold uppercase tracking-wider">Tersedia</span>
                                        </div>
                                    @else
                                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-500/20">
                                            <div class="w-1.5 h-1.5 rounded-full bg-red-500"></div>
                                            <span class="text-xs font-bold uppercase tracking-wider">Dibooking</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('courts.edit', $court->id) }}"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-yellow-600 dark:hover:text-yellow-500 hover:border-yellow-200 transition-all shadow-sm group/btn" title="Edit Data">
                                            <i data-lucide="pencil-line" class="w-4.5 h-4.5 group-hover/btn:scale-110 transition-transform"></i>
                                        </a>

                                        <button onclick="deleteCourt('{{ $court->id }}', '{{ $court->name }}')"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-red-600 hover:border-red-200 transition-all shadow-sm group/btn" title="Hapus Lapangan">
                                            <i data-lucide="trash-2" class="w-4.5 h-4.5 group-hover/btn:scale-110 transition-transform"></i>
                                        </button>

                                        <form id="delete-form-{{ $court->id }}" action="{{ route('courts.destroy', $court->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-20 h-20 bg-gray-50 dark:bg-gray-800 rounded-[2rem] flex items-center justify-center mb-6 border border-gray-100 dark:border-gray-700">
                                            <i data-lucide="inbox" class="w-10 h-10 text-gray-300 dark:text-gray-600"></i>
                                        </div>
                                        <p class="text-gray-900 dark:text-white font-black text-lg tracking-tight">Belum Ada Data Lapangan</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 max-w-xs text-center leading-relaxed">Mulai dengan menambahkan lapangan baru untuk mengaktifkan sistem booking.</p>
                                        <a href="{{ route('courts.create') }}" class="mt-6 inline-flex items-center gap-2 text-yellow-600 font-bold hover:underline">
                                            Tambah Sekarang
                                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-gray-50/50 dark:bg-gray-800/30 border-t border-gray-50 dark:border-gray-800 flex items-center justify-between">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Menampilkan {{ $courts->count() }} Lapangan</p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function deleteCourt(id, name) {
            Swal.fire({
                title: 'Hapus Lapangan?',
                text: `Anda akan menghapus "${name}". Data yang sudah dihapus tidak dapat dikembalikan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold',
                    cancelButton: 'rounded-xl px-6 py-2.5 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            })
        }
    </script>
    @endpush
@endsection