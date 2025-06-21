<!DOCTYPE html>
<html>
<head>
    <title>Finance Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">📊 Personal Finance Dashboard</h2>
    <canvas id="expenseChart" width="400" height="200"></canvas>
    <form method="POST" action="/analyze">
        @csrf
        <button class="btn btn-success mt-4">Get Smart Saving Tips 💡</button>
    </form>
    @if(isset($tips))
        <div class="alert alert-info mt-4"><strong>Smart Tips:</strong><br>{{ $tips }}</div>
    @endif
</div>
<script>
    const ctx = document.getElementById('expenseChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($expenses)) !!},
            datasets: [{
                label: 'Expenses',
                data: {!! json_encode(array_values($expenses)) !!},
                backgroundColor: ['#4e73df','#1cc88a','#36b9cc','#f6c23e']
            }]
        }
    });
</script>
</body>
</html>
