<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus data lama (opsional, untuk development)
        User::query()->delete();
        Recipe::query()->delete();

        // Data Users dengan password sesuai ketentuan
        $users = [
            [
                'name' => 'Admin ResepinAja',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'photo' => null,
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'role' => 'user',
                'password' => Hash::make('budi123'),
                'photo' => 'profiles/budi.jpg',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@gmail.com',
                'role' => 'user',
                'password' => Hash::make('siti123'),
                'photo' => 'profiles/siti.jpg',
            ],
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad@gmail.com',
                'role' => 'user',
                'password' => Hash::make('ahmad123'),
                'photo' => 'profiles/ahmad.jpg',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@gmail.com',
                'role' => 'user',
                'password' => Hash::make('dewi123'),
                'photo' => 'profiles/dewi.jpg',
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko@gmail.com',
                'role' => 'user',
                'password' => Hash::make('eko123'),
                'photo' => null,
            ],
        ];

        // Data Recipes
        $recipes = [
            [
                'user_id' => 2,
                'title' => 'Nasi Goreng Spesial',
                'image' => 'recipes/nasigoreng.jpg',
                'ingredients' => ["2 porsi nasi putih","2 butir telur","3 siung bawang putih","5 siung bawang merah","2 sdm kecap manis","1 sdt garam","1 sdt merica","2 sdm minyak goreng","Daun bawang secukupnya","Cabai rawit sesuai selera"],
                'steps' => ["Cincang halus bawang putih dan bawang merah","Panaskan minyak dalam wajan dengan api sedang","Tumis bawang putih dan merah hingga harum","Masukkan telur, orak-arik hingga matang","Tambahkan nasi putih, aduk rata","Beri kecap manis, garam, dan merica","Masak sambil terus diaduk hingga bumbu meresap","Tambahkan daun bawang dan cabai","Aduk sebentar, angkat dan sajikan"],
            ],
            [
                'user_id' => 2,
                'title' => 'Ayam Goreng Crispy',
                'image' => 'recipes/ayamgoreng.jpg',
                'ingredients' => ["500 gram ayam potong","3 siung bawang putih","1 sdt ketumbar","1 sdt garam","1 sdt merica","2 sdm tepung terigu","3 sdm tepung beras","Minyak untuk menggoreng","Air secukupnya"],
                'steps' => ["Haluskan bawang putih, ketumbar, garam, dan merica","Lumuri ayam dengan bumbu halus, diamkan 30 menit","Campurkan tepung terigu dan tepung beras","Celupkan ayam ke air, lalu balur dengan tepung","Goreng ayam dengan api sedang hingga kecoklatan","Tiriskan dan sajikan hangat"],
            ],
            [
                'user_id' => 3,
                'title' => 'Mie Goreng Jawa',
                'image' => 'recipes/miegoreng.jpg',
                'ingredients' => ["2 bungkus mie telur","3 sdm kecap manis","2 siung bawang putih","4 siung bawang merah","1 buah cabai merah","2 lembar sawi hijau","2 butir telur","Garam dan merica secukupnya"],
                'steps' => ["Rebus mie hingga matang, tiriskan","Cincang bawang putih, bawang merah, dan cabai","Panaskan minyak, tumis bumbu hingga harum","Masukkan telur, orak-arik","Tambahkan mie dan kecap manis","Masukkan sawi, aduk hingga layu","Beri garam dan merica, aduk rata","Angkat dan sajikan"],
            ],
            [
                'user_id' => 4,
                'title' => 'Soto Ayam Kuning',
                'image' => 'recipes/sotoayam.jpg',
                'ingredients' => ["500 gram ayam kampung","3 batang serai","4 lembar daun salam","2 cm lengkuas","1 liter air","3 sdm minyak goreng","Garam secukupnya","Kunyit bubuk 1 sdt","Bawang goreng untuk taburan"],
                'steps' => ["Rebus ayam dengan serai, daun salam, dan lengkuas","Masak hingga ayam empuk, angkat dan suwir","Saring kaldu ayam","Panaskan kembali kaldu, beri kunyit dan garam","Masak hingga mendidih","Siapkan mangkuk, masukkan suwiran ayam","Tuang kuah panas ke dalam mangkuk","Taburi bawang goreng","Sajikan dengan nasi hangat"],
            ],
            [
                'user_id' => 4,
                'title' => 'Rendang Daging Sapi',
                'image' => 'recipes/rendang.jpg',
                'ingredients' => ["1 kg daging sapi","500 ml santan kental","5 lembar daun jeruk","2 batang serai","3 cm lengkuas","10 siung bawang merah","6 siung bawang putih","8 buah cabai merah","3 cm jahe","2 cm kunyit","Garam dan gula secukupnya"],
                'steps' => ["Potong daging menjadi kubus sedang","Haluskan bawang merah, bawang putih, cabai, jahe, dan kunyit","Panaskan minyak, tumis bumbu halus hingga harum","Masukkan daging, aduk hingga berubah warna","Tuang santan, masukkan serai, daun jeruk, dan lengkuas","Masak dengan api kecil sambil terus diaduk","Beri garam dan gula secukupnya","Masak hingga kuah menyusut dan berminyak","Angkat dan sajikan"],
            ],
            [
                'user_id' => 5,
                'title' => 'Gado-Gado Jakarta',
                'image' => 'recipes/gadogado.jpg',
                'ingredients' => ["100 gram kacang tanah goreng","3 siung bawang putih","2 buah cabai rawit","2 sdm gula merah","1 sdt terasi","Air secukupnya","Sayuran rebus (kol, tauge, kangkung)","Telur rebus","Tahu goreng","Tempe goreng","Kerupuk"],
                'steps' => ["Haluskan kacang tanah, bawang putih, cabai, dan terasi","Tambahkan gula merah, haluskan kembali","Beri air sedikit demi sedikit sambil diaduk","Masak bumbu kacang hingga mendidih","Tata sayuran dalam piring","Siram dengan bumbu kacang","Tambahkan telur, tahu, dan tempe","Beri kerupuk di atasnya","Sajikan segera"],
            ],
            [
                'user_id' => 5,
                'title' => 'Nasi Uduk Betawi',
                'image' => 'recipes/nasiuduk.jpg',
                'ingredients' => ["500 gram beras","400 ml santan","2 lembar daun salam","2 batang serai","1 cm lengkuas","Garam secukupnya","Air secukupnya"],
                'steps' => ["Cuci bersih beras, tiriskan","Masukkan beras ke rice cooker","Tambahkan santan dan air","Masukkan daun salam, serai, dan lengkuas","Beri garam secukupnya","Masak hingga matang","Aduk nasi setelah matang","Sajikan dengan lauk pelengkap"],
            ],
            [
                'user_id' => 6,
                'title' => 'Bakso Sapi Kenyal',
                'image' => 'recipes/bakso.jpg',
                'ingredients' => ["500 gram daging sapi giling","100 gram tepung tapioka","5 siung bawang putih","1 butir telur","Es batu secukupnya","Garam dan merica","Kaldu sapi untuk kuah","Mie kuning","Daun seledri","Bawang goreng"],
                'steps' => ["Haluskan bawang putih, garam, dan merica","Campur daging giling dengan bumbu halus","Tambahkan telur dan tepung tapioka","Uleni sambil ditambahkan es batu sedikit demi sedikit","Bentuk adonan menjadi bulatan bakso","Rebus air hingga mendidih, kecilkan api","Masukkan bakso satu per satu","Rebus hingga bakso mengapung","Siapkan mangkuk berisi mie dan kaldu panas","Masukkan bakso, taburi seledri dan bawang goreng","Sajikan hangat"],
            ],
            [
                'user_id' => 6,
                'title' => 'Sate Ayam Madura',
                'image' => 'recipes/sateayam.jpg',
                'ingredients' => ["500 gram daging ayam fillet","3 sdm kecap manis","2 sdm minyak goreng","Tusuk sate secukupnya","Bumbu Halus: 5 siung bawang merah, 3 siung bawang putih, 2 cm kunyit, 1 sdt ketumbar, Garam secukupnya"],
                'steps' => ["Potong daging ayam menjadi kubus kecil","Haluskan semua bumbu","Lumuri ayam dengan bumbu halus dan kecap manis","Diamkan minimal 1 jam di kulkas","Tusuk potongan ayam ke tusuk sate","Panaskan panggangan atau wajan datar","Bakar sate sambil dioles bumbu sisa","Balik-balik hingga matang merata","Sajikan dengan bumbu kacang dan lontong"],
            ],
            [
                'user_id' => 3,
                'title' => 'Sayur Asem Betawi',
                'image' => 'recipes/sayurasem.jpg',
                'ingredients' => ["2 buah jagung manis","100 gram kacang panjang","100 gram labu siam","3 buah cabai rawit","3 lembar daun salam","1 batang serai","2 cm lengkuas","5 buah asam jawa","Garam dan gula secukupnya","Air 1 liter"],
                'steps' => ["Potong semua sayuran sesuai selera","Rebus air hingga mendidih","Masukkan jagung, masak hingga setengah empuk","Tambahkan labu siam dan kacang panjang","Masukkan serai, daun salam, lengkuas, dan cabai","Beri asam jawa, garam, dan gula","Masak hingga semua sayuran empuk","Koreksi rasa","Angkat dan sajikan hangat"],
            ],
        ];

        // Insert Users
        foreach ($users as $user) {
            User::create($user);
        }

        // Insert Recipes
        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }
    }
}