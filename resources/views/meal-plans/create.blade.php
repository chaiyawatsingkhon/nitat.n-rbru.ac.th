<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('สร้างแผนมื้ออาหารใหม่') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <form method="POST" action="{{ route('meal-plans.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="title" value="ชื่อแผนมื้ออาหาร" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ old('title') }}" placeholder="เช่น แผนอาหารคลีนสัปดาห์นี้" required />
                    </div>

                    <div>
                        <x-input-label for="plan_date" value="วันที่จัดแผน" />
                        <x-text-input id="plan_date" name="plan_date" type="date" class="mt-1 block w-full" value="{{ old('plan_date', date('Y-m-d')) }}" required />
                    </div>

                    <div>
                        <x-input-label for="note" value="บันทึกเพิ่มเติม" />
                        <textarea id="note" name="note" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3">{{ old('note') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('meal-plans.index') }}" class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">ยกเลิก</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">สร้างแผนมื้ออาหาร</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>