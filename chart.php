
<?php
header("Access-Control-Allow-Origin: *");

function folder_exist($index)
{
    $folder = "/sys/devices/platform/coretemp.0/hwmon/hwmon$index";
    return is_dir($folder);
}

function get_folder_index() {
    $index = -1;
    for ($i = 1; $i < 5; $i++) {
        $folder_exists = folder_exist($i);
        if ($folder_exists) {
            $index = $i;
            $i = 5;
        }
    }
    return $index;
}

function get_cpu_temperature() {
    $folder_index = get_folder_index();
    if ($folder_index == -1) {
        return "Can't find system temperatures";
    }
    exec("cat /sys/devices/platform/coretemp.0/hwmon/hwmon$folder_index/temp*_input", $temperature);
	return $temperature;
}

function get_usage() {
    exec("ps -e -o cmd,%cpu --sort=-%cpu | head -n 10 | tail -n 9", $usage);
    $new_usage = [];
    for($i = 0; $i < count($usage); $i++) {
        $split_usage = explode(" ", $usage[$i]);
        $new_usage[$i] = Array("task_name" => $split_usage[0], "task_usage" => $split_usage[count($split_usage) - 1]);
    }
    return $new_usage;
}

$json_response = json_encode(array("cputemps" => get_cpu_temperature(), "usage" => get_usage()));
echo $json_response;
?>
