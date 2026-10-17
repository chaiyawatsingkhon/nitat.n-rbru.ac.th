<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('สูตรอาหารทั้งหมด') }}
            </h2>
            <a href="{{ route('recipes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                + เพิ่มสูตรอาหาร
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Search Bar --}}
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <form method="GET" action="{{ route('recipes.index') }}" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหานามสูตรอาหาร..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="px-6 py-2 bg-slate-800 text-white rounded-md hover:bg-slate-700">
                        ค้นหา
                    </button>
                </form>
            </div>

            {{-- Recipe Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($recipes as $recipe)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden flex flex-col justify-between">
                        
                        {{-- ส่วนแสดงรูปภาพที่แก้ไขเพื่อดึงจาก public/images/ --}}
                        <div class="w-full h-52 bg-slate-100 overflow-hidden flex items-center justify-center border-b border-slate-100">
                            @php
                                $img = $recipe->image_path ?? $recipe->image_url ?? $recipe->image;
                            @endphp

                            @if(!empty($img) && file_exists(public_path('images/' . $img)))
                                <img src="{{ asset('images/' . $img) }}" alt="{{ $recipe->title ?? $recipe->name }}" class="w-full h-full object-contain p-2 hover:scale-105 transition-transform duration-300">
                            @elseif(!empty($img) && Str::startsWith($img, ['http://', 'https://']))
                                <img src="{{ $img }}" alt="{{ $recipe->title ?? $recipe->name }}" class="w-full h-full object-contain p-2 hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="text-gray-400 text-center">
                                    <div class="text-3xl mb-1">🍳</div>
                                    <span class="text-xs font-semibold">ไม่มีรูปภาพ</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs px-2 py-1 bg-indigo-100 text-indigo-800 rounded">
                                        {{ $recipe->category->name ?? 'ทั่วไป' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $recipe->difficulty_label }}
                                    </span>
                                </div>
                                
                                {{-- ชื่อสูตรอาหาร --}}
                                <h3 class="text-lg font-bold text-gray-900 mb-1">
                                    <a href="{{ route('recipes.show', $recipe) }}" class="hover:text-indigo-600">
                                        {{ $recipe->title ?? $recipe->name }}
                                    </a>
                                </h3>

                                {{-- คำอธิบาย --}}
                                <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                                    {{ $recipe->description }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
                                <span>⏱️ {{ $recipe->total_minutes ?? $recipe->prep_time ?? 15 }} นาที</span>
                                <span>🔥 {{ $recipe->calories_per_serving ?? $recipe->calories ?? 0 }} kcal</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 bg-white rounded-lg text-gray-500">
                        ไม่พบข้อมูลสูตรอาหาร
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div>
                {{ $recipes->links() }}
            </div>

        </div>
    </div>
</x-app-layout>