<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        return view('admin.properties.create', ['defaultPropertyType' => $defaultType]);
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
            'city' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'lokasyon' => ['nullable', 'string'],
            'rooms' => ['nullable', 'integer', 'min:0', 'max:50'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:20'],
            'area_sqm' => ['nullable', 'integer', 'min:0'],
            'area_brut' => ['nullable', 'integer', 'min:0'],
            'price_per_sqm' => ['nullable', 'numeric', 'min:0'],
            'bina_yasi' => ['nullable', 'string', 'max:50'],
            'bulundugu_kat' => ['nullable', 'string', 'max:20'],
            'kat_sayisi' => ['nullable', 'integer', 'min:0', 'max:255'],
            'isitma' => ['nullable', 'string', 'max:100'],
            'mutfak' => ['nullable', 'string', 'max:100'],
            'balkon' => ['nullable', 'string', 'max:100'],
            'asansor' => ['nullable', 'boolean'],
            'otopark' => ['nullable', 'string', 'max:100'],
            'esyali' => ['nullable', 'boolean'],
            'kullanim_durumu' => ['nullable', 'string', 'max:100'],
            'site_icerisinde' => ['nullable', 'boolean'],
            'site_adi' => ['nullable', 'string', 'max:255'],
            'aidat' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
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
        $validated['user_id'] = $request->user()->id;
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['krediye_uygunluk'] = $request->boolean('krediye_uygunluk');
        $validated['takas'] = $request->boolean('takas');
        $validated['asansor'] = $request->boolean('asansor');
        $validated['esyali'] = $request->boolean('esyali');
        $validated['site_icerisinde'] = $request->boolean('site_icerisinde');
        $validated['ilan_detay'] = $request->filled('ilan_detay') ? json_decode($request->ilan_detay, true) : null;
        $validated['arsa_ozellikler'] = $request->filled('arsa_ozellikler') ? json_decode($request->arsa_ozellikler, true) : null;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('properties', 'public');
        }

        Property::create($validated);

        return redirect()->route('admin.properties.index')->with('success', 'İlan başarıyla eklendi.');
    }

    public function edit(Property $property): View
    {
        return view('admin.properties.edit', compact('property'));
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
            'city' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'lokasyon' => ['nullable', 'string'],
            'rooms' => ['nullable', 'integer', 'min:0', 'max:50'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:20'],
            'area_sqm' => ['nullable', 'integer', 'min:0'],
            'area_brut' => ['nullable', 'integer', 'min:0'],
            'price_per_sqm' => ['nullable', 'numeric', 'min:0'],
            'bina_yasi' => ['nullable', 'string', 'max:50'],
            'bulundugu_kat' => ['nullable', 'string', 'max:20'],
            'kat_sayisi' => ['nullable', 'integer', 'min:0', 'max:255'],
            'isitma' => ['nullable', 'string', 'max:100'],
            'mutfak' => ['nullable', 'string', 'max:100'],
            'balkon' => ['nullable', 'string', 'max:100'],
            'asansor' => ['nullable', 'boolean'],
            'otopark' => ['nullable', 'string', 'max:100'],
            'esyali' => ['nullable', 'boolean'],
            'kullanim_durumu' => ['nullable', 'string', 'max:100'],
            'site_icerisinde' => ['nullable', 'boolean'],
            'site_adi' => ['nullable', 'string', 'max:255'],
            'aidat' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
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
        $validated['krediye_uygunluk'] = $request->boolean('krediye_uygunluk');
        $validated['takas'] = $request->boolean('takas');
        $validated['asansor'] = $request->boolean('asansor');
        $validated['esyali'] = $request->boolean('esyali');
        $validated['site_icerisinde'] = $request->boolean('site_icerisinde');
        $validated['ilan_detay'] = $request->filled('ilan_detay') ? json_decode($request->ilan_detay, true) : null;
        $validated['arsa_ozellikler'] = $request->filled('arsa_ozellikler') ? json_decode($request->arsa_ozellikler, true) : null;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('properties', 'public');
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
