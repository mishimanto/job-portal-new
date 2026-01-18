<div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ $title }}
        </h3>
        @if(isset($subtitle))
        <p class="mt-1 text-sm text-gray-500">
            {{ $subtitle }}
        </p>
        @endif
    </div>
    <div class="px-4 py-5 sm:p-6">
        <div class="chart-container" style="height: 300px;">
            <canvas id="{{ $chartId }}"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('{{ $chartId }}').getContext('2d');
        
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: @json($datasets)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        title: {
                            display: true,
                            text: '{{ $yAxisTitle ?? "Count" }}'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: '{{ $xAxisTitle ?? "Timeline" }}'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush