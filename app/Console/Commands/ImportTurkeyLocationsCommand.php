<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\District;
use App\Models\Neighborhood;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportTurkeyLocationsCommand extends Command
{
    protected $signature = 'locations:import-turkey
                            {--refresh : Önce mevcut şehir/ilçe/mahalle verilerini sil}
                            {--url= : JSON URL (varsayılan: hsndmr GitHub)}';

    protected $description = 'Türkiye şehir, ilçe ve mahalle verilerini GitHub kütüphanesinden (hsndmr) toplu içe aktarır.';

    private const DEFAULT_JSON_URL = 'https://raw.githubusercontent.com/hsndmr/turkiye-city-county-district-neighborhood/main/data.json';

    private const NEIGHBORHOOD_CHUNK = 2000;

    public function handle(): int
    {
        $url = $this->option('url') ?: self::DEFAULT_JSON_URL;

        $this->info('Veri indiriliyor: ' . $url);

        $response = Http::timeout(120)->get($url);

        if (! $response->successful()) {
            $this->error('JSON indirilemedi. HTTP: ' . $response->status());

            return self::FAILURE;
        }

        $data = $response->json();
        if (! is_array($data)) {
            $this->error('Geçersiz JSON yapısı.');

            return self::FAILURE;
        }

        if ($this->option('refresh')) {
            $this->warn('Mevcut veriler siliniyor...');
            Neighborhood::query()->delete();
            District::query()->delete();
            City::query()->delete();
        }

        $bar = $this->output->createProgressBar(count($data));
        $bar->setFormat(' %current%/%max% şehir [%bar%] %percent:3s%%');
        $bar->start();

        $cityCount = 0;
        $districtCount = 0;
        $neighborhoodCount = 0;
        $now = now();

        foreach ($data as $cityItem) {
            $cityName = $cityItem['name'] ?? null;
            if (! $cityName) {
                $bar->advance();
                continue;
            }

            $city = City::firstOrCreate(['name' => $cityName]);
            $cityCount++;

            $counties = $cityItem['counties'] ?? [];
            foreach ($counties as $countyItem) {
                $countyName = $countyItem['name'] ?? null;
                if (! $countyName) {
                    continue;
                }

                $district = $city->districts()->firstOrCreate(['name' => $countyName]);
                $districtCount++;

                $neighborhoodBatch = [];
                $districts = $countyItem['districts'] ?? [];
                foreach ($districts as $districtItem) {
                    foreach ($districtItem['neighborhoods'] ?? [] as $nb) {
                        $nbName = $nb['name'] ?? null;
                        if ($nbName !== null && $nbName !== '') {
                            $neighborhoodBatch[] = [
                                'district_id' => $district->id,
                                'name' => $nbName,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                            $neighborhoodCount++;
                        }
                    }
                }

                foreach (array_chunk($neighborhoodBatch, self::NEIGHBORHOOD_CHUNK) as $chunk) {
                    Neighborhood::insert($chunk);
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("İçe aktarma tamamlandı: {$cityCount} şehir, {$districtCount} ilçe, {$neighborhoodCount} mahalle.");

        return self::SUCCESS;
    }
}
