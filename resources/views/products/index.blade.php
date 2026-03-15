@extends('layouts.master')
@section('title', 'Produk')
@section('header', 'Data Produk')
@section('content')
<div class="bg-white rounded-xl shadow p-5">

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
    <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative" x-data="{ open: false }">
            <button
                type="button"
                @click="open = !open"
                class="appearance-none border rounded-lg pl-4 pr-10 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 flex items-center gap-2 min-w-[150px]">
                <span id="selectedCategory">Semua Kategori</span>
                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs transition-transform duration-300"
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
                class="absolute top-full left-0 mt-1 w-48 bg-white border rounded-lg shadow-lg z-20 overflow-hidden origin-top">
                @foreach(['Semua Kategori', 'Jajanan', 'Minuman', 'ATK'] as $cat)
                    <button
                        type="button"
                        onclick="selectCategory('{{ $cat }}')"
                        @click="open = false"
                        class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
        </div>
        <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input
                type="text"
                placeholder="Cari produk..."
                class="border rounded-lg pl-9 pr-4 py-2 text-sm w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
    </div>
    <button onclick="openModal()"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition w-full sm:w-auto justify-center">
        <i class="fa-solid fa-plus"></i> Tambah Produk
    </button>
</div>
<div class="overflow-x-auto">
    <table class="w-full text-sm min-w-[700px]">
        <thead>
            <tr class="bg-gray-300 text-gray-700 text-center">
                <th class="px-4 py-3 font-semibold text-left w-14">No</th>
                <th class="px-4 py-3 font-semibold w-20">Foto</th>
                <th class="px-4 py-3 font-semibold text-left w-48">Nama Barang</th>
                <th class="px-4 py-3 font-semibold w-32">Kategori</th>
                <th class="px-4 py-3 font-semibold w-32">Harga Jual</th>
                <th class="px-4 py-3 font-semibold w-28">Stok</th>
                <th class="px-4 py-3 font-semibold w-36">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $index => $product)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition text-center">
                    <td class="px-4 py-3 text-left text-gray-600">{{ $index + 1 }}.</td>
                    <td class="px-4 py-3">
                        <div class="w-12 h-12 mx-auto rounded bg-gray-100 flex items-center justify-center overflow-hidden">
                            <img
                                src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/default.png') }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full mix-blend-multiply">
                        </div>
                    </td>
                    <td class="px-4 py-3 text-left font-medium text-gray-800">{{ $product->name }}</td>
                    <td class="px-4 py-3 text-gray-600 capitalize">{{ $product->category }}</td>
                    <td class="px-4 py-3 text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $product->stock }} PCS</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-1.5 rounded text-xs font-medium transition">
                                Edit
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    onclick="return confirm('Hapus produk ini?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded text-xs font-medium transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-gray-400">
                        <i class="fa-solid fa-box-open text-4xl mb-3 block"></i>
                        Belum ada produk tersedia.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="modalProduk" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50"
    onclick="closeModal(event)">
    <div id="modalContent"
        class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 p-6 transform scale-90 opacity-0 transition duration-200">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Tambah Produk</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="text-sm text-gray-600 block mb-1">Nama Produk</label>
                <input type="text" name="name"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-3">
                <label class="text-sm text-gray-600 block mb-1">Harga</label>
                <input type="number" name="price"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-3">
                <label class="text-sm text-gray-600 block mb-1">Stok</label>
                <input type="number" name="stock"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-3">
                <label class="text-sm text-gray-600 block mb-1">Kategori</label>
                <select name="category"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Pilih kategori</option>
                    <option value="jajanan">Jajanan</option>
                    <option value="minuman">Minuman</option>
                    <option value="atk">ATK</option>
                </select>
            </div>
            <div class="mb-5">
                <label class="text-sm text-gray-600 block mb-1">Foto Produk</label>
                <input type="file" name="image" accept="image/png, image/jpeg"
                    onchange="previewImage(event)"
                    class="w-full border rounded-lg px-3 py-2 text-sm">
                <img id="preview" class="mt-3 w-20 h-20 object-cover hidden rounded-lg">
                <p class="text-xs text-gray-400 mt-1">Maksimal 2MB. Format JPG / PNG</p>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition">
                    Batal
                </button>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition">
                    Simpan
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
</script>
@endpush
