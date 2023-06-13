<script>
    var categories = {!! json_encode(['Available', 'In-Use', 'Loaned']) !!};

    var quantities = {!! json_encode(array_values($statusCounts)) !!};

    var pieChartCanvas = document.getElementById("chart-pie").getContext('2d');
    var pieChart = new Chart(pieChartCanvas, {
        type: 'pie',
        data: {
            labels: categories,
            datasets: [{
                data: quantities,
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'bottom',
            }
            // Add any custom options for the pie chart
        }

    });
</script>
<script>
    var types = {!! json_encode(array_keys($projectItemCounts)) !!};
    var itemCounts = {!! json_encode(array_values($projectItemCounts)) !!};

    var barChartCanvas = document.getElementById("chart-bar-item-count").getContext('2d');
    var barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: {
            labels: types,
            datasets: [{
                    label: 'Asset',
                    data: itemCounts.map(function(count) {
                        return count.asset;
                    }),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Inventory',
                    data: itemCounts.map(function(count) {
                        return count.inventory;
                    }),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true
                },
                y: {
                    beginAtZero: true,
                    precision: 0,
                    stacked: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Total Number of Items by Type (Stacked)'
                }
            }
        }
    });
</script>

<script>
    // Assuming you have the data for added, updated, and deleted items in separate arrays: addedItems, updatedItems, deletedItems
    // Prepare the chart data
    var timestamps = {!! json_encode($timestamps) !!}; // Example timestamps or time intervals
    var addedCounts = {!! json_encode($createdCounts) !!}; // Example counts of added items for each timestamp
    var updatedCounts = {!! json_encode($updatedCounts) !!}; // Example counts of updated items for each timestamp
    // Example counts of deleted items for each timestamp

    // Set up the chart
    var lineChartCanvas = document.getElementById('chart-line').getContext('2d');
    var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: {
            labels: timestamps,
            datasets: [{
                    label: 'Added Items',
                    data: addedCounts,
                    borderColor: 'blue',
                    fill: false
                },
                {
                    label: 'Updated Items',
                    data: updatedCounts,
                    borderColor: 'green',
                    fill: false
                },

            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Item Changes Over Time'
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Time'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Number of Items'
                    }
                }
            }
        }
    });
</script>


<script>
    var priceRanges = {!! json_encode($priceRanges) !!}; // Example price ranges
    var priceCounts = {!! json_encode($priceCounts) !!}; // Example counts for each price range

    // Set up the chart
    var histogramChartCanvas = document.getElementById('chart-histogram').getContext('2d');
    var histogramChart = new Chart(histogramChartCanvas, {
        type: 'bar',
        data: {
            labels: priceRanges,
            datasets: [{
                label: 'Item Price Distribution',
                data: priceCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.5)' // Customize the background color
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Distribution of Item Prices'
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Price Range'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Count'
                    }
                }
            }
        }
    });
</script>