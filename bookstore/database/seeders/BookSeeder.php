<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 * Mengisi data awal buku beserta berkas gambar sampulnya.
 *
 * Seluruh buku pada data awal ini merupakan karya milik publik (public domain)
 * dengan gambar sampul dari katalog Project Gutenberg, sehingga aman dipakai
 * tanpa melanggar hak cipta.
 */
class BookSeeder extends Seeder
{
    /**
     * Data buku bawaan aplikasi.
     *
     * @var array<int, array<string, mixed>>
     */
    private const BOOKS = [
        [
            'category' => 'fiksi-sastra',
            'slug' => 'pride-and-prejudice',
            'title' => 'Pride and Prejudice',
            'author' => 'Jane Austen',
            'published_year' => 1813,
            'price' => 95000,
            'stock' => 12,
            'description' => 'Kisah Elizabeth Bennet dan Tuan Darcy yang menghadapi tekanan sosial pada abad ke-19. Novel ini terkenal karena sindirannya yang halus terhadap kebiasaan masyarakat Inggris.',
        ],
        [
            'category' => 'fiksi-sastra',
            'slug' => 'frankenstein',
            'title' => 'Frankenstein; or, The Modern Prometheus',
            'author' => 'Mary Wollstonecraft Shelley',
            'published_year' => 1818,
            'price' => 110000,
            'stock' => 8,
            'description' => 'Kisah Victor Frankenstein yang berhasil menghidupkan makhluk buatannya. Novel ini menjadi salah satu karya awal aliran fiksi ilmiah dan horor.',
        ],
        [
            'category' => 'fiksi-sastra',
            'slug' => 'dracula',
            'title' => 'Dracula',
            'author' => 'Bram Stoker',
            'published_year' => 1897,
            'price' => 105000,
            'stock' => 10,
            'description' => 'Kisah Tuan Dracula yang berusaha pindah dari Transylvania ke Inggris. Cerita ini disampaikan melalui surat dan catatan harian para tokohnya.',
        ],
        [
            'category' => 'fiksi-sastra',
            'slug' => 'the-picture-of-dorian-gray',
            'title' => 'The Picture of Dorian Gray',
            'author' => 'Oscar Wilde',
            'published_year' => 1890,
            'price' => 98000,
            'stock' => 9,
            'description' => 'Seorang pemuda tetap awet muda sementara lukisan dirinya menua menanggung segala perbuatannya. Novel ini membahas keindahan, moral, dan kesombongan.',
        ],
        [
            'category' => 'sastra-klasik',
            'slug' => 'great-expectations',
            'title' => 'Great Expectations',
            'author' => 'Charles Dickens',
            'published_year' => 1861,
            'price' => 102000,
            'stock' => 7,
            'description' => 'Perjalanan hidup Pip, anak yatim yang berharap menjadi bangsawan. Dickens mengangkat tema kelas sosial dan keadilan melalui kisah ini.',
        ],
        [
            'category' => 'sastra-klasik',
            'slug' => 'a-tale-of-two-cities',
            'title' => 'A Tale of Two Cities',
            'author' => 'Charles Dickens',
            'published_year' => 1859,
            'price' => 99000,
            'stock' => 6,
            'description' => 'Kisah yang berlatar kota London dan Paris menjelang Revolusi Prancis. Novel ini menggambarkan pengorbanan dan cinta pada masa penuh gejolak.',
        ],
        [
            'category' => 'sastra-klasik',
            'slug' => 'anne-of-green-gables',
            'title' => 'Anne of Green Gables',
            'author' => 'L. M. Montgomery',
            'published_year' => 1908,
            'price' => 88000,
            'stock' => 14,
            'description' => 'Anne Shirley, gadis yatim yang penuh imajinasi, diadopsi oleh keluarga Cuthbert. Cerita ini menghangatkan hati dan cocok untuk semua usia.',
        ],
        [
            'category' => 'anak-remaja',
            'slug' => 'alice-adventures-in-wonderland',
            'title' => 'Alice\'s Adventures in Wonderland',
            'author' => 'Lewis Carroll',
            'published_year' => 1865,
            'price' => 85000,
            'stock' => 15,
            'description' => 'Alice jatuh ke dalam lubang kelinci dan masuk ke dunia penuh keajaiban. Cerita ini terkenal karena permainan kata dan tokohnya yang unik.',
        ],
        [
            'category' => 'anak-remaja',
            'slug' => 'the-tale-of-peter-rabbit',
            'title' => 'The Tale of Peter Rabbit',
            'author' => 'Beatrix Potter',
            'published_year' => 1902,
            'price' => 75000,
            'stock' => 20,
            'description' => 'Kelinci kecil bernama Peter nekat masuk ke kebun Tuan McGregor. Cerita bergambar ini menjadi salah satu buku anak paling terkenal di dunia.',
        ],
        [
            'category' => 'anak-remaja',
            'slug' => 'peter-pan',
            'title' => 'Peter Pan',
            'author' => 'J. M. Barrie',
            'published_year' => 1911,
            'price' => 82000,
            'stock' => 11,
            'description' => 'Petualangan Wendy dan saudaranya bersama Peter Pan di pulau Neverland. Cerita ini mengangkat tema persahabatan dan keengganan tumbuh dewasa.',
        ],
        [
            'category' => 'anak-remaja',
            'slug' => 'the-jungle-book',
            'title' => 'The Jungle Book',
            'author' => 'Rudyard Kipling',
            'published_year' => 1894,
            'price' => 79000,
            'stock' => 13,
            'description' => 'Mowgli dibesarkan oleh kawanan serigala di hutan India. Kumpulan cerita ini menampilkan tokoh hewan yang cerdas dan penuh pelajaran.',
        ],
        [
            'category' => 'sejarah-politik-filsafat',
            'slug' => 'decline-and-fall-roman-empire',
            'title' => 'The History of the Decline and Fall of the Roman Empire, Volume 1',
            'author' => 'Edward Gibbon',
            'published_year' => 1776,
            'price' => 165000,
            'stock' => 5,
            'description' => 'Uraian panjang mengenai kemunduran Kekaisaran Romawi. Buku ini menjadi rujukan penting bagi pembaca yang menyukai sejarah Eropa kuno.',
        ],
        [
            'category' => 'sejarah-politik-filsafat',
            'slug' => 'the-prince',
            'title' => 'The Prince',
            'author' => 'Niccolo Machiavelli',
            'published_year' => 1532,
            'price' => 92000,
            'stock' => 10,
            'description' => 'Buku panduan tentang cara mempertahankan kekuasaan pada masa Renaisans. Pemikirannya banyak dibahas dalam studi politik hingga sekarang.',
        ],
        [
            'category' => 'sejarah-politik-filsafat',
            'slug' => 'a-modest-proposal',
            'title' => 'A Modest Proposal',
            'author' => 'Jonathan Swift',
            'published_year' => 1729,
            'price' => 65000,
            'stock' => 18,
            'description' => 'Pamflet satir yang mengkritik kebijakan pemerintah Inggris terhadap rakyat miskin Irlandia. Gaya sindirannya tajam namun mudah dipahami.',
        ],
        [
            'category' => 'sains-teknologi',
            'slug' => 'the-origin-of-species',
            'title' => 'The Origin of Species by Means of Natural Selection',
            'author' => 'Charles Darwin',
            'published_year' => 1859,
            'price' => 175000,
            'stock' => 6,
            'description' => 'Buku yang menjelaskan teori seleksi alam dan asal-usul spesies. Karya ini menjadi dasar perkembangan ilmu biologi modern.',
        ],
        [
            'category' => 'sains-teknologi',
            'slug' => 'the-voyage-of-the-beagle',
            'title' => 'The Voyage of the Beagle',
            'author' => 'Charles Darwin',
            'published_year' => 1839,
            'price' => 145000,
            'stock' => 7,
            'description' => 'Catatan perjalanan Darwin selama lima tahun mengelilingi dunia. Buku ini berisi pengamatan alam yang menjadi cikal bakal teorinya.',
        ],
        [
            'category' => 'bisnis-ekonomi',
            'slug' => 'the-wealth-of-nations',
            'title' => 'An Inquiry into the Nature and Causes of the Wealth of Nations',
            'author' => 'Adam Smith',
            'published_year' => 1776,
            'price' => 185000,
            'stock' => 4,
            'description' => 'Karya klasik yang membahas pembagian kerja, pasar, dan kekayaan bangsa. Buku ini menjadi dasar ilmu ekonomi modern.',
        ],
        [
            'category' => 'bisnis-ekonomi',
            'slug' => 'the-theory-of-the-leisure-class',
            'title' => 'The Theory of the Leisure Class',
            'author' => 'Thorstein Veblen',
            'published_year' => 1899,
            'price' => 135000,
            'stock' => 8,
            'description' => 'Analisis tentang perilaku konsumsi dan lambang status sosial. Buku ini memperkenalkan istilah konsumsi mencolok dalam ilmu ekonomi.',
        ],
    ];

    /**
     * Menyimpan seluruh buku bawaan aplikasi.
     */
    public function run(): void
    {
        // Peta slug kategori dipakai agar penulisan data buku lebih ringkas.
        $categoryIds = Category::query()->pluck('id', 'slug');

        foreach (self::BOOKS as $book) {
            Book::updateOrCreate(
                ['slug' => $book['slug']],
                [
                    'category_id' => $categoryIds[$book['category']],
                    'title' => $book['title'],
                    'author' => $book['author'],
                    'publisher' => 'Project Gutenberg',
                    'published_year' => $book['published_year'],
                    'price' => $book['price'],
                    'stock' => $book['stock'],
                    // Nama berkas sampul mengikuti slug buku.
                    'cover_image' => $book['slug'].'.jpg',
                    'description' => $book['description'],
                ]
            );
        }
    }
}
