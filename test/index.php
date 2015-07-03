<?php
include '../okitoolbox.php';
$otb = new okitoolbox();
echo '902122224444 Phone number formated ->'.$otb->format_phone("902122224444")."<br>";
echo '35482 int byte formated ->'.$otb->format_bytes("35482")."<br>";
echo '38.5845334,-90.2621693 latitude and longitude converted gps ->';print_r($otb->calculate_gps(38.5845334, -90.2621693)); echo '<br>';
echo '10980.83 converted turkish words ->'. $otb->tr_money_to_string(10980.83).'<br>';
?>