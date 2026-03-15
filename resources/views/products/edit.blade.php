@extends('layouts.master')
@section('title', 'Edit Produk')
@section('header', 'Edit Produk')
@section('content')
    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden animate-fadeIn">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-pen-to-square text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-white font-semibold text-lg">Edit Produk</h2>
                        <p class="text-blue-100 text-xs">Perbarui informasi produk</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4 group">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                            Nama Produk
                        </label>
                        <div class="relative">
                            <i
                                class="fa-solid fa-tag absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-blue-400 transition text-sm"></i>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                placeholder="Nama produk..."
                                class="w-full border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm
                            focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent
                            transition duration-200 hover:border-blue-300">
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="group">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                                Harga
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs font-medium group-focus-within:text-blue-400 transition">Rp</span>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                    placeholder="0"
                                    class="w-full border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent
                                transition duration-200 hover:border-blue-300">
                            </div>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="group">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                                Stok
                            </label>
                            <div class="relative">
                                <i
                                    class="fa-solid fa-cubes absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-blue-400 transition text-sm"></i>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                    placeholder="0"
                                    class="w-full border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent
                                transition duration-200 hover:border-blue-300">
                            </div>
                            @error('stock')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                            Kategori
                        </label>
                        <div class="relative" x-data="{ open: false, selected: '{{ old('category', $product->category) }}' }">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm
                                    bg-white hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400
                                    transition duration-200">
                                <i class="fa-solid fa-layer-group absolute left-3 text-gray-300 text-sm"
                                    :class="open ? 'text-blue-400' : 'text-gray-300'"></i>
                                <span
                                    x-text="selected ? selected.charAt(0).toUpperCase() + selected.slice(1) : 'Pilih Kategori'"
                                    :class="selected ? 'text-gray-700' : 'text-gray-400'">
                                </span>
                                <i class="fa-solid fa-chevron-down ml-auto text-gray-300 text-xs transition-transform duration-300"
                                    :class="open ? 'rotate-180 text-blue-400' : ''"></i>
                            </button>
                            <input type="hidden" name="category" :value="selected">
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2" @click.outside="open = false"
                                class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200
                                rounded-xl shadow-lg z-20 overflow-hidden origin-top">
                                @foreach (['jajanan', 'minuman', 'atk'] as $cat)
                                    <button type="button" @click="selected = '{{ $cat }}'; open = false"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-left
                                        hover:bg-blue-50 hover:text-blue-600 transition duration-150"
                                        :class="selected === '{{ $cat }}' ? 'bg-blue-50 text-blue-600 font-medium' :
                                            'text-gray-600'">
                                        <i class="fa-solid fa-check text-xs opacity-0 transition"
                                            :class="selected === '{{ $cat }}' ? 'opacity-100' : ''"></i>
                                        {{ ucfirst($cat) }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                            Foto Produk
                        </label>
                        <div class="flex items-center gap-4 mb-3">
                            <div id="imageWrapper"
                                class="w-20 h-20 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden transition duration-300">
                                @if ($product->image)
                                    <img id="preview" src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}" class="w-full h-full object-cover rounded-xl">
                                @else
                                    <img id="preview" class="w-full h-full object-cover hidden">
                                    <i id="previewIcon" class="fa-solid fa-image text-gray-300 text-2xl"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-medium">
                                    {{ $product->image ? 'Gambar saat ini' : 'Belum ada gambar' }}
                                </p>
                                <p class="text-xs text-gray-400">Klik pilih file untuk mengganti</p>
                            </div>
                        </div>
                        <label for="imageInput"
                            class="flex items-center gap-2 border-2 border-dashed border-gray-200 rounded-xl px-4 py-3
                        cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition duration-200 group">
                            <i class="fa-solid fa-upload text-gray-300 group-hover:text-blue-400 transition"></i>
                            <span class="text-sm text-gray-400 group-hover:text-blue-500 transition">
                                Pilih gambar baru...
                            </span>
                            <span id="fileName" class="text-xs text-blue-500 ml-auto hidden"></span>
                        </label>
                        <input id="imageInput" type="file" name="image" accept="image/png, image/jpeg"
                            onchange="previewImage(event)" class="hidden">
                        <p class="text-xs text-gray-400 mt-1.5">Kosongkan jika tidak ingin mengganti. Maks 2MB, format
                            JPG/PNG.</p>

                        @error('image')
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="flex gap-3 pt-2 border-t border-gray-100">
                        <a href="{{ route('products.index') }}"
                            class="flex-1 text-center border border-gray-200 hover:bg-gray-50 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-medium transition duration-200">
                            <i class="fa-solid fa-arrow-left mr-1"></i> Batal
                        </a>
                        <button type="submit"
                            class="flex-1 bg-blue-500 hover:bg-blue-600 active:scale-95 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition duration-200 shadow-md shadow-blue-200">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease both;
        }
    </style>
@endsection

@push('scripts')
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            const preview = document.getElementById('preview');
            const icon = document.getElementById('previewIcon');
            const fileName = document.getElementById('fileName');

            reader.onload = function() {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                if (icon) icon.classList.add('hidden');
                if (fileName) {
                    fileName.textContent = file.name;
                    fileName.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(file);
        }
    </script>
@endpush
