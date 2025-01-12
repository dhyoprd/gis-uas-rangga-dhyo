<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GIS Application') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4lKVb0eLSNyhEO-C_8JoHhAvba6aZc3U&libraries=places">
    </script>

    <!-- External JavaScript -->
    <script src="{{ asset('assets/js/script.js') }}" defer></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- For Leaflet Routing -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

</head>

<body
    class="font-sans antialiased bg-cover bg-center bg-fixed bg-no-repeat text-white bg-gradient-to-r from-amber-300 to-orange-600"
    style="background-image:
    url('{{ asset('assets/image/background.jpg') }}')">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <a href="#home-section" class="mt-4">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-2xl font-bold text-white">ॐ Pulau Seribu Pura</span>
                        </div>
                    </a>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex md:items-center md:space-x-6">
                        <a href="#" onclick="openModal(event)"
                            class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Pura
                        </a>
                        <a href="#maps-section"
                            class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            View Maps
                        </a>
                        <a href="#table-section"
                            class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            View Table
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button type="button"
                            class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-gray-800/90">
                    <a href="#" onclick="openModal(event)"
                        class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Pura
                    </a>
                    <a href="#"
                        class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        View Maps
                    </a>
                    <a href="#"
                        class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        View Table
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="min-h-screen">
            <div class="relative pt-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20">
                    <div class="text-center" id="#home-section">
                        <h1 class="text-4xl tracking-tight font-extrabold sm:text-5xl md:text-6xl font-playfair">
                            <span class="block">Tugas Akhir</span>
                            <span class="block text-gray-200">Sistem Informasi Geografis</span>
                        </h1>
                        <p
                            class="mt-3 max-w-md mx-auto text-base text-gray-200 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                            Tugas ini disusun berdasarkan ide dari mahasiswa Teknik Elektro Universitas Udayana yang
                            sedang galau memikirkan gebetannya yang hilang saat tirta yatra menuju semua Pura yang ada
                            di Bali
                        </p>
                    </div>
                </div>

                <!-- Audio Player Section -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
                    <div class="mx-8 backdrop-blur-sm rounded-2xl p-8">
                        <div class="text-center mb-4">
                            <span class="font-playfair text-xl font-bold">Lagu Enak 😜🤙</span>
                            <p class="text-sm text-gray-300 mt-1">Voc : Putu Tiara, Cipt : DeOka, S , Arr : Mang Gita
                            </p>
                        </div>
                        <div class="flex items-center justify-center">
                            <audio controls class="w-full">
                                <source src="{{ asset('assets/audio/gamelan.mp3') }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                </div>

                <!-- Map Sections -->
                <div class="py-12 mt-10" id="maps-section">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Leaflet Map Section -->
                            <div>
                                <div class="lg:text-center mb-8">
                                    <h2 class="text-base font-semibold tracking-wide uppercase">OpenStreetMap</h2>
                                    <p
                                        class="mt-2 text-3xl leading-8 font-extrabold tracking-tight sm:text-4xl font-playfair">
                                        Leaflet Map View
                                    </p>
                                </div>
                                <div id="leafletMap" class="h-[500px] rounded-lg bg-white/10 backdrop-blur-sm p-4">
                                </div>
                            </div>

                            <!-- Google Map Section -->
                            <div>
                                <div class="lg:text-center mb-8">
                                    <h2 class="text-base font-semibold tracking-wide uppercase">Google Maps</h2>
                                    <p
                                        class="mt-2 text-3xl leading-8 font-extrabold tracking-tight sm:text-4xl font-playfair">
                                        Google Map View
                                    </p>
                                </div>
                                <div id="googleMap" class="h-[500px] rounded-lg bg-white/10 backdrop-blur-sm p-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <div class="max-w-4xl mx-auto backdrop-blur-sm rounded-3xl shadow-lg p-8 mb-8">
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Starting Point Section -->
        <div class="space-y-4 md:col-span-2">
            <h3 class="text-2xl font-semibold rainbow-text text-center">Set Starting Point</h3>
            <button id="get-current-location"
                class="w-full bg-green-400 text-white font-medium px-6 py-3 rounded-full shadow-lg flex items-center justify-center space-x-2">
                <i class="fas fa-location-arrow"></i>
                <span>Lokasi Saya</span>
            </button>
            <div class="flex space-x-2 text-black">
                <input type="text" id="start-location"
                    class="flex-1 px-4 py-2 rounded-full border-2 focus:ring-2 focus:ring-purple-200 transition duration-300"
                    placeholder="Enter starting point">
                <button id="set-manual-location"
                    class="bg-red-400 text-black px-6 py-2 rounded-full shadow-lg transition duration-300">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>

        
    </div>
    </div>

    <!-- Table Section -->
    <div class="py-12" id="#table-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-black/20 backdrop-blur-sm rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">
                                    Nama Pura
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">
                                    Alamat
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">
                                    Tahun Dibuat
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">
                                    Latitude
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">
                                    Longitude
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">
                                    Foto
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($puras as $pura)
                                <tr class="hover:bg-white/5">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ $pura->nama }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-white">
                                        {{ $pura->alamat }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ $pura->tahun_dibuat }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ $pura->latitude }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        {{ $pura->longitude }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        <img src="{{ $pura->foto }}" alt="{{ $pura->nama }}"
                                            class="h-16 w-16 object-cover rounded">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                        <div class="flex space-x-2">
                                            <button onclick="editPura({{ $pura->id }})"
                                                class="text-blue-400 hover:text-blue-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form
                                                onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                                action="{{ route('pura.destroy', $pura) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-white">
                                        Tidak ada data pura yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div id="puraModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 overflow-y-auto">
        <div class="min-h-screen px-4 text-center">
            <!-- Background overlay -->
            <div class="fixed inset-0" onclick="closeModal()"></div>

            <!-- Modal panel -->
            <div
                class="inline-block w-full max-w-xl p-6 my-8 text-left align-middle bg-gray-900 rounded-2xl shadow-xl transform transition-all relative">
                <button onclick="closeModal()"
                    class="absolute right-4 top-4 text-white/60 hover:text-white transition-colors">
                    <span class="text-2xl">&times;</span>
                </button>

                <h3 class="text-2xl font-bold text-white font-playfair mb-6">
                    Tambah Pura Baru
                </h3>

                <form id="puraForm" action="{{ route('pura.store') }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Nama Pura -->
                    <div>
                        <label for="namaPura" class="block text-sm font-medium text-white mb-2">
                            Nama Pura
                        </label>
                        <input type="text" id="namaPura" name="namaPura" required
                            class="w-full rounded-lg bg-white/5 border border-white/10 px-4 py-2.5 text-white focus:border-white focus:ring-0 transition-colors">
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-white mb-2">
                            Alamat
                        </label>
                        <textarea id="alamat" name="alamat" rows="3" required
                            class="w-full rounded-lg bg-white/5 border border-white/10 px-4 py-2.5 text-white focus:border-white focus:ring-0 transition-colors"></textarea>
                    </div>

                    <!-- Tahun -->
                    <div>
                        <label for="tahun" class="block text-sm font-medium text-white mb-2">
                            Tahun Dibuat
                        </label>
                        <input type="number" id="tahun" name="tahun" required
                            class="w-full rounded-lg bg-white/5 border border-white/10 px-4 py-2.5 text-white focus:border-white focus:ring-0 transition-colors">
                    </div>

                    <!-- Coordinates -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-white mb-2">
                                Latitude
                            </label>
                            <input type="number" id="latitude" name="latitude" step="any" required
                                class="w-full rounded-lg bg-white/5 border border-white/10 px-4 py-2.5 text-white focus:border-white focus:ring-0 transition-colors">
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-medium text-white mb-2">
                                Longitude
                            </label>
                            <input type="number" id="longitude" name="longitude" step="any" required
                                class="w-full rounded-lg bg-white/5 border border-white/10 px-4 py-2.5 text-white focus:border-white focus:ring-0 transition-colors">
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-white mb-2">
                            Foto Pura
                        </label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-white/10 border-dashed rounded-lg hover:border-white/30 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400">
                                    <label for="fotoPura"
                                        class="relative cursor-pointer rounded-md font-medium text-white hover:text-white/80">
                                        <span id="fileLabel">Upload a file</span>
                                        <input id="fotoPura" name="fotoPura" type="file" class="sr-only"
                                            required accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-400">PNG, JPG up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-white rounded-lg text-sm font-medium text-white hover:bg-white hover:text-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-colors">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 overflow-y-auto">
        <div class="min-h-screen px-4 text-center">
            <div class="fixed inset-0" onclick="closeEditModal()"></div>

            <div
                class="inline-block w-full max-w-xl p-6 my-8 text-left align-middle bg-gray-900 rounded-2xl shadow-xl transform transition-all relative">
                <button onclick="closeEditModal()"
                    class="absolute right-4 top-4 text-white/60 hover:text-white transition-colors">
                    <span class="text-2xl">&times;</span>
                </button>

                <h3 class="text-2xl font-bold text-white font-playfair mb-6">
                    Edit Pura
                </h3>

                <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <!-- Same form fields as add modal, but with id prefix "edit_" -->
                    <div>
                        <label for="edit_namaPura" class="block text-sm font-medium text-white mb-2">Nama
                            Pura</label>
                        <input type="text" id="edit_namaPura" name="namaPura" required
                            class="w-full rounded-lg bg-white/5 border border-white/10 px-4 py-2.5 text-white focus:border-white focus:ring-0 transition-colors">
                    </div>

                    <div>
                        <label for="edit_alamat" class="block text-sm font-medium text-white mb-2">Alamat</label>
                        <textarea id="edit_alamat" name="alamat" rows="3" required
                            class="w-full rounded-lg bg-white/5 border border-white/10 px-4 py-2.5 text-white focus:border-white focus:ring-0 transition-colors"></textarea>
                    </div>

                    <div>
                        <label for="edit_tahun" class="block text-sm font-medium text-white mb-2">Tahun
                            Dibuat</label>
                        <input type="number" id="edit_tahun" name="tahun" required
                            class="w-full rounded-lg bg-white/5 border border-white/10 px-4 py-2.5 text-white focus:border-white focus:ring-0 transition-colors">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="edit_latitude"
                                class="block text-sm font-medium text-white mb-2">Latitude</label>
                            <input type="number" id="edit_latitude" name="latitude" step="any" required
                                class="w-full rounded-lg bg-white/5 border border-white/10 px-4 py-2.5 text-white focus:border-white focus:ring-0 transition-colors">
                        </div>
                        <div>
                            <label for="edit_longitude"
                                class="block text-sm font-medium text-white mb-2">Longitude</label>
                            <input type="number" id="edit_longitude" name="longitude" step="any" required
                                class="w-full rounded-lg bg-white/5 border border-white/10 px-4 py-2.5 text-white focus:border-white focus:ring-0 transition-colors">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-white mb-2">Foto Pura</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-white/10 border-dashed rounded-lg hover:border-white/30 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400">
                                    <label for="edit_fotoPura"
                                        class="relative cursor-pointer rounded-md font-medium text-white hover:text-white/80">
                                        <span id="edit_fileLabel">Upload a file</span>
                                        <input id="edit_fotoPura" name="fotoPura" type="file" class="sr-only"
                                            accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-400">PNG, JPG up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-white rounded-lg text-sm font-medium text-white hover:bg-white hover:text-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-colors">
                            Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-black/30 backdrop-blur-sm mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-200">
                &copy; {{ date('Y') }} Tugas Akhir Sistem Informasi Geografis.
                <span class="text-white">Disusun dengan cinta oleh Dhyo dan Rangga❤︎.</span>
            </div>
        </div>
    </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/script.js') }}"></script>
</body>

<!-- Scripts -->
<script src="{{ asset('assets/script.js') }}"></script>

</html>
