@extends('layouts.admin')

@section('content')

    <div class="max-w-6xl mx-auto space-y-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-800">
                Data User
            </h1>

            <span class="text-sm text-gray-400">
                Total: {{ $users->total() }} user
            </span>
        </div>

        <!-- CARD -->
        <div class="bg-white rounded-2xl shadow border overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <!-- HEAD -->
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="text-left px-6 py-4">User</th>
                            <th class="text-left px-6 py-4">Email</th>
                            <th class="text-left px-6 py-4">HP</th>
                            <th class="text-left px-6 py-4">Biodata</th>
                            <th class="text-center px-6 py-4">Aksi</th>
                        </tr>
                    </thead>

                    <!-- BODY -->
                    <tbody>
                        @forelse($users as $user)
                                        <tr class="border-t hover:bg-gray-50 transition">

                                            <!-- USER -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">

                                                    <!-- AVATAR -->
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center font-bold text-gray-900">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>

                                                    <div>
                                                        <p class="font-semibold text-gray-800">
                                                            {{ $user->name }}
                                                        </p>
                                                        <p class="text-xs text-gray-400">
                                                            ID: {{ $user->id }}
                                                        </p>
                                                    </div>

                                                </div>
                                            </td>

                                            <!-- EMAIL -->
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $user->email }}
                                            </td>

                                            <!-- PHONE -->
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $user->phone ?? '-' }}
                                            </td>

                                            <!-- PROGRESS -->
                                            <td class="px-6 py-4 w-56">

                                                <div class="space-y-1">
                                                    <div class="flex justify-between text-xs">
                                                        <span class="text-gray-500">Kelengkapan</span>
                                                        <span class="font-medium">
                                                            {{ $user->biodata_completion }}%
                                                        </span>
                                                    </div>

                                                    <!-- PROGRESS BAR -->
                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="h-2 rounded-full transition-all
                                                                                    {{ $user->biodata_completion < 40 ? 'bg-red-400' :
                            ($user->biodata_completion < 80 ? 'bg-yellow-400' : 'bg-green-500') }}"
                                                            style="width: {{ $user->biodata_completion }}%">
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>

                                            <!-- ACTION -->
                                            <td class="px-6 py-4 text-center">

                                                <div class="flex justify-center gap-2">

                                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                                        class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200">
                                                        Detail
                                                    </a>

                                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button onclick="return confirm('Yakin hapus user?')"
                                                            class="px-3 py-1 text-xs bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                                            Hapus
                                                        </button>
                                                    </form>

                                                </div>

                                            </td>

                                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-400">
                                    Belum ada user
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- PAGINATION -->
            <div class="p-4 border-t">
                {{ $users->links() }}
            </div>

        </div>

    </div>

@endsection