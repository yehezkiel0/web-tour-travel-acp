<div id="virtual-tour" class="tab-pane hidden">
    <div class="space-y-6">
        <h3 class="text-xl sm:text-2xl font-semibold text-gray-1">360° Virtual Tour</h3>

        <div id="panorama"
            class="w-full h-[300px] sm:h-[400px] lg:h-[500px] rounded-2xl overflow-hidden shadow-lg border border-gray-200 relative group">
            <div
                class="absolute inset-0 flex items-center justify-center pointer-events-none z-10 bg-black bg-opacity-20 group-hover:bg-opacity-0 transition-all duration-500">
                <i class="fas fa-arrows-alt text-white text-4xl opacity-70 drop-shadow-lg"></i>
            </div>
        </div>

        @if (isset($destination->virtual_tour_images) && count($destination->virtual_tour_images) > 1)
            <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
                @foreach ($destination->virtual_tour_images as $index => $image)
                    <button onclick="loadScene('{{ Storage::url($image) }}')"
                        class="relative flex-shrink-0 w-24 h-24 rounded-lg overflow-hidden border-2 border-transparent hover:border-primary transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <img src="{{ Storage::url($image) }}" class="w-full h-full object-cover"
                            alt="Scene {{ $index + 1 }}">
                        <div class="absolute inset-0 bg-black bg-opacity-30 hover:bg-opacity-0 transition-all"></div>
                    </button>
                @endforeach
            </div>
            <p class="text-xs text-gray-500 text-center"><i class="fas fa-info-circle mr-1"></i>Click thumbnails to
                switch scenes</p>
        @endif

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800 flex items-start">
            <i class="fas fa-vr-cardboard text-xl mr-3 mt-1"></i>
            <div>
                <p class="font-semibold">Interactive Experience</p>
                <p>Drag to look around. Scroll to zoom in/out. Immerse yourself in the destination before you go!</p>
            </div>
        </div>
    </div>
</div>
