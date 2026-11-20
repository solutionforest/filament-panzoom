@include('filament-panzoom::components.pan-zoom-image', [
    'imageUrl' => $getImageUrl(),
    'imageId' => $getImageId(),
    'doubleClickZoomLevel' => $getDoubleClickZoomLevel(),
    'alt' => 'Receipt Image',
])
