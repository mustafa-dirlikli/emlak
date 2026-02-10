<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\District;
use App\Models\Neighborhood;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'İstanbul' => [
                'Kadıköy' => ['Caferağa', 'Moda', 'Fenerbahçe', 'Göztepe'],
                'Üsküdar' => ['Acıbadem', 'Altunizade', 'Kısıklı', 'Çengelköy'],
                'Beşiktaş' => ['Levent', 'Etiler', 'Ortaköy', 'Bebek'],
            ],
            'Ankara' => [
                'Çankaya' => ['Bahçelievler', 'Tunalı', 'Kızılay', 'Çayyolu'],
                'Yenimahalle' => ['Batıkent', 'Demetevler', 'Ostim', 'Cumhuriyet Mh.'],
                'Keçiören' => ['Etlik', 'Esertepe', 'Pınarbaşı'],
            ],
            'İzmir' => [
                'Konak' => ['Alsancak', 'Basmane', 'Güzelyalı', 'Karataş'],
                'Karşıyaka' => ['Bostanlı', 'Soğukkuyu', 'Mavişehir'],
            ],
            'Antalya' => [
                'Muratpaşa' => ['Lara', 'Şirinyalı', 'Konyaaltı'],
                'Konyaaltı' => ['Liman', 'Hurma', 'Sarısu'],
            ],
            'Bursa' => [
                'Nilüfer' => ['Özlüce', 'Beşevler', 'Görükle'],
                'Osmangazi' => ['Heykel', 'Setbaşı', 'Soğanlı'],
            ],
            'Adana' => [
                'Seyhan' => ['Reşatbey', 'Tepebağ', 'Döşeme'],
                'Çukurova' => ['Mahfesığmaz', 'Kireçocağı', 'Yurt'],
            ],
            'Kocaeli' => [
                'İzmit' => ['Yahyakaptan', 'Alikahya', 'Kozlu'],
                'Gebze' => ['Gebze OSB', 'Muallimköy', 'Pelitli'],
            ],
        ];

        foreach ($data as $cityName => $districts) {
            $city = City::firstOrCreate(['name' => $cityName]);

            foreach ($districts as $districtName => $neighborhoodNames) {
                $district = $city->districts()->firstOrCreate(['name' => $districtName]);

                foreach ($neighborhoodNames as $neighborhoodName) {
                    $district->neighborhoods()->firstOrCreate(['name' => $neighborhoodName]);
                }
            }
        }
    }
}
