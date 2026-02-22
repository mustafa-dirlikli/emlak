@php
    $apiKey = config('services.google_maps.api_key');
    $lat = $latitude ?? null;
    $lng = $longitude ?? null;
    $defaultLat = 39.9334;
    $defaultLng = 32.8597;
@endphp
<div class="form-group mb-3">
    <label>Konum (Google Haritalar)</label>
    <p class="text-muted small mb-2">Adres arayın veya haritada bir noktaya tıklayarak konum seçin. Seçilen adres isteğe bağlı olarak Lokasyon alanına yazılır.</p>
    @if($apiKey)
        <input type="text" id="property-map-search" class="form-control mb-2" placeholder="Adres veya yer ara..." autocomplete="off">
        <input type="hidden" name="latitude" id="property-latitude" value="{{ $lat ? (float)$lat : '' }}">
        <input type="hidden" name="longitude" id="property-longitude" value="{{ $lng ? (float)$lng : '' }}">
        <div id="property-map-canvas" style="width:100%; height:320px; background:#e9ecef; border-radius:6px;"></div>
    @else
        <p class="text-warning mb-0">Google Haritalar kullanmak için <code>.env</code> dosyasına <code>GOOGLE_MAPS_API_KEY</code> ekleyin.</p>
        <input type="hidden" name="latitude" value="{{ $lat ? (float)$lat : '' }}">
        <input type="hidden" name="longitude" value="{{ $lng ? (float)$lng : '' }}">
    @endif
</div>

@if($apiKey)
@push('scripts')
<script>
window.initPropertyMapPicker = function() {
    var initialLat = @json($lat ? (float)$lat : null);
    var initialLng = @json($lng ? (float)$lng : null);
    var defaultLat = {{ $defaultLat }};
    var defaultLng = {{ $defaultLng }};
    var latInput = document.getElementById('property-latitude');
    var lngInput = document.getElementById('property-longitude');
    var lokasyonEl = document.getElementById('lokasyon');
    var searchInput = document.getElementById('property-map-search');
    if (!latInput || !lngInput) return;
    var center = (initialLat && initialLng) ? { lat: initialLat, lng: initialLng } : { lat: defaultLat, lng: defaultLng };
    var map = new google.maps.Map(document.getElementById('property-map-canvas'), {
        zoom: initialLat && initialLng ? 15 : 10,
        center: center,
        mapTypeControl: true,
        streetViewControl: false,
        fullscreenControl: true,
    });
    var marker = new google.maps.Marker({
        position: center,
        map: map,
        draggable: true,
    });
    function updateFromPosition(latLng) {
        latInput.value = latLng.lat();
        lngInput.value = latLng.lng();
        marker.setPosition(latLng);
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: latLng }, function(results, status) {
            if (status === 'OK' && results[0] && lokasyonEl) lokasyonEl.value = results[0].formatted_address;
        });
    }
    map.addListener('click', function(e) { updateFromPosition(e.latLng); });
    marker.addListener('dragend', function() { updateFromPosition(marker.getPosition()); });
    var autocomplete = new google.maps.places.Autocomplete(searchInput, {
        fields: ['geometry', 'formatted_address'],
        types: ['address', 'establishment'],
    });
    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if (!place.geometry || !place.geometry.location) return;
        var loc = place.geometry.location;
        map.setCenter(loc);
        map.setZoom(16);
        marker.setPosition(loc);
        latInput.value = loc.lat();
        lngInput.value = loc.lng();
        if (lokasyonEl) lokasyonEl.value = place.formatted_address || '';
    });
};
(function() {
    var apiKey = @json($apiKey);
    if (typeof google !== 'undefined' && google.maps && google.maps.places) {
        window.initPropertyMapPicker();
    } else {
        var s = document.createElement('script');
        s.src = 'https://maps.googleapis.com/maps/api/js?key=' + apiKey + '&libraries=places&callback=initPropertyMapPicker';
        s.async = true;
        s.defer = true;
        document.head.appendChild(s);
    }
})();
</script>
@endpush
@endif
