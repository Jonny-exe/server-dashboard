<?php
function folder_exist($index)
{
    $folder = "/sys/devices/platform/coretemp.0/hwmon/hwmon$index";
    return is_dir($folder);
}


print "HELLO";
print folder_exist(1);

?>
