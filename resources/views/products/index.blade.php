@extends('layouts.master')
@section('title', 'Produk')
@section('header', 'Data Produk')
@section('content')

{{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
    <div>
        <h2 class="text-lg font-bold text-gray-800">Daftar Produk</h2>
        <p class="text-xs text-gray-400 mt-0.5">Kelola semua produk koperasi</p>
    </div>
    <button onclick="openModal()"
        class="bg-sky-400 hover:bg-sky-500 active:scale-95 text-white px-5 py-2.5
        rounded-xl text-sm font-medium flex items-center gap-2 transition
        w-full sm:w-auto justify-center shadow-sm">
        <i class="fa-solid fa-plus text-xs"></i> Tambah Produk
    </button>
</div>

{{-- FILTER --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-4">
    <div class="flex flex-col sm:flex-row gap-3 sm:items-center">

        {{-- DROPDOWN KATEGORI --}}
        <div class="relative" x-data="{ open: false }">
            <button
                type="button"
                @click="open = !open"
                class="flex items-center gap-2 border border-gray-200 rounded-xl pl-4 pr-10 py-2.5
                text-sm bg-white hover:border-sky-400 focus:outline-none focus:ring-2
                focus:ring-sky-400 transition w-full sm:w-44">
                <span id="selectedCategory">{{ request('category') ?? 'Semua Kategori' }}</span>
                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2
                    text-gray-300 text-xs transition-transform duration-300"
                    :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                @click.outside="open = false"
                class="absolute top-full left-0 mt-2 w-full sm:w-44 bg-white border border-gray-100
                rounded-xl shadow-lg z-20 overflow-hidden origin-top">
                @foreach(['Semua Kategori', 'Jajanan', 'Minuman', 'ATK'] as $cat)
                    <button
                        type="button"
                        onclick="selectCategory('{{ $cat }}')"
                        @click="open = false"
                        class="w-full text-left px-4 py-2.5 text-sm text-gray-600
                        hover:bg-sky-50 hover:text-sky-600 transition flex items-center gap-2">
                        <i class="fa-solid fa-check text-xs text-sky-400
                            {{ request('category') == $cat ? 'opacity-100' : 'opacity-0' }}"></i>
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- SEARCH --}}
        <div class="relative flex-1 sm:max-w-xs">
            <form method="GET" action="{{ route('products.index') }}">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2
                    -translate-y-1/2 text-gray-300 text-xs"></i>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    class="w-full border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm
                    hover:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-400 transition">
            </form>
        </div>

        {{-- TOTAL PRODUK --}}
        <div class="sm:ml-auto flex items-center gap-2 text-semibold text-gray-400">
            <span>{{ $products->count() }} produk</span>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50 text-gray-400 text-xs uppercase tracking-wide">
                    <th class="px-5 py-4 text-center font-semibold" style="width: 50px;">No</th>
                    <th class="px-5 py-4 text-center font-semibold" style="width: 70px;">Foto</th>
                    <th class="px-5 py-4 text-center font-semibold" style="width: 90px">Nama Produk</th>
                    <th class="px-5 py-4 text-center font-semibold" style="width: 110px;">Kategori</th>
                    <th class="px-5 py-4 text-center font-semibold" style="width: 120px;">Harga</th>
                    <th class="px-5 py-4 text-center font-semibold" style="width: 100px;">Stok</th>
                    <th class="px-5 py-4 text-center font-semibold" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($products as $index => $product)
                    <tr class="hover:bg-sky-50/30 transition duration-150">
                        <td class="px-5 py-4 text-center text-gray-400 text-xs" style="vertical-align: middle;">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-5 py-4" style="vertical-align: middle;">
                            <div class="w-11 h-11 mx-auto rounded-xl
                                flex items-center justify-center overflow-hidden">
                                <img
                                    src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.png') }}"
                                    alt="{{ $product->name }}"
                                    style="max-width: 38px; max-height: 38px; object-fit: contain;"
                                >
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center" style="vertical-align: middle;">
                            <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                        </td>
                        <td class="px-5 py-4 text-center" style="vertical-align: middle;">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-semibold font-medium
                                @if(strtolower($product->category) == 'jajanan')
                                @elseif(strtolower($product->category) == 'minuman')
                                @elseif(strtolower($product->category) == 'atk')
                                @else bg-gray-100 text-gray-500 @endif">
                                {{ ucfirst($product->category) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center font-semibold text-gray-800" style="vertical-align: middle;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4 text-center" style="vertical-align: middle;">
                            @if($product->stock == 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                    font-medium bg-red-50 text-red-500">Habis</span>
                            @elseif($product->stock <= 5)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                    font-medium bg-yellow-50 text-yellow-600">{{ $product->stock }} PCS</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs
                                    font-medium bg-green-50 text-green-600">{{ $product->stock }} PCS</span>
                            @endif
                        </td>
                        <td class="px-5 py-4" style="vertical-align: middle;">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="inline-flex items-center gap-1.5 bg-sky-400 hover:bg-sky-500
                                    active:scale-95 text-white px-3.5 py-1.5 rounded-lg text-xs
                                    font-medium transition">
                                    <i class="fa-solid fa-pen text-xs"></i> Edit
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        onclick="return confirm('Hapus produk ini?')"
                                        class="inline-flex items-center gap-1.5 border border-red-200
                                        bg-red-50 hover:bg-red-500 text-red-500 hover:text-white
                                        active:scale-95 px-3.5 py-1.5 rounded-lg text-xs font-medium transition">
                                        <i class="fa-solid fa-trash text-xs"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-16 text-gray-400">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                    <i class="fa-solid fa-box-open text-2xl text-gray-300"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-500 text-sm">Belum ada produk</p>
                                    <p class="text-xs text-gray-400 mt-1">Tambahkan produk pertama kamu</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH PRODUK --}}
<div id="modalProduk"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50 px-4"
    onclick="closeModal(event)">
    <div id="modalContent"
        class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6
        transform scale-90 opacity-0 transition duration-200 max-h-[90vh] overflow-y-auto">

        {{-- HEADER MODAL --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-base font-bold text-gray-800">Tambah Produk</h2>
                <p class="text-xs text-gray-400 mt-0.5">Isi informasi produk baru</p>
            </div>
            <button type="button" onclick="closeModalBtn()"
                class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center
                justify-center text-gray-500 transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                        Nama Produk
                    </label>
                    <input type="text" name="name" placeholder="Nama produk..."
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                            Harga
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">Rp</span>
                            <input type="number" name="price" placeholder="0"
                                class="w-full border border-gray-200 rounded-xl pl-9 pr-3 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                            Stok
                        </label>
                        <input type="number" name="stock" placeholder="0"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                            focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                        Kategori
                    </label>
                    <select name="category"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-sky-400 hover:border-sky-300 transition bg-white">
                        <option value="">Pilih kategori</option>
                        <option value="jajanan">Jajanan</option>
                        <option value="minuman">Minuman</option>
                        <option value="atk">ATK</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">
                        Foto Produk
                    </label>
                    <label for="fotoInput"
                        class="flex flex-col items-center justify-center border-2 border-dashed
                        border-gray-200 rounded-xl p-5 cursor-pointer hover:border-sky-400
                        hover:bg-sky-50 transition group">
                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-300
                            group-hover:text-sky-400 transition mb-2"></i>
                        <p class="text-sm text-gray-400 group-hover:text-sky-500 transition">
                            Klik untuk upload foto
                        </p>
                        <p class="text-xs text-gray-300 mt-1">JPG, PNG maks. 2MB</p>
                    </label>
                    <input id="fotoInput" type="file" name="image" accept="image/png, image/jpeg"
                        onchange="previewImage(event)" class="hidden">
                    <img id="preview" class="mt-3 w-20 h-20 object-contain hidden rounded-xl border">
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModalBtn()"
                    class="flex-1 border border-gray-200 hover:bg-gray-50 text-gray-600 py-2.5
                    rounded-xl text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 bg-sky-400 hover:bg-sky-500 active:scale-95 text-white py-2.5
                    rounded-xl text-sm font-medium transition shadow-sm">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal() {
        const modal = document.getElementById('modalProduk');
        const content = document.getElementById('modalContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            content.classList.remove('scale-90', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal(e) {
        if (e && e.target.id !== 'modalProduk') return;
        _tutupModal();
    }

    function closeModalBtn() {
        _tutupModal();
    }

    function _tutupModal() {
        const modal = document.getElementById('modalProduk');
        const content = document.getElementById('modalContent');
        content.classList.add('scale-90', 'opacity-0');
        content.classList.remove('scale-100', 'opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }

    function previewImage(event) {
        const reader = new FileReader();
        const preview = document.getElementById('preview');
        reader.onload = function () {
            preview.src = reader.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function selectCategory(category) {
        document.getElementById("selectedCategory").innerText = category;
        let url = new URL(window.location.href);
        if (category === "Semua Kategori") {
            url.searchParams.delete("category");
        } else {
            url.searchParams.set("category", category);
        }
        window.location.href = url;
    }
</script>
@endpush
