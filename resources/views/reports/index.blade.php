<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('รายงานสรุปโภชนาการ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="p-4 bg-indigo-50 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">แคลอรีสะสมทั้งหมด</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ number_format($totalCalories ?? 0) }} kcal</p>
                </div>
                <div class="p-4 bg-green-50 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">จำนวนแผนมื้ออาหาร</p>
                    <p class="text-3xl font-bold text-green-600">{{ $totalPlans ?? 0 }} แผน</p>
                </div>
                <div class="p-4 bg-yellow-50 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">สูตรอาหารที่ถูกบันทึก</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $totalRecipes ?? 0 }} สูตร</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>