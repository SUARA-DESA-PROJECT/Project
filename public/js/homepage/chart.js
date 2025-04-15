document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi grafik statistik laporan jika elemen canvas ada
    if (document.getElementById('reportStatChart')) {
        var ctx = document.getElementById('reportStatChart').getContext('2d');
        var reportStatChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [
                    {
                        label: 'Laporan Masuk',
                        data: [12, 19, 8, 15, 24, 14],
                        backgroundColor: 'rgba(70, 139, 148, 0.7)',
                        borderColor: '#468B94',
                        borderWidth: 1
                    },
                    {
                        label: 'Laporan Terverifikasi',
                        data: [8, 15, 5, 12, 18, 9],
                        backgroundColor: 'rgba(96, 181, 128, 0.7)',
                        borderColor: '#60B580',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Statistik Laporan 6 Bulan Terakhir'
                    }
                }
            }
        });
    }
}); 