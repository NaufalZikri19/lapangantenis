@extends('layouts.admin')

@section('content')
<div class="w-full space-y-6">

    <!-- HEADER SECTION -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-yellow-50 text-yellow-600 rounded-xl border border-yellow-100">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Data User</h1>
                <p class="text-sm text-gray-500">Kelola informasi pelanggan dan kelengkapan profil</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 bg-white text-gray-600 text-sm font-medium rounded-lg border border-gray-200 shadow-sm">
                Total: <span class="text-gray-900 font-bold">{{ $users->total() }}</span> user
            </span>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Kelengkapan Profil</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <!-- USER -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center font-bold text-yellow-600 shrink-0 border border-yellow-200/50">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- KONTAK -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1 text-sm text-gray-600">
                                    <span class="flex items-center gap-1.5"><i data-lucide="mail" class="w-3.5 h-3.5 text-gray-400"></i> {{ $user->email }}</span>
                                    <span class="flex items-center gap-1.5"><i data-lucide="phone" class="w-3.5 h-3.5 text-gray-400"></i> {{ $user->phone ?? 'Belum ada no HP' }}</span>
                                </div>
                            </td>

                            <!-- PROGRESS -->
                            <td class="px-6 py-4 w-[240px]">
                                <div class="flex flex-col gap-2">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-gray-500 font-medium">Kelengkapan</span>
                                        <span class="font-bold {{ $user->biodata_completion < 40 ? 'text-red-600' : ($user->biodata_completion < 80 ? 'text-yellow-600' : 'text-green-600') }}">
                                            {{ $user->biodata_completion }}%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500 ease-out {{ $user->biodata_completion < 40 ? 'bg-red-500' : ($user->biodata_completion < 80 ? 'bg-yellow-400' : 'bg-green-500') }}"
                                            style="width: {{ $user->biodata_completion }}%">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- ACTION -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> Detail
                                    </a>

                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Apakah Anda yakin ingin menghapus user ini secara permanen?')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-red-100 text-red-600 rounded-full hover:bg-red-200 transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-300">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3 border border-gray-100">
                                        <i data-lucide="users-x" class="w-6 h-6 text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium text-sm">Belum ada user terdaftar</p>
                                    <p class="text-xs text-gray-400 mt-1">Data pelanggan akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="p-4 border-t border-gray-100 bg-gray-50/50">
            {{ $users->links() }}
        </div>

    </div>
</div>
@endsection