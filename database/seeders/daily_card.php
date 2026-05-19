<?php

namespace Database\Seeders;

use App\Models\daily_card as ModelsDaily_card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class daily_card extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = [
            ['day'=>1,  'card_name'=>'The Fool',         'card_image'=>'fool.jpg',         'keyword'=>'Petualangan, Awal Baru',      'meaning'=>'Hari ini adalah awal dari sesuatu yang baru. Percayai instingmu dan melangkahlah dengan berani tanpa rasa takut.'],
            ['day'=>2,  'card_name'=>'The Magician',     'card_image'=>'magician.jpg',     'keyword'=>'Kemampuan, Manifestasi',     'meaning'=>'Kamu memiliki semua yang dibutuhkan untuk sukses. Gunakan kemampuanmu dengan penuh fokus hari ini.'],
            ['day'=>3,  'card_name'=>'The High Priestess','card_image'=>'priestess.jpg',   'keyword'=>'Intuisi, Misteri',           'meaning'=>'Dengarkan suara batinmu. Hari ini jawaban datang dari dalam dirimu sendiri, bukan dari luar.'],
            ['day'=>4,  'card_name'=>'The Empress',      'card_image'=>'empress.jpg',      'keyword'=>'Kelimpahan, Kreativitas',    'meaning'=>'Energi kreatif sedang tinggi. Cocok untuk memulai proyek baru atau mengekspresikan dirimu.'],
            ['day'=>5,  'card_name'=>'The Emperor',      'card_image'=>'emperor.jpg',      'keyword'=>'Otoritas, Stabilitas',       'meaning'=>'Ambil kendali atas situasi. Strukturkan rencanamu dan jadilah pemimpin yang tegas hari ini.'],
            ['day'=>6,  'card_name'=>'The Hierophant',   'card_image'=>'hierophant.jpg',   'keyword'=>'Tradisi, Bimbingan',         'meaning'=>'Carilah nasihat dari orang yang berpengalaman. Hormati tradisi namun tetap bijak dalam bersikap.'],
            ['day'=>7,  'card_name'=>'The Lovers',       'card_image'=>'lovers.jpg',       'keyword'=>'Cinta, Pilihan',             'meaning'=>'Sebuah keputusan penting menanti. Ikuti hatimu namun tetap gunakan akal sehatmu.'],
            ['day'=>8,  'card_name'=>'The Chariot',      'card_image'=>'chariot.jpg',      'keyword'=>'Tekad, Kemenangan',          'meaning'=>'Dorong terus maju. Hari ini energimu kuat — gunakan untuk mengatasi hambatan yang ada.'],
            ['day'=>9,  'card_name'=>'Strength',         'card_image'=>'strength.jpg',     'keyword'=>'Keberanian, Kesabaran',      'meaning'=>'Kekuatan sejati datang dari kelembutan. Hadapi tantangan hari ini dengan tenang dan penuh percaya diri.'],
            ['day'=>10, 'card_name'=>'The Hermit',       'card_image'=>'hermit.jpg',       'keyword'=>'Refleksi, Ketenangan',       'meaning'=>'Ambil waktu untuk merenung. Kesendirian hari ini bukan kesepian — melainkan kesempatan untuk tumbuh.'],
            ['day'=>11, 'card_name'=>'Wheel of Fortune', 'card_image'=>'wheel.jpg',        'keyword'=>'Perubahan, Takdir',          'meaning'=>'Roda kehidupan terus berputar. Terima perubahan dengan lapang dada dan percaya pada prosesnya.'],
            ['day'=>12, 'card_name'=>'Justice',          'card_image'=>'justice.jpg',      'keyword'=>'Keadilan, Keseimbangan',     'meaning'=>'Kebenaran akan terungkap. Hari ini penting untuk bersikap jujur dan adil dalam setiap tindakanmu.'],
            ['day'=>13, 'card_name'=>'The Hanged Man',   'card_image'=>'hangedman.jpg',    'keyword'=>'Perspektif Baru, Sabar',     'meaning'=>'Berhenti sejenak dan lihat dari sudut pandang berbeda. Penantian hari ini membawa pencerahan.'],
            ['day'=>14, 'card_name'=>'Death',            'card_image'=>'death.jpg',        'keyword'=>'Transformasi, Akhir',        'meaning'=>'Bukan akhir, melainkan transformasi. Lepaskan yang sudah tak relevan dan sambut babak baru.'],
            ['day'=>15, 'card_name'=>'Temperance',       'card_image'=>'temperance.jpg',   'keyword'=>'Keseimbangan, Moderasi',     'meaning'=>'Jaga keseimbangan dalam segala hal hari ini. Hindari ekstrem dan temukan ritme yang harmonis.'],
            ['day'=>16, 'card_name'=>'The Devil',        'card_image'=>'devil.jpg',        'keyword'=>'Keterikatan, Kesadaran',     'meaning'=>'Sadari apa yang membelenggu dirimu. Hari ini adalah momen untuk melepaskan kebiasaan yang tidak sehat.'],
            ['day'=>17, 'card_name'=>'The Tower',        'card_image'=>'tower.jpg',        'keyword'=>'Kejutan, Perubahan Drastis', 'meaning'=>'Perubahan mendadak bisa datang hari ini. Tetap tenang — di balik keruntuhan ada pondasi baru yang lebih kuat.'],
            ['day'=>18, 'card_name'=>'The Star',         'card_image'=>'star.jpg',         'keyword'=>'Harapan, Inspirasi',         'meaning'=>'Bintang-bintang berpihak padamu. Hari ini penuh harapan — percayalah bahwa hal baik sedang menuju kepadamu.'],
            ['day'=>19, 'card_name'=>'The Moon',         'card_image'=>'moon.jpg',         'keyword'=>'Ilusi, Intuisi',             'meaning'=>'Tidak semua yang terlihat adalah kenyataan. Percayai intuisimu untuk menavigasi hari yang penuh misteri ini.'],
            ['day'=>20, 'card_name'=>'The Sun',          'card_image'=>'sun.jpg',          'keyword'=>'Kegembiraan, Sukses',        'meaning'=>'Hari yang cerah dan penuh energi positif! Rayakan pencapaianmu dan biarkan dirimu bersinar.'],
            ['day'=>21, 'card_name'=>'Judgement',        'card_image'=>'judgement.jpg',    'keyword'=>'Kebangkitan, Evaluasi',      'meaning'=>'Saat untuk mengevaluasi diri. Dengarkan panggilanmu yang lebih tinggi dan ambil keputusan besar.'],
            ['day'=>22, 'card_name'=>'The World',        'card_image'=>'world.jpg',        'keyword'=>'Pencapaian, Kelengkapan',    'meaning'=>'Sebuah siklus telah selesai dengan sempurna. Nikmati pencapaianmu dan bersiaplah untuk babak berikutnya.'],
            ['day'=>23, 'card_name'=>'Ace of Cups',      'card_image'=>'ace_cups.jpg',     'keyword'=>'Cinta Baru, Emosi',          'meaning'=>'Hatimu terbuka lebar hari ini. Sambut perasaan baru dengan penuh keikhlasan.'],
            ['day'=>24, 'card_name'=>'Ace of Wands',     'card_image'=>'ace_wands.jpg',    'keyword'=>'Semangat, Kreasi',           'meaning'=>'Api semangat menyala dalam dirimu. Mulailah proyek yang selama ini kamu tunda.'],
            ['day'=>25, 'card_name'=>'Ace of Swords',    'card_image'=>'ace_swords.jpg',   'keyword'=>'Kejernihan, Kebenaran',      'meaning'=>'Pikiran jernih membantumu memutuskan dengan tepat. Hari yang baik untuk berkomunikasi dan bernegosiasi.'],
            ['day'=>26, 'card_name'=>'Ace of Pentacles', 'card_image'=>'ace_pentacles.jpg','keyword'=>'Peluang, Materi',            'meaning'=>'Peluang finansial atau material sedang mendekat. Buka matamu dan ambil kesempatan ini.'],
            ['day'=>27, 'card_name'=>'The Star',         'card_image'=>'star.jpg',         'keyword'=>'Harapan, Pembaruan',         'meaning'=>'Percayakan dirimu pada alam semesta. Semua yang kamu butuhkan sedang dalam perjalanan menujumu.'],
            ['day'=>28, 'card_name'=>'The Moon',         'card_image'=>'moon.jpg',         'keyword'=>'Mimpi, Misteri',             'meaning'=>'Perhatikan mimpimu malam ini — ada pesan penting di sana. Jaga energimu dan hindari drama hari ini.'],
            ['day'=>29, 'card_name'=>'The Sun',          'card_image'=>'sun.jpg',          'keyword'=>'Optimisme, Vitalitas',       'meaning'=>'Energi positif mengalir derasmu hari ini. Bagikan keceriaanmu kepada orang-orang di sekitarmu.'],
            ['day'=>30, 'card_name'=>'The World',        'card_image'=>'world.jpg',        'keyword'=>'Syukur, Kelengkapan',        'meaning'=>'Tutup bulan ini dengan rasa syukur. Setiap pengalaman membawamu selangkah lebih dekat pada versi terbaikmu.'],
            ['day'=>31, 'card_name'=>'The Fool',         'card_image'=>'fool.jpg',         'keyword'=>'Siklus Baru, Keberanian',   'meaning'=>'Hari terakhir membawa energi awal yang segar. Tutup bulan ini dengan hati ringan dan penuh harapan.'],
        ];

        foreach ($cards as $card) {
            $card['card_image'] = 'cust/image/daily_card/' . $card['card_image'];
            ModelsDaily_card::updateOrCreate(['day' => $card['day']], $card);
        }
    }
}
