
<?php
if(_GET['name']) {
	// $response['body'] = "HELLO this is me";
	// $response['response_code'] = 200;
	// $response['response_desc'] = "OK";

	$json_response = json_encode(array("hello" => "hello"));
	echo $json_response;
}
?>
<body>
    <link rel="stylesheet" href="https://unpkg.com/charts.css/dist/charts.min.css">
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="index.js" defer></script>
    <?php

    function print_response($response, $div_name, $title)
    {
        print "<div id=$div_name class='grid-item'>";
        print "<h1> $title </h1>";
        if (count($response) != 0) {
            foreach ($response as $line) {
                print $line;
                print "<br>";
            }
        } else {
            print "None";
        }
        print "</div>";
    }

    function print_chart($data)
    {
        print '<table class="charts-css area" id="my-chart"> <tbody>';
        for ($i = 0; $i < count($data); $i += 1) {
            print <<<EOD
                <tr>
                    <td style="--start: ; --size: 0.4"> <span class="data"> $ 40K </span> </td>
                </tr>
            EOD;
        }


        print "</tbody> </table>";
    }

	// TEMPERATURE: batcat /sys/class/thermal/thermal_zone0/temp

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
HELLO
</body>
