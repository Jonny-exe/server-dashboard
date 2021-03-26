<body>
    <link rel="stylesheet" href="https://unpkg.com/charts.css/dist/charts.min.css">
    <?php

    function print_response($response, $div_name, $title)
    {
        print "<div id=$div_name class='grid-item'>";
        print "<h1> $title </h1>";
        foreach ($response as $line) {
            print $line;
            print "<br>";
        }
        print "</div>";
    }

    function print_chart($data)
    {
        print '<table class="charts-css area" id="my-chart"> <tbody>';
        foreach ($data as $line) {
            print <<<EOD
                <tr>
                    <td style="--start: 0.2; --size: 0.4"> <span class="data"> $ 40K </span> </td>
                </tr>
            EOD;
        }


        print "</tbody> </table>";
    }

    exec("ps -e -o pid,cmd,%cpu,%mem --sort=-%cpu | head -n 10 | tabulate -1 -f github | cut -f 2- -d '|' | sed '2s/----/    /'", $usage);
    // exec("top | head", $usage);
    // exec("ps -e -o pid,cmd,%cpu,%mem --sort=-%cpu | tabulate -1 -f github | cut -f 2- -d '|' | sed '2s/----/    /'", $output);
    exec("landscape-sysinfo", $sysinfo);
    exec('CELSIUS=$(cat /sys/class/thermal/thermal_zone0/temp) && echo "scale=2; $CELSIUS/1000" | bc | tr "\n" " " && echo "Celsius"', $temperature);
    exec('/etc/update-motd.d/90-updates-available', $upgradable);
    exec('/etc/update-motd.d/98-reboot-required', $reboot);
    exec('/etc/update-motd.d/00-header', $title);

    print "<link rel='stylesheet' href='styles.css'>";
    print_response($title, "title", "Your server");
    print_response($usage, "usage", "Programs usage");
    print_response($sysinfo, "sysinfo", "System info");
    print_response($upgradable, "upgradable", "Apts to be upgraded");
    print_response($reboot, "reboot", "Reboot required");

    ?>

</body>