<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Online Store</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .icon-box { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 10px; font-size: 24px; color: white; }
        .bg-primary-light { background-color: #0d6efd; }
        .bg-success-light { background-color: #198754; }
        .bg-warning-light { background-color: #ffc107; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Store Dashboard</h2>
        <span class="text-muted">Welcome back, Admin!</span>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card card-custom p-4 d-flex flex-row align-items-center">
                <div class="icon-box bg-primary-light me-3">💰</div>
                <div>
                    <h6 class="text-muted mb-1">Total Sales</h6>
                    <h4 class="mb-0 fw-bold">${{ number_format($totalSales, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom p-4 d-flex flex-row align-items-center">
                <div class="icon-box bg-success-light me-3">📦</div>
                <div>
                    <h6 class="text-muted mb-1">Total Orders</h6>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalOrders) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom p-4 d-flex flex-row align-items-center">
                <div class="icon-box bg-warning-light me-3">👥</div>
                <div>
                    <h6 class="text-muted mb-1">Total Customers</h6>
                    <h4 class="mb-0 fw-bold">{{ number_format($totalCustomers) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row g-4 mb-4">
        <!-- Monthly Sales Line Chart -->
        <div class="col-md-8">
            <div class="card card-custom p-4 h-100">
                <h5 class="fw-bold mb-4">Monthly Sales</h5>
                <canvas id="monthlySalesChart" height="100"></canvas>
            </div>
        </div>
        <!-- Sales by Category Doughnut Chart -->
        <div class="col-md-4">
            <div class="card card-custom p-4 h-100">
                <h5 class="fw-bold mb-4">Sales by Category</h5>
                <canvas id="categorySalesChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row g-4 mb-4">
        <!-- Top Products Bar Chart -->
        <div class="col-md-12">
            <div class="card card-custom p-4">
                <h5 class="fw-bold mb-4">Top 10 Best-Selling Products</h5>
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Data passed from controller
    const monthlySalesData = @json($monthlySales);
    const categorySalesData = @json($salesByCategory);
    const topProductsData = @json($topProducts);

    // 1. Monthly Sales Line Chart
    const msCtx = document.getElementById('monthlySalesChart').getContext('2d');
    new Chart(msCtx, {
        type: 'line',
        data: {
            labels: monthlySalesData.map(item => item.month),
            datasets: [{
                label: 'Sales ($)',
                data: monthlySalesData.map(item => item.total),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // 2. Sales by Category Doughnut Chart
    const csCtx = document.getElementById('categorySalesChart').getContext('2d');
    new Chart(csCtx, {
        type: 'doughnut',
        data: {
            labels: categorySalesData.map(item => item.name),
            datasets: [{
                data: categorySalesData.map(item => item.total_sales),
                backgroundColor: [
                    '#0d6efd', '#6610f2', '#6f42c1', '#d63384', '#dc3545',
                    '#fd7e14', '#ffc107', '#198754', '#20c997', '#0dcaf0'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'right' }
            }
        }
    });

    // 3. Top Products Bar Chart
    const tpCtx = document.getElementById('topProductsChart').getContext('2d');
    new Chart(tpCtx, {
        type: 'bar',
        data: {
            labels: topProductsData.map(item => item.name.length > 30 ? item.name.substring(0, 30) + '...' : item.name),
            datasets: [{
                label: 'Quantity Sold',
                data: topProductsData.map(item => item.total_quantity),
                backgroundColor: '#198754',
                borderRadius: 5
            }]
        },
        options: {
            indexAxis: 'y', // Convert to horizontal bar chart
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true }
            }
        }
    });
</script>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
