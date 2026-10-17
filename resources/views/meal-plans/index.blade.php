<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('แผนมื้ออาหารของฉัน') }}
            </h2>
            <a href="{{ route('meal-plans.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-xs uppercase hover:bg-indigo-700">
                + สร้างแผนมื้ออาหาร
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($mealPlans as $plan)
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">
                                <a href="{{ route('meal-plans.show', $plan) }}" class="hover:underline">
                                    {{ $plan->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500 mb-4">วันที่: {{ $plan->plan_date }}</p>
                            <p class="text-sm text-gray-600">จำนวนเมนูในแผน: {{ $plan->recipes->count() }} เมนู</p>
                        </div>
                        <a href="{{ route('meal-plans.show', $plan) }}" class="text-indigo-600 hover:underline text-sm font-semibold">ดูรายละเอียด &rarr;</a>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 bg-white rounded-lg text-gray-500">
                        ยังไม่มีแผนมื้ออาหาร
                    </div>
                @endforelse
            </div>
            <div class="mt-6">{{ $mealPlans->links() }}</div>
        </div>
    </div>
</x-app-layout>