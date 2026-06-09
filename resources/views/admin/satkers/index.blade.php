<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">🏢 Kelola Satker</h2>
                <p class="text-sm text-gray-500 mt-0.5">Manajemen satuan kerja KPU</p>
            </div>
            <a href="{{ route('admin.satkers.create') }}"
               class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Satker
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Satker</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tingkatan</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Wilayah</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah User</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($satkers as $satker)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 font-semibold text-gray-800">{{ $satker->nama }}</td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $satker->tingkatan === 'pusat' ? 'bg-red-100 text-red-700' : ($satker->tingkatan === 'provinsi' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                                {{ $satker->tingkatan_label }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-gray-600">{{ $satker->wilayah ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <span class="font-semibold text-gray-800">{{ $satker->users_count }}</span>
                            <span class="text-gray-400 text-xs ml-1">user</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $satker->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $satker->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.satkers.edit', $satker) }}"
                                   class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-medium transition">
                                    Edit
                                </a>
                                @if($satker->users_count == 0)
                                    <form action="{{ route('admin.satkers.destroy', $satker) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus satker {{ $satker->nama }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-medium transition">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400">Belum ada satker</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($satkers->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $satkers->links() }}
            </div>
        @endif
    </div>
</x-app-layout>