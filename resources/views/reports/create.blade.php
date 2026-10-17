<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800">
                ➕ เพิ่มสูตรอาหารใหม่
            </h2>
            <a href="{{ route('recipes.index') }}" class="px-4 py-2 bg-slate-700 text-white font-medium rounded-lg hover:bg-slate-800 transition">
                &larr; ย้อนกลับ
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-md border border-slate-200">

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                        <p class="font-bold mb-1">กรุณาตรวจสอบข้อมูลอีกครั้ง:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- ชื่อสูตร --}}
                    <div>
                        <label for="title" class="block text-sm font-bold text-slate-700 mb-1">ชื่อสูตรอาหาร <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="เช่น ผัดกะเพราไก่ไข่ดาว" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- คำอธิบายอย่างย่อ --}}
                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-700 mb-1">คำอธิบายอย่างย่อ</label>
                        <textarea name="description" id="description" rows="2" placeholder="เช่น เมนูยอดฮิต รสจัดจ้าน ทำง่าย อร่อยรวดเร็ว" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                    </div>

                    {{-- หมวดหมู่ & ประเภทอาหาร --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category_id" class="block text-sm font-bold text-slate-700 mb-1">หมวดหมู่ <span class="text-red-500">*</span></label>
                            <select name="category_id" id="category_id" required class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- เลือกหมวดหมู่ --</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="cuisine_id" class="block text-sm font-bold text-slate-700 mb-1">ประเภทอาหาร</label>
                            <select name="cuisine_id" id="cuisine_id" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- เลือกประเภทอาหาร --</option>
                                @foreach($cuisines ?? [] as $cuisine)
                                    <option value="{{ $cuisine->id }}" {{ old('cuisine_id') == $cuisine->id ? 'selected' : '' }}>
                                        {{ $cuisine->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- รูปภาพ --}}
                    <div>
                        <label for="image" class="block text-sm font-bold text-slate-700 mb-1">รูปภาพอาหาร</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    {{-- เวลาเตรียม, เวลาปรุง, จำนวนเสิร์ฟ, ความยาก --}}
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <div>
                            <label for="prep_time" class="block text-sm font-bold text-slate-700 mb-1">เวลาเตรียม (นาที)</label>
                            <input type="number" name="prep_time" id="prep_time" value="{{ old('prep_time', 10) }}" min="0" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="cook_time" class="block text-sm font-bold text-slate-700 mb-1">เวลาปรุง (นาที)</label>
                            <input type="number" name="cook_time" id="cook_time" value="{{ old('cook_time', 15) }}" min="0" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="servings" class="block text-sm font-bold text-slate-700 mb-1">จำนวนเสิร์ฟ <span class="text-red-500">*</span></label>
                            <input type="number" name="servings" id="servings" value="{{ old('servings', 1) }}" min="1" required class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="difficulty" class="block text-sm font-bold text-slate-700 mb-1">ระดับความยาก <span class="text-red-500">*</span></label>
                            <select name="difficulty" id="difficulty" required class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>ง่าย (Easy)</option>
                                <option value="medium" {{ old('difficulty', 'medium') == 'medium' ? 'selected' : '' }}>ปานกลาง (Medium)</option>
                                <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>ยาก (Hard)</option>
                            </select>
                        </div>
                    </div>

                    {{-- ข้อมูลโภชนาการ (Calories & Macros) --}}
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <h4 class="font-bold text-sm text-slate-700 mb-3">📊 ข้อมูลโภชนาการ (ต่อเสิร์ฟ)</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                            <div>
                                <label for="calories" class="block text-xs font-semibold text-slate-600 mb-1">แคลอรี (kcal)</label>
                                <input type="number" name="calories" id="calories" value="{{ old('calories', 0) }}" min="0" class="w-full text-sm rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="protein_g" class="block text-xs font-semibold text-slate-600 mb-1">โปรตีน (g)</label>
                                <input type="number" step="0.1" name="protein_g" id="protein_g" value="{{ old('protein_g', 0) }}" min="0" class="w-full text-sm rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="carbs_g" class="block text-xs font-semibold text-slate-600 mb-1">คาร์บ (g)</label>
                                <input type="number" step="0.1" name="carbs_g" id="carbs_g" value="{{ old('carbs_g', 0) }}" min="0" class="w-full text-sm rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="fat_g" class="block text-xs font-semibold text-slate-600 mb-1">ไขมัน (g)</label>
                                <input type="number" step="0.1" name="fat_g" id="fat_g" value="{{ old('fat_g', 0) }}" min="0" class="w-full text-sm rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="fiber_g" class="block text-xs font-semibold text-slate-600 mb-1">ใยอาหาร (g)</label>
                                <input type="number" step="0.1" name="fiber_g" id="fiber_g" value="{{ old('fiber_g', 0) }}" min="0" class="w-full text-sm rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    {{-- วัตถุดิบ --}}
                    <div>
                        <label for="ingredients" class="block text-sm font-bold text-slate-700 mb-1">วัตถุดิบที่ต้องใช้ <span class="text-red-500">*</span></label>
                        <textarea name="ingredients" id="ingredients" rows="4" required placeholder="อกไก่สับ 150 กรัม&#10;ใบกะเพรา 1 กำมือ&#10;พริก 5 เม็ด" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('ingredients') }}</textarea>
                    </div>

                    {{-- ขั้นตอนการทำ --}}
                    <div>
                        <label for="instructions" class="block text-sm font-bold text-slate-700 mb-1">ขั้นตอนการทำ <span class="text-red-500">*</span></label>
                        <textarea name="instructions" id="instructions" rows="4" required placeholder="1. โขลกพริกกระเทียม&#10;2. ผัดกับน้ำมันจนหอม" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('instructions') }}</textarea>
                    </div>

                    {{-- แท็ก & สถานะเผยแพร่ --}}
                    <div class="space-y-4">
                        @if(isset($tags) && count($tags) > 0)
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">แท็ก</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($tags as $tag)
                                        <label class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-700 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-xl cursor-pointer hover:bg-slate-100">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                                            #{{ $tag->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public', 1) ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                            <label for="is_public" class="text-sm font-bold text-slate-700 cursor-pointer">🌐 เผยแพร่สูตรนี้เป็นสาธารณะ</label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-200 flex justify-end gap-3">
                        <a href="{{ route('recipes.index') }}" class="px-6 py-2.5 bg-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-300 transition">
                            ยกเลิก
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                            💾 บันทึกสูตรอาหาร
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>