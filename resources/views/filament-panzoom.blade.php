@include('filament-panzoom::components.pan-zoom-image', [
    'imageUrl' => $imageUrl,
    'imageId' => $imageId,
    'doubleClickZoomLevel' => $doubleClickZoomLevel ?? 3.0,
    'alt' => 'Receipt Image',
])
