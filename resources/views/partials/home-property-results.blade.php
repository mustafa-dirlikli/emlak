@php
    $featuredProperties = $featuredProperties ?? new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
@endphp
<div class="row mb-5" id="home-property-cards">
    @include('partials.home-property-cards', ['featuredProperties' => $featuredProperties, 'layout' => $layout ?? 'card'])
</div>
@if($featuredProperties->hasPages())
<div class="row">
    <div class="col-md-12 text-center">
        <div class="site-pagination">
            {{ $featuredProperties->links() }}
        </div>
    </div>
</div>
@endif
