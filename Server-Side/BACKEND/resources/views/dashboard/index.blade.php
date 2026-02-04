<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow mb-8">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <span class="font-bold text-xl text-blue-800">OSKA Backend</span>
            <div class="flex items-center gap-4">
                <span class="text-gray-600">Halo, {{ Auth::user()->name }}</span>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-600 font-semibold hover:text-red-800">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Manajemen Event</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-blue-100 text-blue-800">
                            <th class="p-3 border-b">Nama Event</th>
                            <th class="p-3 border-b">Tanggal</th>
                            <th class="p-3 border-b">Pengurus</th>
                            <th class="p-3 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border-b">{{ $event->event_name }}</td>
                            <td class="p-3 border-b">{{ $event->event_date }}</td>
                            <td class="p-3 border-b">{{ $event->organizer }}</td>
                            
                            <td class="p-3 border-b">
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE') <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>