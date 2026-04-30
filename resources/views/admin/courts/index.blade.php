@extends('layouts.admin')

@section('content')
    <div class="w-full space-y-6">

        <!-- HEADER SECTION -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-yellow-50 text-yellow-600 rounded-xl border border-yellow-100">
                    <i data-lucide="layout-grid" class="w-5 h-5"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Data Lapangan</h1>
                    <p class="text-sm text-gray-500">Kelola lapangan yang tersedia dan harga</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('courts.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500/50">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Tambah Lapangan
                </a>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-6 py-4">Lapangan</th>
                            <th class="px-6 py-4">Tipe</th>
                            <th class="px-6 py-4">Harga / Jam</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($courts as $court)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100 text-gray-400">
                                            <i data-lucide="monitor" class="w-5 h-5"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $court->name }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">ID: {{ $court->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium {{ strtolower($court->type) == 'indoor' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }}">
                                        {{ ucfirst($court->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-semibold text-gray-700">Rp
                                        {{ number_format($court->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium {{ $court->status == 1 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                        {{ $court->status == 1 ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('courts.edit', $court->id) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition duration-200">
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('courts.destroy', $court->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition duration-200">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3 border border-gray-100">
                                            <i data-lucide="inbox" class="w-6 h-6 text-gray-400"></i>
                                        </div>
                                        <p class="text-gray-500 font-medium text-sm">Belum ada data lapangan</p>
                                        <p class="text-xs text-gray-400 mt-1">Silakan tambah lapangan baru untuk memulai.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection