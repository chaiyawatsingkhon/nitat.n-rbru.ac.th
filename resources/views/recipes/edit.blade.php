<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800">
                ✏️ แก้ไขสูตรอาหาร
            </h2>
            <a href="{{ route('recipes.show', $recipe) }}" class="px-4 py-2 bg-slate-700 text-white font-medium rounded-lg hover:bg-slate-800 transition">
                &larr; ย้อนกลับ
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-md border border-slate-200">
                
                <form action="{{ route('recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- ชื่อสูตรอาหาร --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">ชื่อสูตรอาหาร <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $recipe->name ?? $recipe->title) }}" required class="w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    </div>
                    {{-- URL รูปภาพ --}}
                    {{-- อัปโหลดรูปภาพ --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">อัปโหลดรูปภาพอาหาร</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer">
                        
                        @if($recipe->image_url ?? $recipe->image)
                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-xs text-slate-500">รูปปัจจุบัน:</span>
                                <img src="{{ Str::startsWith($recipe->image_url ?? $recipe->image, 'http') ? ($recipe->image_url ?? $recipe->image) : asset('images/' . ($recipe->image_url ?? $recipe->image)) }}" class="w-12 h-12 object-cover rounded-lg border">
                            </div>
                        @endif
                    </div>

                    {{-- คำอธิบายย่อ --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">คำอธิบายย่อ</label>
                        <textarea name="description" rows="2" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description', $recipe->description) }}</textarea>
                    </div>

                    {{-- หมวดหมู่ & สัญชาติอาหาร --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">หมวดหมู่</label>
                            <select name="category_id" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                <option value="">-- เลือกหมวดหมู่ --</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $recipe->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">สัญชาติอาหาร (Cuisine)</label>
                            <select name="cuisine_id" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                                <option value="">-- เลือกสัญชาติอาหาร --</option>
                                @if(isset($cuisines))
                                    @foreach($cuisines as $cuisine)
                                        <option value="{{ $cuisine->id }}" {{ old('cuisine_id', $recipe->cuisine_id) == $cuisine->id ? 'selected' : '' }}>
                                            {{ $cuisine->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    {{-- เวลา & แคลอรี --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">เวลาเตรียม (นาที)</label>
                            <input type="number" name="prep_time_minutes" value="{{ old('prep_time_minutes', $recipe->prep_time_minutes ?? $recipe->prep_time) }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">เวลาปรุง (นาที)</label>
                            <input type="number" name="cook_time_minutes" value="{{ old('cook_time_minutes', $recipe->cook_time_minutes ?? $recipe->cook_time) }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">แคลอรี (kcal)</label>
                            <input type="number" name="calories_per_serving" value="{{ old('calories_per_serving', $recipe->calories_per_serving ?? $recipe->calories) }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        </div>
                    </div>

                    {{-- วัตถุดิบ & ขั้นตอน --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">วัตถุดิบที่ต้องใช้</label>
                            <textarea name="ingredients" rows="6" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('ingredients', $recipe->ingredients) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">ขั้นตอนการทำ</label>
                            <textarea name="instructions" rows="6" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('instructions', $recipe->instructions) }}</textarea>
                        </div>
                    </div>

                    {{-- ปุ่มบันทึก --}}
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('recipes.show', $recipe) }}" class="px-5 py-2.5 bg-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-300 transition">
                            ยกเลิก
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-amber-500 text-white font-bold rounded-xl hover:bg-amber-600 shadow-md transition">
                            💾 บันทึกข้อมูล
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>