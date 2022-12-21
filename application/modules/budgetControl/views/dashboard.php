<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="form-inline">
                    <select name="" class="form-control form-control-sm" id="">
                        <option>2022</option>
                        <option>2023</option>
                    </select>
                </div>
                <canvas id="myChart"></canvas>
                <center>
                    <h4>Planing Budget</h4>
                </center>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="form-inline">
                    <select name="" class="form-control form-control-sm" id="">
                        <option>2022</option>
                        <option>2023</option>
                    </select>
                </div>
                <canvas id="myChart2"></canvas>
                <center>
                    <h4>Actual Budget</h4>
                </center>
            </div>
        </div>
    </div>

</div>

<script>
    const ctx = document.getElementById('myChart');
    const ctx2 = document.getElementById('myChart2');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $depar ?>,
            datasets: [{
                label: 'Total',
                data: [12, 19, 3, 5, 2, 3, 3, 5, 2, 3],
                borderWidth: 1,
                backgroundColor: 'rgba(200,120,40,0.9)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?= $depar ?>,
            datasets: [{
                label: 'Total',
                data: [12, 19, 3, 5, 2, 3, 3, 5, 2, 3],
                borderWidth: 1,
                backgroundColor: 'rgba(10,80,40,0.9)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>