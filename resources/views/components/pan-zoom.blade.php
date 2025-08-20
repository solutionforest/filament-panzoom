@php
    // Universal wrapper - works for forms, infolists, and other contexts
    $wrapperComponent = null;
    $wrapperData = [];
    
    if (method_exists($this, 'getFieldWrapperView')) {
        // Forms context
        $wrapperComponent = $this->getFieldWrapperView();
        $wrapperData = ['field' => $field ?? $this];
    } elseif (method_exists($this, 'getEntryWrapperView')) {
        // Infolist context
        $wrapperComponent = $this->getEntryWrapperView();
        $wrapperData = ['entry' => $entry ?? $this];
    }
@endphp

@if($wrapperComponent)
    <x-dynamic-component :component="$wrapperComponent" :field="$wrapperData['field'] ?? null" :entry="$wrapperData['entry'] ?? null">
@endif
    <div 
        x-data="interactiveImage({{ json_encode($getImageUrl()) }}, '{{ $getImageId() }}', {{ $getDoubleClickZoomLevel() }})"
        class="relative bg-gray-50 rounded-lg border border-gray-200 overflow-hidden w-full"
        style="height: 470px; min-height: 470px; max-height: 470px;"
    >
        <div 
            class="w-full h-full relative"
            x-ref="container"
            @wheel.prevent="zoom"
            @mousemove="pan"
            @mouseup="endPan"
            @mouseleave="endPan"
            @touchmove.prevent="touch"
            @touchend="endTouch"
        >
            <img 
                x-ref="image"
                :src="imageUrl"
                :style="`transform: translate(${panX}px, ${panY}px) scale(${scale}); transform-origin: 0 0; position: absolute; left: 0; top: 0;`"
                :class="isPanning ? 'cursor-grabbing' : 'cursor-grab'"
                class="max-w-none transition-transform duration-75 block select-none"
                style="max-width: none; max-height: none;"
                alt="Image"
                @load="onImageLoad"
                @mousedown="startPan"
                @dblclick="doubleClickZoom"
                @touchstart="startTouch"
                draggable="false"
            />
        </div>

        <div class="absolute top-4 right-4 flex flex-col gap-2 bg-white/90 backdrop-blur-sm rounded-lg p-2 shadow-lg">
            <button 
                @click="zoomIn"
                class="w-8 h-8 flex items-center justify-center bg-white hover:bg-gray-50 border border-gray-200 rounded text-gray-600 hover:text-gray-800 transition-colors"
                title="Zoom In"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </button>
            
            <button 
                @click="zoomOut"
                class="w-8 h-8 flex items-center justify-center bg-white hover:bg-gray-50 border border-gray-200 rounded text-gray-600 hover:text-gray-800 transition-colors"
                title="Zoom Out"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
            </button>
            
            <button 
                @click="reset"
                class="w-8 h-8 flex items-center justify-center bg-white hover:bg-gray-50 border border-gray-200 rounded text-gray-600 hover:text-gray-800 transition-colors"
                title="Reset View"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </button>
        </div>

        <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm rounded-lg px-3 py-1 shadow-lg text-sm text-gray-600">
            <span x-text="`${Math.round(scale * 100)}%`"></span>
        </div>
    </div>

@if($wrapperComponent)
    </x-dynamic-component>
@endif
