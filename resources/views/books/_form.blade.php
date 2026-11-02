@php($book = $book ?? null)

<div class="space-y-6">
    <!-- Judul & Penulis (Desktop 2 cols) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Judul -->
        <div>
            <x-input-label for="judul" value="Judul Buku *" />
            <x-text-input
                id="judul"
                name="judul"
                type="text"
                class="block w-full"
                :value="old('judul', $book?->judul)"
                required
                autofocus
                placeholder="Contoh: Struktur Data dan Algoritma"
            />
            <p class="text-[11px] text-ink-subtle mt-1">Judul lengkap buku beserta edisi atau volume bila ada.</p>
            <x-input-error :messages="$errors->get('judul')" class="mt-1.5" />
        </div>

        <!-- Penulis -->
        <div>
            <x-input-label for="penulis" value="Nama Penulis *" />
            <x-text-input
                id="penulis"
                name="penulis"
                type="text"
                class="block w-full"
                :value="old('penulis', $book?->penulis)"
                required
                placeholder="Contoh: Robert C. Martin"
            />
            <p class="text-[11px] text-ink-subtle mt-1">Gunakan koma jika terdapat lebih dari satu penulis.</p>
            <x-input-error :messages="$errors->get('penulis')" class="mt-1.5" />
        </div>
    </div>

    <!-- Penerbit, Tahun Terbit & ISBN -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Penerbit -->
        <div>
            <x-input-label for="penerbit" value="Penerbit" />
            <x-text-input
                id="penerbit"
                name="penerbit"
                type="text"
                class="block w-full"
                :value="old('penerbit', $book?->penerbit)"
                placeholder="Contoh: Andi Publisher"
            />
            <p class="text-[11px] text-ink-subtle mt-1">Nama perusahaan atau institusi penerbit.</p>
            <x-input-error :messages="$errors->get('penerbit')" class="mt-1.5" />
        </div>

        <!-- Tahun Terbit -->
        <div>
            <x-input-label for="tahun_terbit" value="Tahun Terbit" />
            <x-text-input
                id="tahun_terbit"
                name="tahun_terbit"
                type="number"
                class="block w-full"
                :value="old('tahun_terbit', $book?->tahun_terbit)"
                placeholder="Contoh: 2024"
                min="1000"
                max="{{ date('Y') + 1 }}"
            />
            <p class="text-[11px] text-ink-subtle mt-1">Tahun publikasi edisi ini.</p>
            <x-input-error :messages="$errors->get('tahun_terbit')" class="mt-1.5" />
        </div>

        <!-- ISBN -->
        <div>
            <x-input-label for="isbn" value="Nomor ISBN" />
            <x-text-input
                id="isbn"
                name="isbn"
                type="text"
                class="block w-full font-mono"
                :value="old('isbn', $book?->isbn)"
                placeholder="Contoh: 9781234567890"
            />
            <p class="text-[11px] text-ink-subtle mt-1">10 atau 13 digit angka standar ISBN.</p>
            <x-input-error :messages="$errors->get('isbn')" class="mt-1.5" />
        </div>
    </div>

    <!-- Deskripsi -->
    <div>
        <x-input-label for="deskripsi" value="Sinopsis / Deskripsi Buku" />
        <textarea
            id="deskripsi"
            name="deskripsi"
            rows="5"
            placeholder="Tuliskan ringkasan isi buku, target pembaca, atau catatan khusus..."
            class="block w-full bg-white border border-line text-ink placeholder:text-ink-subtle text-sm rounded-[6px] shadow-sm transition-colors duration-150 focus:border-brand focus:ring-2 focus:ring-brand/20 p-3"
        >{{ old('deskripsi', $book?->deskripsi) }}</textarea>
        <p class="text-[11px] text-ink-subtle mt-1">Opsional, deskripsi membantu mahasiswa menemukan topik yang relevan.</p>
        <x-input-error :messages="$errors->get('deskripsi')" class="mt-1.5" />
    </div>
</div>
