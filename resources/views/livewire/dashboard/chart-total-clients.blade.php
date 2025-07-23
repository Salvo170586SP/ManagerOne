<div class="w-full flex items-center">
    <div class="w-full flex flex-col items-start justify-center bg-white rounded-lg border border-gray-300 p-4">
        <h3 class="mb-2 font-medium">Clienti <span class="inline-flex items-center justify-center ms-2 w-7 h-6 text-center text-white p-1 rounded-full bg-gray-400">{{$totalClients}}</span></h3>
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
    const months = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Numero di clienti',
                data: @json($data),
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34,197,94,0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 50,
                    precision: 0,
                    ticks: {
                        stepSize: 10,
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
