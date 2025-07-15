<div class="w-full flex items-center">
    <div class="w-full flex flex-col items-start justify-center bg-white rounded-lg border border-gray-300 p-4">
        <h3 class="mb-2 font-medium ">Progetti  <span class="inline-flex items-center justify-center ms-2 w-6 h-6 text-center text-white p-1 rounded-full bg-gray-400">{{ $totalProjects }}</span></h3>
        <div class="w-full flex justify-center">
            <canvas id="projectsPieChart" width="350" height="250" ></canvas>
        </div>
    </div>
</div>

@script
    <script>
        let ctx = document.getElementById('projectsPieChart').getContext('2d');
        let hasProjects = @js($hasProjects);
        let data, backgroundColor, labels;
        let isEmptyChart = false;

        if (hasProjects) {
            data = [@js($approved), @js($delivered), @js($notApproved)];
            backgroundColor = ['#22c55e', '#ef4484', '#FF0000'];
            labels = ['Approvati', 'Consegnati', 'Non approvati'];
        } else {
            data = [1];
            backgroundColor = ['#e5e7eb'];
            labels = ['Nessun progetto'];
            isEmptyChart = true;
        }

        const chart = new Chart(ctx, {
            type: 'pie',
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
                        display: hasProjects,
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
                        var fontSize = Math.min(width, height) / 19;
                        ctx.font = fontSize + "px sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#9ca3af"; // grigio testo
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
