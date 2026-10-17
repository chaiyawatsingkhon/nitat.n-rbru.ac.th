<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 flex items-center gap-2">
                📖 {{ $recipe->name ?? $recipe->title }}
            </h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('recipes.edit', $recipe) }}" class="px-4 py-2 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition shadow-sm">
                    ✏️ แก้ไขสูตรอาหาร
                </a>
                <a href="{{ route('recipes.index') }}" class="px-4 py-2 bg-slate-700 text-white font-medium rounded-lg hover:bg-slate-800 transition">
                    &larr; ย้อนกลับ
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- การ์ดข้อมูลหลัก --}}
            <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-200 grid grid-cols-1 md:grid-cols-12 gap-6">
                
                {{-- รูปภาพ (ฝั่งซ้าย 5 คอลัมน์) --}}
                <div class="md:col-span-5 bg-orange-50 rounded-xl p-3 flex items-center justify-center border border-orange-200 h-full min-h-[340px]">
                    @php
                        $img = $recipe->image_path ?? $recipe->image_url ?? $recipe->image;
                    @endphp

                    @if(!empty($img) && file_exists(public_path('images/' . $img)))
                        <img src="{{ asset('images/' . $img) }}" 
                             alt="{{ $recipe->name ?? $recipe->title }}" 
                             class="w-full h-80 object-contain rounded-xl shadow-sm bg-white p-2 border border-orange-100">
                    @elseif(!empty($img) && Str::startsWith($img, ['http://', 'https://']))
                        <img src="{{ $img }}" 
                             alt="{{ $recipe->name ?? $recipe->title }}" 
                             class="w-full h-80 object-contain rounded-xl shadow-sm bg-white p-2 border border-orange-100">
                    @else
                        <div class="text-center text-orange-400 py-8">
                            <div class="text-6xl mb-2">🍳</div>
                            <p class="text-sm font-bold">ยังไม่ได้ใส่ลิงก์รูปภาพ</p>
                        </div>
                    @endif
                </div>

                {{-- รายละเอียดเนื้อหาฝั่งขวา (ฝั่งขวา 7 คอลัมน์) --}}
                <div class="md:col-span-7 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex gap-2 mb-3">
                            <span class="px-3 py-1 bg-orange-500 text-white rounded-full text-xs font-bold shadow-sm">
                                {{ $recipe->category->name ?? 'อาหารทั่วไป' }}
                            </span>
                            <span class="px-3 py-1 bg-emerald-500 text-white rounded-full text-xs font-bold shadow-sm">
                                {{ $recipe->cuisine->name ?? 'นานาชาติ' }}
                            </span>
                        </div>

                        <h1 class="text-3xl font-extrabold text-slate-900 mb-2">
                            {{ $recipe->name ?? $recipe->title }}
                        </h1>
                        <p class="text-slate-600 text-base leading-relaxed">
                            {{ $recipe->description }}
                        </p>

                        @if(!empty($recipe->tags) && count($recipe->tags) > 0)
                            <div class="flex flex-wrap gap-2 mt-4">
                                @foreach($recipe->tags as $tag)
                                    <span class="px-3 py-1 bg-rose-100 text-rose-700 border border-rose-200 rounded-lg text-xs font-semibold">
                                        #{{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- บล็อกสรุปข้อมูล 4 ช่อง --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-slate-200 text-center">
                        <div class="p-3 bg-amber-100 rounded-xl border border-amber-300 shadow-sm">
                            <p class="text-xs text-amber-800 font-bold">⏱️ เตรียม</p>
                            <p class="text-lg font-extrabold text-amber-950 mt-1">{{ $recipe->prep_time_minutes ?? $recipe->prep_time ?? 10 }} นาที</p>
                        </div>
                        <div class="p-3 bg-orange-100 rounded-xl border border-orange-300 shadow-sm">
                            <p class="text-xs text-orange-800 font-bold">🔥 ปรุง</p>
                            <p class="text-lg font-extrabold text-orange-950 mt-1">{{ $recipe->cook_time_minutes ?? $recipe->cook_time ?? 15 }} นาที</p>
                        </div>
                        <div class="p-3 bg-emerald-100 rounded-xl border border-emerald-300 shadow-sm">
                            <p class="text-xs text-emerald-800 font-bold">🌱 พลังงาน</p>
                            <p class="text-lg font-extrabold text-emerald-950 mt-1">{{ $recipe->calories_per_serving ?? $recipe->calories ?? 0 }} kcal</p>
                        </div>
                        <div class="p-3 bg-indigo-100 rounded-xl border border-indigo-300 shadow-sm">
                            <p class="text-xs text-indigo-800 font-bold">⭐ ความยาก</p>
                            <p class="text-lg font-extrabold text-indigo-950 mt-1">{{ $recipe->difficulty_label ?? 'ง่าย' }}</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- วัตถุดิบ & วิธีทำ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- วัตถุดิบ --}}
                <div class="bg-white p-6 rounded-2xl shadow-md border-2 border-emerald-300">
                    <h3 class="text-xl font-bold text-emerald-900 pb-3 mb-4 border-b border-emerald-200 flex items-center gap-2">
                        🥗 วัตถุดิบที่ต้องใช้
                    </h3>
                    <div class="text-slate-800 whitespace-pre-line leading-relaxed text-base bg-emerald-50 p-4 rounded-xl border border-emerald-200 font-medium">
                        {{ $recipe->ingredients }}
                    </div>
                </div>

                {{-- ขั้นตอนการทำ --}}
                <div class="bg-white p-6 rounded-2xl shadow-md border-2 border-orange-300">
                    <h3 class="text-xl font-bold text-orange-900 pb-3 mb-4 border-b border-orange-200 flex items-center gap-2">
                        🍳 ขั้นตอนการทำ
                    </h3>
                    <div class="text-slate-800 whitespace-pre-line leading-relaxed text-base bg-orange-50 p-4 rounded-xl border border-orange-200 font-medium">
                        {{ $recipe->instructions }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>