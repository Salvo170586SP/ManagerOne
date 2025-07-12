<div class="w-full flex items-center">
    <div class="w-full h-[350px] flex flex-col items-start justify-center bg-white rounded-lg border border-gray-300 p-4">
        <h3 class="mb-2 font-medium">Fatture <span class="inline-flex items-center justify-center ms-2 w-6 h-6 text-center text-white p-1 rounded-full bg-gray-400">{{ $totalInvoices }}</span></h3>
        <div class="w-full flex justify-center">
            <canvas id="inoicesChart" width="350" height="250" ></canvas>
        </div>
    </div>
</div>

@script
    <script>
        let ctx = document.getElementById('inoicesChart').getContext('2d');
        let hasInvoices = @js($hasInvoices);
        let data, backgroundColor, labels;
        let isEmptyChart = false;

        if (hasInvoices) {
            data = [@js($InvoicesPay), @js($InvoicesNotPay)];
            backgroundColor = ['#22c55e', '#FF0000'];
            labels = ['Pagate', 'Non pagate'];
        } else {
            data = [1];
            backgroundColor = ['#e5e7eb'];
            labels = ['Nessuna fattura'];
            isEmptyChart = true;
        }

        const chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: backgroundColor,
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        display: hasInvoices,
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 13
                            },
                            boxWidth: 15,
                            padding: 16,
                         }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (isEmptyChart) {
                                    return context.label;
                                }
                                return context.parsed;
                            }
                        }
                    }
                }
            },
            plugins: [{
                id: 'centerText',
                afterDraw: function(chart) {
                    if (isEmptyChart) {
                        var width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;
                        ctx.restore();
                        var fontSize = Math.min(width, height) / 14;
                        ctx.font = fontSize + "px sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#9ca3af"; 
                        var text = "Non ci sono progetti";
                        var textX = Math.round((width - ctx.measureText(text).width) / 2);
                        var textY = height / 2;
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
            }]
        });
    </script>
@endscript
