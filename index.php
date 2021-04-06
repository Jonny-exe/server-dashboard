<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart</title>
</head>

<body>
    <link rel="stylesheet" href="https://unpkg.com/charts.css/dist/charts.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <?php
    header("Access-Control-Allow-Origin: *");
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

    exec("landscape-sysinfo", $sysinfo);
    exec('CELSIUS=$(cat /sys/class/thermal/thermal_zone0/temp) && echo "scale=2; $CELSIUS/1000" | bc | tr "\n" " " && echo "Celsius"', $temperature);
    exec('/etc/update-motd.d/90-updates-available', $upgradable);
    exec('/etc/update-motd.d/98-reboot-required', $reboot);
    exec('/etc/update-motd.d/00-header', $title);

    print "<link rel='stylesheet' href='styles.css'>";
    print_response($title, "title", "Your server");
    print_response($sysinfo, "sysinfo", "System info");
    print_response($upgradable, "upgradable", "Apts to be upgraded");
    print_response($reboot, "reboot", "Reboot required");

    ?>
    <div class="chart-container" id="cpu-chart-container">
        <canvas id="cpu-chart">

        </canvas>
    </div>
    <div class="chart-container" id="usage-chart-container">
        <canvas id="ram-chart">

        </canvas>
    </div>
    <div class="chart-container" id="ram-chart-container">
        <canvas id="usage-chart">

        </canvas>
    </div>
    <script src="./index.js" type="module" defer></script>
</body>

</html>
