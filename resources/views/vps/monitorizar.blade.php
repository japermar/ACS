<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Resources Dashboard</title>
    @vite(['resources/sass/app.scss', 'resources/js/graph.js','resources/js/app.js', 'resources/js/htmx.js', 'resources/js/event.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <canvas id="cpuChart"></canvas>
        </div>
        <div class="col-md-3 d-flex mt-3 pt-4">
            <div id="processesInfo" style="width: 100%; text-align: center;"></div>
        </div>
        <div class="col-md-3">
            <canvas id="diskChart"></canvas>
        </div>
        <div class="col-md-3">
            <canvas id="memoryChart"></canvas>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <canvas id="loadChart"></canvas>
        </div>
    </div>
</div>

<script>


    const data = @json($systemResources);
    const datasets = [
        {
            label: 'CPU Usage',
            data: [data['CPU Usage'].User, data['CPU Usage'].System, data['CPU Usage'].Idle],
            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(75, 192, 192, 0.2)'],
            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)'],
            borderWidth: 1
        }
    ];

    // Extract Disk Usage for a Doughnut chart example
    const diskUsageData = {
        labels: ['Used', 'Available'],
        datasets: [
            {
                label: 'Disk Usage',
                data: [parseFloat(data['Disk Usage'].Used), parseFloat(data['Disk Usage'].Available)],
                backgroundColor: ['rgba(255, 206, 86, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                borderColor: ['rgba(255, 206, 86, 1)', 'rgba(153, 102, 255, 1)'],
                borderWidth: 1
            }
        ]
    };

    // Configuration for the CPU Usage Bar chart
    const cpuConfig = {
        type: 'bar',
        data: {
            labels: ['User', 'System', 'Idle'],
            datasets: datasets
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Configuration for the Disk Usage Doughnut chart
    const diskConfig = {
        type: 'doughnut',
        data: diskUsageData,
    };

    // Render the charts
    // Assuming you have two <canvas> elements with ids 'cpuChart' and 'diskChart'
    const ctxCpu = document.getElementById('cpuChart').getContext('2d');
    const cpuChart = new Chart(ctxCpu, cpuConfig);

    const ctxDisk = document.getElementById('diskChart').getContext('2d');
    const diskChart = new Chart(ctxDisk, diskConfig);
    const loadAverageData = {
        labels: ['1 min', '5 min', '15 min'],
        datasets: [{
            label: 'Load Average',
            data: data['Load Average'].map(value => parseFloat(value)),
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    };

    const loadConfig = {
        type: 'line',
        data: loadAverageData,
    };

    const ctxLoad = document.getElementById('loadChart').getContext('2d');
    const loadChart = new Chart(ctxLoad, loadConfig);

    // Memory Usage Doughnut Chart
    const memoryUsageData = {
        labels: ['Used', 'Free'],
        datasets: [{
            label: 'Memory Usage',
            data: [parseFloat(data['Memory Usage'].Used), parseFloat(data['Memory Usage'].Free)],
            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
            borderWidth: 1
        }]
    };

    const memoryConfig = {
        type: 'doughnut',
        data: memoryUsageData,
    };

    const ctxMemory = document.getElementById('memoryChart').getContext('2d');
    const memoryChart = new Chart(ctxMemory, memoryConfig);

    // Displaying the number of processes running using Bootstrap
    document.getElementById('processesInfo').innerHTML = `
  <div class="alert alert-info" role="alert">
    There are currently <strong>${data.Processes.Total}</strong> processes running.
  </div>
`;
</script>
</script>
</html>
