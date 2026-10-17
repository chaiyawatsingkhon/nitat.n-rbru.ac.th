<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    // หน้ารายงาน: กราฟแท่ง (สูตรต่อหมวดหมู่) และกราฟโดนัท (สัดส่วนโปรตีน/คาร์บ/ไขมันของแผน)
    public function index(Request $request): View
    {
        $user = $request->user();

        // --- Bar Chart: จำนวนสูตรของผู้ใช้ในแต่ละหมวดหมู่ ---
        $categoryStats = Category::withCount([
            'recipes' => fn ($q) => $q->where('user_id', $user->id),
        ])->orderBy('name')->get();

        $barLabels = $categoryStats->pluck('name');
        $barData   = $categoryStats->pluck('recipes_count');

        // --- Doughnut Chart: โภชนาการรวมของแผนที่เลือก (ค่าเริ่มต้นคือแผนล่าสุด) ---
        $plans    = $user->mealPlans()->orderByDesc('plan_date')->get();
        $selected = $plans->firstWhere('id', $request->integer('plan')) ?? $plans->first();
        $totals   = null;

        if ($selected) {
            $selected->load('recipes');
            $totals = $selected->nutritionTotals();
        }

        // --- ตัวเลขสรุปด้านบน ---
        $summary = [
            'recipes'      => $user->recipes()->count(),
            'plans'        => $plans->count(),
            'avg_calories' => round($user->recipes()->avg('calories') ?? 0),
        ];

        return view('reports.index', compact('barLabels', 'barData', 'plans', 'selected', 'totals', 'summary'));
    }
}
