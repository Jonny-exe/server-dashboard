<body>
<?php

exec("ps -e -o pid,cmd,%cpu,%mem --sort=-%cpu | head -n 10 | tabulate -1 -f github | cut -f 2- -d '|' | sed '2s/----/    /'", $output);
// exec("ps -e -o pid,cmd,%cpu,%mem --sort=-%cpu | tabulate -1 -f github | cut -f 2- -d '|' | sed '2s/----/    /'", $output);
exec("landscape-sysinfo", $sysinfo);
exec('CELSIUS=$(cat /sys/class/thermal/thermal_zone0/temp) && echo "scale=2; $CELSIUS/1000" | bc | tr "\n" " " && echo "Celsius"', $temperature);

print "<link rel='stylesheet' href='styles.css'>";

?>
<div id="usage">
    <?php
    print "<h1> Programs usage </h1>";
    foreach ($output as $o) {
        print $o;
        print "<br>";
    }
    ?>
</div>

<div id="sysinfo">
    <?php
    print "<h1> Sysinfo </h1>";
    foreach ($sysinfo as $o) {
        print $o;
        print "<br>";
    }

    ?>
</div>
<div id="temperature">
    <?php
    print "<h1> Cpu Temperature </h1>";
    foreach ($temperature as $o) {
        print $o;
        print "<br>";
    }

    ?>
</div>
</body>