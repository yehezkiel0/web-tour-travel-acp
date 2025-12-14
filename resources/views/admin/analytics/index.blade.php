@extends('admin.layout.app')

@section('content')
    @include('admin.layout.sidebar')
    @include('admin.layout.nav')

    <div class="content-wrapper transition-all ease-in-out duration-700">
        <div class="flex flex-col gap-y-2">
            <div class="bg-white p-5 mb-4 flex items-center justify-between rounded-sm shadow-md">
                <h1 class="text-xl lg:text-2xl font-medium mt-1 text-gray-700">Analytics Dashboard</h1>
                <span class="text-sm text-gray-500">Data for Year: {{ $currentYear }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 px-4 pb-8">

                {{-- Revenue Chart --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Monthly Revenue</h3>
                    <div class="relative h-72">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                {{-- Booking Status Chart --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Booking Status Distribution</h3>
                    <div class="relative h-72 flex justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                {{-- User Growth Chart --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">User Growth (Last 6 Months)</h3>
                    <div class="relative h-72">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>

                {{-- Top Destinations Chart --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Top 5 Destinations</h3>
                    <div class="relative h-72">
                        <canvas id="topDestChart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue (IDR)',
                    data: @json($monthlyRevenue),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Booking Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Paid', 'Completed', 'Cancelled'],
                datasets: [{
                    data: @json($statusCounts),
                    backgroundColor: [
                        'rgb(251, 191, 36)', // Amber (Pending)
                        'rgb(34, 197, 94)', // Green (Paid)
                        'rgb(59, 130, 246)', // Blue (Completed)
                        'rgb(239, 68, 68)' // Red (Cancelled)
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // User Growth Chart
        const userCtx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(userCtx, {
            type: 'bar',
            data: {
                labels: @json($userGrowthLabels),
                datasets: [{
                    label: 'New Users',
                    data: @json($userGrowthData),
                    backgroundColor: 'rgb(168, 85, 247)',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Top Destinations Chart
        const destLabels = @json($topDestinations->pluck('name'));
        const destData = @json($topDestinations->pluck('count'));

        const topDestCtx = document.getElementById('topDestChart').getContext('2d');
        new Chart(topDestCtx, {
            type: 'bar',
            data: {
                labels: destLabels,
                datasets: [{
                    label: 'Bookings',
                    data: destData,
                    backgroundColor: 'rgb(14, 165, 233)',
                    borderRadius: 4,
                    indexAxis: 'y' // Horizontal bar
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
