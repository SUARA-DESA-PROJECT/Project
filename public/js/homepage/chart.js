document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    const chartElement = document.getElementById('reportStatChart');
    if (chartElement) {
        console.log('Chart element found');
        // Process the data
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const currentMonth = new Date().getMonth();
        const last6Months = Array.from({length: 6}, (_, i) => {
            const monthIndex = (currentMonth - i + 12) % 12;
            return monthNames[monthIndex];
        }).reverse();

        // Initialize data arrays with zeros
        const totalReports = new Array(6).fill(0);
        const verifiedReports = new Array(6).fill(0);

        // Fetch data from API
        fetch('/laporan/chart-stats')
            .then(response => {
                console.log('Response received:', response);
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                // Fill in the actual data
                data.forEach(item => {
                    const monthIndex = last6Months.findIndex(month => 
                        month === monthNames[item.month - 1]
                    );
                    if (monthIndex !== -1) {
                        totalReports[monthIndex] = parseInt(item.total_laporan);
                        verifiedReports[monthIndex] = parseInt(item.verified_count);
                    }
                });

                // Create the chart
                createChart(last6Months, totalReports, verifiedReports);
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
            });
    } else {
        console.error('Chart element not found!');
    }
});

function createChart(labels, totalReports, verifiedReports) {
    var ctx = document.getElementById('reportStatChart').getContext('2d');
    var reportStatChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Laporan Masuk',
                    data: totalReports,
                    backgroundColor: 'rgba(70, 139, 148, 0.7)',
                    borderColor: '#468B94',
                    borderWidth: 1
                },
                {
                    label: 'Laporan Terverifikasi',
                    data: verifiedReports,
                    backgroundColor: 'rgba(96, 181, 128, 0.7)',
                    borderColor: '#60B580',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Statistik Laporan 6 Bulan Terakhir',
                    padding: 20
                },
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}


function initializeChart() {
    const ctx = document.getElementById('reportStatChart').getContext('2d');
    let myChart;

    fetch('/report-statistics')
        .then(response => response.json())
        .then(data => {
            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Laporan Masuk',
                        data: data.totalReports,
                        backgroundColor: '#75B7B6',
                        borderColor: '#75B7B6',
                        borderWidth: 1
                    },
                    {
                        label: 'Laporan Terverifikasi',
                        data: data.verifiedReports,
                        backgroundColor: '#92DEB7',
                        borderColor: '#92DEB7',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Statistik Laporan 6 Bulan Terakhir',
                            padding: 20
                        },
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    layout: {
                        padding: {
                            right: 10
                        }
                    }
                }
            });
        });
}

document.addEventListener('DOMContentLoaded', initializeChart);