<div class="w-full flex items-center">
    <div class="w-full flex flex-col items-start justify-center bg-white rounded-lg border border-gray-300 p-4">
        <h3 class="mb-2 font-medium">Clienti</h3>
        <div class="w-full flex justify-center">
            <div class="h-[250px] w-[550px]">
                <canvas id="clientsLineChart" class="h-full w-full"></canvas>
            </div>
        </div>
    </div>
</div>

@script
<script>
    const ctx = document.getElementById('clientsLineChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Clienti cumulativi',
                data: @json($data),
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34,197,94,0.2)',
                fill: true,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            if (Number.isInteger(value)) {
                                return value;
                            }
                        }
                    }
                }
            }
        }
    });
</script>
@endscript
