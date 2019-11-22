<?php

// Get shorthand client name
$client = $_POST['client'];
//exec("python3 fabric-scripts/hosts_list.py '".$client."'", $client_shorthand, $ret_code);

// Get space information array
exec('python3 fabric-scripts/check_space.py '.$client, $output, $ret_code);
$output = preg_split('/[\s]+/', $output[0]);

?>

<html>
<body>
    <canvas id="myChart" width="400" height="400"></canvas>
    <div id='floating-percent'>
        <?php echo $output[0];?>
    </div>
    <div class="body" style='text-align:left'>
        <b>Space Used: </b><?php echo $output[1];?><br>
        <b>Space Available: </b><?php echo $output[3];?><br>
        <b>Volume Size: </b><?php echo $output[2];?><br>
        <b>Space Left: </b><?php echo 100-$output[0].'%';?>
    </div>
</body>

<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Space Available', 'Space Used'],
        datasets: [{
            data: [<?php echo substr($output[3], 0, -1);?>, <?php echo substr($output[1], 0, -1);?>],
            backgroundColor: [
                '#5FBB97',
                '#435165'
            ],
            borderWidth:0
        }]
    },
    options: {
        legend: {
            display:false
        }
    }
});
</script>
