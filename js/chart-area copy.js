// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Function to fetch data from API and render the chart
        async function fetchDataAndRenderChart() {
            const apiUrl = './api/get_data.php';

            try {
                const response = await fetch(apiUrl);
                const data = await response.json();

                const timestamps = data.map(entry => entry.suhu_udara);
                const temperatures = data.map(entry => entry.suhu_udara);

                renderLineChart(timestamps, temperatures);

                // Schedule next update after 5 seconds
                setTimeout(fetchDataAndRenderChart, 5000);
            } catch (error) {
                console.error('Error fetching or parsing data:', error);

                // Retry after 5 seconds in case of error
                setTimeout(fetchDataAndRenderChart, 5000);
            }
        }

        // Function to render the line chart
        function renderLineChart(labels, data) {
            const ctx = document.getElementById('myAreaChart');

            // Check if chart already exists, if yes, update it; otherwise, create new chart
            if (window.lineChart) {
                // Update chart data
                window.lineChart.data.labels = labels;
                window.lineChart.data.datasets[0].data = data;
                window.lineChart.update();
            } else {
                // Create new chart
                window.lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Suhu Udara (°C)',
                            data: data,
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'minute' // Customize time axis units if needed
                                },
                                gridLines: {
                                  display: false,
                                  drawBorder: false
                                },
                                ticks: {
                                    autoSkip: true,
                                    maxTicksLimit: 10
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Suhu Udara (°C)'
                                },
                                gridLines: {
                                  color: "rgb(234, 236, 244)",
                                  zeroLineColor: "rgb(234, 236, 244)",
                                  drawBorder: false,
                                  borderDash: [2],
                                  zeroLineBorderDash: [2]
                                }
                            }
                        },
                        legend: {
                        display: false
                        },
                    }
                });
            }
        }

        // Start fetching data and rendering chart
        fetchDataAndRenderChart();