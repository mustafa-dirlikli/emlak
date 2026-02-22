<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyListingController extends Controller
{
    public function show(Property $property): View
    {
        if (! $property->is_active) {
            abort(404);
        }

        return view('properties.show', compact('property'));
    }

    public function index(Request $request): View
    {
        $properties = Property::where('is_active', true)
            ->when($request->type, fn ($q, $v) => $q->where('property_type', $v))
            ->when($request->offer === 'sale', fn ($q) => $q->where('listing_type', 'sale'))
            ->when($request->offer === 'rent', fn ($q) => $q->where('listing_type', 'rent'))
            ->when($request->city, fn ($q, $v) => $q->where('city', 'like', '%'.$v.'%'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('properties', compact('properties'));
    }

    public function home(Request $request): View
    {
        $query = Property::where('is_active', true)
            ->when($request->type, fn ($q, $v) => $q->where('property_type', $v))
            ->when($request->offer === 'sale', fn ($q) => $q->where('listing_type', 'sale'))
            ->when($request->offer === 'rent', fn ($q) => $q->where('listing_type', 'rent'))
            ->when($request->city, fn ($q, $v) => $q->where('city', 'like', '%'.$v.'%'));
        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }
        $featuredProperties = $query->take(6)->get();

        return view('home', compact('featuredProperties'));
    }

    /** Filtrelenmiş ilan kartları (AJAX, sayfa yenilemeden) */
    public function homeFilter(Request $request)
    {
        $query = Property::where('is_active', true)
            ->when($request->type, fn ($q, $v) => $q->where('property_type', $v))
            ->when($request->offer === 'sale', fn ($q) => $q->where('listing_type', 'sale'))
            ->when($request->offer === 'rent', fn ($q) => $q->where('listing_type', 'rent'))
            ->when($request->city, fn ($q, $v) => $q->where('city', 'like', '%'.$v.'%'));
        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }
        $featuredProperties = $query->take(6)->get();

        return response()->view('partials.home-property-cards', compact('featuredProperties'))->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function buy(Request $request): View
    {
        $properties = Property::where('is_active', true)
            ->where('listing_type', 'sale')
            ->when($request->type, fn ($q, $v) => $q->where('property_type', $v))
            ->when($request->city, fn ($q, $v) => $q->where('city', 'like', '%'.$v.'%'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('buy', compact('properties'));
    }

    public function rent(Request $request): View
    {
        $properties = Property::where('is_active', true)
            ->where('listing_type', 'rent')
            ->when($request->type, fn ($q, $v) => $q->where('property_type', $v))
            ->when($request->city, fn ($q, $v) => $q->where('city', 'like', '%'.$v.'%'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('rent', compact('properties'));
    }
}
