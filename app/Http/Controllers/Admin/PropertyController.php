<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Neighborhood;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $query = Property::query()->with('user');

        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('address', 'like', '%'.$request->search.'%')
                    ->orWhere('city', 'like', '%'.$request->search.'%');
            });
        }

        $properties = $query->latest()->paginate(15)->withQueryString();

        return view('admin.properties.index', compact('properties'));
    }

    public function create(): View
    {
        $defaultType = request('tip', 'daire');
        if (! in_array($defaultType, ['konut', 'daire', 'arsa', 'isyeri', 'villa', 'mustakil'], true)) {
            $defaultType = 'daire';
        }
        $cities = City::orderBy('name')->get();
        $districts = District::with('city')->orderBy('name')->get();
        $neighborhoods = Neighborhood::with('district')->orderBy('name')->get();

        return view('admin.properties.create', [
            'defaultPropertyType' => $defaultType,
            'cities' => $cities,
            'districts' => $districts,
            'neighborhoods' => $neighborhoods,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'listing_type' => ['required', 'in:sale,rent'],
            'property_type' => ['required', 'string', 'in:konut,daire,arsa,isyeri,villa,mustakil'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'isyeri_durumu' => ['nullable', 'string', 'max:100'],
            'isyeri_turu' => ['nullable', 'string', 'max:100'],
            'bolum_oda_sayisi' => ['nullable', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'in:TRY,USD,EUR'],
            'city' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'neighborhood' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'lokasyon' => ['nullable', 'string'],
            'rooms' => ['nullable', 'integer', 'min:0', 'max:50'],
            'salon' => ['nullable', 'integer', 'min:0', 'max:10'],
            'room_layout' => ['nullable', 'string', Rule::in(array_keys(Property::roomLayoutOptions()))],
            'bathrooms' => ['nullable', Rule::in(array_filter(array_keys(Property::bathroomsOptions())))],
            'area_sqm' => ['nullable', 'integer', 'min:0'],
            'area_brut' => ['nullable', 'integer', 'min:0'],
            'price_per_sqm' => ['nullable', 'numeric', 'min:0'],
            'bina_yasi' => ['nullable', Rule::in(array_filter(array_keys(Property::binaYasiOptions())))],
            'bulundugu_kat' => ['nullable', Rule::in(array_filter(array_keys(Property::bulunduguKatOptions())))],
            'kat_sayisi' => ['nullable', Rule::in(array_filter(array_keys(Property::katSayisiOptions())))],
            'isitma' => ['nullable', Rule::in(array_filter(array_keys(Property::isitmaOptions())))],
            'mutfak' => ['nullable', Rule::in(array_filter(array_keys(Property::mutfakOptions())))],
            'balkon' => ['nullable', 'string', 'max:10'],
            'asansor' => ['nullable', 'boolean'],
            'otopark' => ['nullable', 'string', 'max:100'],
            'esyali' => ['nullable', 'boolean'],
            'kullanim_durumu' => ['nullable', 'string', 'max:100'],
            'site_icerisinde' => ['nullable', 'boolean'],
            'site_adi' => ['nullable', 'string', 'max:255'],
            'aidat' => ['nullable', 'numeric', 'min:0'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'ilan_no' => ['nullable', 'string', 'max:50'],
            'ilan_tarihi' => ['nullable', 'date'],
            'imar_durumu' => ['nullable', 'string', 'max:100'],
            'ada_no' => ['nullable', 'string', 'max:50'],
            'parsel_no' => ['nullable', 'string', 'max:50'],
            'pafta_no' => ['nullable', 'string', 'max:50'],
            'kaks' => ['nullable', 'string', 'max:50'],
            'gabari' => ['nullable', 'string', 'max:100'],
            'krediye_uygunluk' => ['nullable', 'boolean'],
            'tapu_durumu' => ['nullable', 'string', 'max:100'],
            'takas' => ['nullable', 'boolean'],
            'ilan_detay' => ['nullable', 'string'],
            'arsa_ozellikler' => ['nullable', 'string'],
            'personel' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['slug'] = Str::slug($validated['title']).'-'.uniqid();
        $validated['currency'] = $validated['currency'] ?? 'TRY';
        $validated['user_id'] = $request->user()->id;
        $validated['bathrooms'] = $request->filled('bathrooms') ? (int) $request->input('bathrooms') : null;
        $validated['kat_sayisi'] = $request->filled('kat_sayisi') ? (int) $request->input('kat_sayisi') : null;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['krediye_uygunluk'] = $request->boolean('krediye_uygunluk');
        $validated['takas'] = $request->boolean('takas');
        $validated['asansor'] = $request->boolean('asansor');
        $validated['esyali'] = $request->boolean('esyali');
        $validated['site_icerisinde'] = $request->boolean('site_icerisinde');
        $validated['ilan_detay'] = $request->filled('ilan_detay') ? json_decode($request->ilan_detay, true) : null;
        $validated['arsa_ozellikler'] = $request->filled('arsa_ozellikler') ? json_decode($request->arsa_ozellikler, true) : null;

        $files = $request->file('images');
        if ($files && count($files) > 0) {
            $validated['image'] = $files[0]->store('properties', 'public');
            $gallery = [];
            for ($i = 1; $i < count($files); $i++) {
                $gallery[] = $files[$i]->store('properties', 'public');
            }
            $validated['gallery'] = $gallery;
        }

        Property::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'İlan başarıyla eklendi.');
    }

    public function edit(Property $property): View
    {
        $cities = City::orderBy('name')->get();
        $districts = District::with('city')->orderBy('name')->get();
        $neighborhoods = Neighborhood::with('district')->orderBy('name')->get();

        return view('admin.properties.edit', compact('property', 'cities', 'districts', 'neighborhoods'));
    }

    public function update(Request $request, Property $property): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'listing_type' => ['required', 'in:sale,rent'],
            'property_type' => ['required', 'string', 'in:konut,daire,arsa,isyeri,villa,mustakil'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'isyeri_durumu' => ['nullable', 'string', 'max:100'],
            'isyeri_turu' => ['nullable', 'string', 'max:100'],
            'bolum_oda_sayisi' => ['nullable', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'in:TRY,USD,EUR'],
            'city' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'neighborhood' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'lokasyon' => ['nullable', 'string'],
            'rooms' => ['nullable', 'integer', 'min:0', 'max:50'],
            'salon' => ['nullable', 'integer', 'min:0', 'max:10'],
            'room_layout' => ['nullable', 'string', Rule::in(array_keys(Property::roomLayoutOptions()))],
            'bathrooms' => ['nullable', Rule::in(array_filter(array_keys(Property::bathroomsOptions())))],
            'area_sqm' => ['nullable', 'integer', 'min:0'],
            'area_brut' => ['nullable', 'integer', 'min:0'],
            'price_per_sqm' => ['nullable', 'numeric', 'min:0'],
            'bina_yasi' => ['nullable', Rule::in(array_filter(array_keys(Property::binaYasiOptions())))],
            'bulundugu_kat' => ['nullable', Rule::in(array_filter(array_keys(Property::bulunduguKatOptions())))],
            'kat_sayisi' => ['nullable', Rule::in(array_filter(array_keys(Property::katSayisiOptions())))],
            'isitma' => ['nullable', Rule::in(array_filter(array_keys(Property::isitmaOptions())))],
            'mutfak' => ['nullable', Rule::in(array_filter(array_keys(Property::mutfakOptions())))],
            'balkon' => ['nullable', 'string', 'max:10'],
            'asansor' => ['nullable', 'boolean'],
            'otopark' => ['nullable', 'string', 'max:100'],
            'esyali' => ['nullable', 'boolean'],
            'kullanim_durumu' => ['nullable', 'string', 'max:100'],
            'site_icerisinde' => ['nullable', 'boolean'],
            'site_adi' => ['nullable', 'string', 'max:255'],
            'aidat' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'remove_main' => ['nullable', 'boolean'],
            'gallery_remove' => ['nullable', 'array'],
            'gallery_remove.*' => ['nullable', 'string', 'max:500'],
            'gallery_new' => ['nullable', 'array'],
            'gallery_new.*' => ['image', 'max:2048'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'ilan_no' => ['nullable', 'string', 'max:50'],
            'ilan_tarihi' => ['nullable', 'date'],
            'imar_durumu' => ['nullable', 'string', 'max:100'],
            'ada_no' => ['nullable', 'string', 'max:50'],
            'parsel_no' => ['nullable', 'string', 'max:50'],
            'pafta_no' => ['nullable', 'string', 'max:50'],
            'kaks' => ['nullable', 'string', 'max:50'],
            'gabari' => ['nullable', 'string', 'max:100'],
            'krediye_uygunluk' => ['nullable', 'boolean'],
            'tapu_durumu' => ['nullable', 'string', 'max:100'],
            'takas' => ['nullable', 'boolean'],
            'ilan_detay' => ['nullable', 'string'],
            'arsa_ozellikler' => ['nullable', 'string'],
            'personel' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['bathrooms'] = $request->filled('bathrooms') ? (int) $request->input('bathrooms') : null;
        $validated['kat_sayisi'] = $request->filled('kat_sayisi') ? (int) $request->input('kat_sayisi') : null;
        $validated['krediye_uygunluk'] = $request->boolean('krediye_uygunluk');
        $validated['takas'] = $request->boolean('takas');
        $validated['asansor'] = $request->boolean('asansor');
        $validated['esyali'] = $request->boolean('esyali');
        $validated['site_icerisinde'] = $request->boolean('site_icerisinde');
        $validated['ilan_detay'] = $request->filled('ilan_detay') ? json_decode($request->ilan_detay, true) : null;
        $validated['arsa_ozellikler'] = $request->filled('arsa_ozellikler') ? json_decode($request->arsa_ozellikler, true) : null;

        if ($request->boolean('remove_main')) {
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('properties', 'public');
        }
        $removePaths = $request->input('gallery_remove', []);
        if (! is_array($removePaths)) {
            $removePaths = [];
        }
        $existingGallery = $property->gallery ?? [];
        $validated['gallery'] = array_values(array_filter($existingGallery, fn ($path) => ! in_array($path, $removePaths)));
        $galleryNew = $request->file('gallery_new');
        if ($galleryNew && count($galleryNew) > 0) {
            foreach ($galleryNew as $file) {
                $validated['gallery'][] = $file->store('properties', 'public');
            }
        }

        $property->update($validated);

        return redirect()->route('admin.properties.index')->with('success', 'İlan güncellendi.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $property->delete();
        return redirect()->route('admin.properties.index')->with('success', 'İlan silindi.');
    }
}
