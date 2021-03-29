
<?php
header("Access-Control-Allow-Origin: *");
function get_cpu_temperature() {
    exec('cat /sys/devices/platform/coretemp.0/hwmon/hwmon2/temp*_input', $temperature);
	return $temperature;
}
$json_response = json_encode(array("cputemps" => get_cpu_temperature()));
echo $json_response;
?>