<?php

$client = $_POST['client'];
#exec("python3 fabric-scripts/hosts_list.py '".$client."'", $client_shorthand, $ret_code);
exec('python3 fabric-scripts/check_cron.py '.$client, $output, $ret_code);

?>
<html>

<body>
    <?php if ($output[0] != "1") {?>
    <div id='cron-result' class='failed'>
        <div class='focus'>
            <i class="fas fa-times-circle"></i>
        </div>
        <div class='body'>
            It looks like the cron.php script is not set-up correctly for this site!
        </div>
    </div>
    <?php } else { ?>
    <div id='cron-result' class='passed'>
        <div class='focus'>
            <i class="fas fa-check-circle"></i>
        </div>
        <div class='body'>
            The cron.php script is set-up correctly for this site!
        </div>
    </div>
    <?php } ?>
</body>
