@extends('layouts.admin')

@section('content')
    <div class="w-full space-y-6">

        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-yellow-50 dark:bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 rounded-xl border border-yellow-100 dark:border-yellow-500/20">
                    <i data-lucide="users" class="w-7 h-7 text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-semibold text-gray-800 dark:text-gray-100">Data User</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kelola informasi pelanggan dan kelengkapan profil
                    </p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <!-- SEARCH -->
                <form action="{{ route('admin.users') }}" method="GET" class="relative w-full sm:w-64 group"
                    x-data="{ search: '{{ request('search') }}' }">
                    <input type="text" name="search" x-model="search" @input.debounce.500ms="$el.form.submit()"
                        placeholder="Cari User..."
                        class="w-full pl-9 pr-10 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-all shadow-sm"
                        value="{{ request('search') }}">
                    <i data-lucide="search"
                        class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-yellow-500 transition-colors"></i>

                    <template x-if="search">
                        <button type="button" @click="search = ''; $nextTick(() => $el.form.submit())"
                            class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                        </button>
                    </template>
                </form>

                <div class="hidden sm:flex items-center gap-2">
                    <span
                        class="px-3 py-1.5 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-sm font-medium rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                        Total: <span class="text-gray-900 dark:text-gray-100 font-bold">{{ $users->total() }}</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px] text-sm text-left">
                    <thead
                        class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Kontak</th>
                            <th class="px-6 py-4">Kelengkapan Profil</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-200">
                                <!-- USER -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center font-bold text-yellow-600 shrink-0 border border-yellow-200/50">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">ID:
                                                #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- KONTAK -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1 text-sm text-gray-600 dark:text-gray-300">
                                        <span class="flex items-center gap-1.5"><i data-lucide="mail"
                                                class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500"></i>
                                            {{ $user->email }}</span>
                                        <span class="flex items-center gap-1.5"><i data-lucide="phone"
                                                class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500"></i>
                                            {{ $user->phone ?? 'Belum ada no HP' }}</span>
                                    </div>
                                </td>

                                <!-- PROGRESS -->
                                <td class="px-6 py-4 w-[240px]">
                                    <div class="flex flex-col gap-2">
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-gray-500 dark:text-gray-400 font-medium">Kelengkapan</span>
                                            <span
                                                class="font-bold {{ $user->biodata_completion < 40 ? 'text-red-600 dark:text-red-400' : ($user->biodata_completion < 80 ? 'text-yellow-600 dark:text-yellow-450' : 'text-green-600 dark:text-green-400') }}">
                                                {{ $user->biodata_completion }}%
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
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
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-blue-100 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-transparent dark:border-blue-500/20 rounded-full hover:bg-blue-200 dark:hover:bg-blue-500/20 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Detail
                                        </a>

                                        <form id="delete-user-{{ $user->id }}"
                                            action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete('delete-user-{{ $user->id }}', 'Hapus User?', 'Apakah Anda yakin ingin menghapus user {{ $user->name }} secara permanen?')"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-transparent dark:border-red-500/20 rounded-full hover:bg-red-200 dark:hover:bg-red-500/20 transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-300">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div
                                                        class="w-16 h-16 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4 border border-gray-100 dark:border-gray-600 shadow-sm">
                                                        <i data-lucide="{{ request('search') ? 'search-x' : 'users-x' }}"
                                                            class="w-8 h-8 text-gray-400 dark:text-gray-500"></i>
                                                    </div>
                                                    <h3 class="text-gray-800 dark:text-gray-100 font-bold text-lg">
                                                        {{ request('search') ? 'Data tidak ditemukan' : 'Belum ada user terdaftar' }}
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 mt-1 max-w-xs mx-auto text-sm">
                                                        {{ request('search')
                            ? 'Tidak ada user yang cocok dengan kata kunci "' . request('search') . '". Coba kata kunci lain.'
                            : 'Data pelanggan akan muncul secara otomatis di sini.' }}
                                                    </p>
                                                    @if(request('search'))
                                                        <a href="{{ route('admin.users') }}"
                                                            class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold text-sm rounded-xl transition-all shadow-sm">
                                                            <i data-lucide="refresh-cw" class="w-4 h-4"></i> Reset Pencarian
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                {{ $users->links() }}
            </div>

        </div>
    </div>
@endsection