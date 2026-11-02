<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['Clean Code', 'Robert C. Martin', 'Prentice Hall', 2008, '9780132350884', 'Panduan menulis kode yang bersih dan mudah dirawat.'],
            ['Laravel: Up & Running', 'Matt Stauffer', "O'Reilly Media", 2019, '9781492041214', 'Pengantar framework Laravel dari dasar hingga praktik.'],
            ['Algoritma dan Pemrograman', 'Rinaldi Munir', 'Informatika Bandung', 2016, '9786021514016', 'Dasar algoritma dan pemrograman terstruktur.'],
            ['Basis Data', 'Abdul Kadir', 'Andi Offset', 2018, '9789792969818', 'Konsep basis data relasional dan SQL.'],
            ['Pemrograman Web dengan PHP dan MySQL', 'Budi Raharjo', 'Informatika Bandung', 2020, '9786026231123', 'Membangun aplikasi web dinamis dengan PHP dan MySQL.'],
            ['Rekayasa Perangkat Lunak', 'Rosa A.S.', 'Informatika Bandung', 2018, '9786026231659', 'Terstruktur dan berorientasi objek.'],
            ['Jaringan Komputer', 'Andrew S. Tanenbaum', 'Pearson', 2011, '9780132126953', 'Prinsip dan arsitektur jaringan komputer.'],
            ['Kecerdasan Buatan', 'Stuart Russell', 'Pearson', 2020, '9780134610993', 'Pendekatan modern dalam kecerdasan buatan.'],
        ];

        foreach ($books as [$judul, $penulis, $penerbit, $tahun, $isbn, $deskripsi]) {
            Book::updateOrCreate(
                ['isbn' => $isbn],
                compact('judul', 'penulis', 'penerbit', 'deskripsi') + ['tahun_terbit' => $tahun]
            );
        }
    }
}
