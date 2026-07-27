@extends('layouts.app')

@section('title', 'User - POS')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Manajemen User</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola akun pengguna sistem POS</p>
        </div>
        <a href="{{ url('/user/create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition shadow-sm shadow-indigo-200">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Tambah User
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-6 py-3.5 font-semibold text-slate-600 w-12">#</th>
                        <th class="text-left px-6 py-3.5 font-semibold text-slate-600">Nama</th>
                        <th class="text-left px-6 py-3.5 font-semibold text-slate-600">Email</th>
                        <th class="text-left px-6 py-3.5 font-semibold text-slate-600">Role</th>
                        <th class="text-right px-6 py-3.5 font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users ?? [] as $index => $user)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="px-6 py-4 text-slate-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-sm font-semibold">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @php $role = $user->role ?? $user->roles->first()->name ?? 'User'; @endphp
                            @if(strtolower($role) === 'admin')
                                <span class="inline-flex px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">Admin</span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">{{ $role }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ url('/user/'.$user->id.'/edit') }}"
                                   class="p-2 rounded-lg text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                @if(Auth::id() !== $user->id)
                                <form action="{{ url('/user/'.$user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                    <i data-lucide="users" class="w-7 h-7 text-slate-400"></i>
                                </div>
                                <p class="text-sm font-medium text-slate-600">Belum ada user</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection