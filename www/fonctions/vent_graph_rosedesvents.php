<script type="text/javascript">
$(function () {

    $('#<? echo $periph['id']; ?>-r').highcharts({
        data: {
                table: 'freq',
                startRow: 1,
                endRow: 17,
                endColumn: 7
            },

            chart: {
                polar: true,
                type: 'column'
            },

            title: {
                text: 'Rose des vents'
            },

            pane: {
                size: '85%'
            },

            legend: {
                reversed: true,
                align: 'right',
                verticalAlign: 'top',
                y: 100,
                layout: 'vertical'
            },

            xAxis: {
                tickmarkPlacement: 'on'
            },

            yAxis: {
                min: 0,
                endOnTick: false,
                showLastLabel: true,
                title: {
                        text: 'Frequency (%)'
                },
                labels: {
                        formatter: function () {
                                return this.value + '%';
                        }
                }
            },

            tooltip: {
                valueSuffix: '%',
                followPointer: true
            },

            plotOptions: {
                series: {
                        stacking: 'normal',
                        shadow: false,
                        groupPadding: 0,
                        pointPlacement: 'on'
                }
            }
        });
});
                </script>
<?
$query0 = "SELECT count(vitesse) AS sum FROM `vent_".$periph['nom']."`";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($value0 = mysql_fetch_assoc($req0))
{
$totalresult = $value0['sum'];
}
?>
<div style="display:none">
        <table id="freq" border="0" cellspacing="0" cellpadding="0">
                <tr nowrap bgcolor="#CCCCFF">
                        <th colspan="9" class="hdr">Table of Frequencies (percent)</th>
                </tr>
                <tr nowrap bgcolor="#CCCCFF">
                        <th class="freq">Direction</th>
<?

$vit = array(0.5, 2, 4, 6, 8, 10);
$j = 0;
while($j < (count($vit)+1)) {
if($j == 0) {
?>
                        <th class="freq">&lt; <? echo $vit[$j]; ?> m/s</th>
<?
} else if($j == (count($vit))) {
?>
                        <th class="freq">&gt; <? echo $vit[$j-1]; ?> m/s</th>
<?
} else {
?>
                        <th class="freq"><? echo $vit[($j-1)]; ?>-<? echo $vit[$j]; ?> m/s</th>
<?
}
$j++;
}
?>
                        <th class="freq">Total</th>
                </tr>
<?
$pc = array("N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW");
$i=0;
while($i < count($pc)) {

?>
                <tr nowrap<? if(strlen($pc[$i]) == 3){ ?> bgcolor="#DDDDDD"<? } ?>>
                        <td class="dir"><? echo $pc[$i]; ?></td>
<?
$j = 0;
while($j < (count($vit))) {
if($j == 0) {
$query0 = "SELECT count(vitesse) AS sum FROM `vent_".$periph['nom']."` WHERE direction = '".$pc[$i]."' AND vitesse < '".($vit[$j]*10)."'";
} else if($j == (count($vit))) {
$query0 = "SELECT count(vitesse) AS sum FROM `vent_".$periph['nom']."` WHERE direction = '".$pc[$i]."' AND vitesse > '".($vit[($j-1)]*10)."'";
} else {
$query0 = "SELECT count(vitesse) AS sum FROM `vent_".$periph['nom']."` WHERE direction = '".$pc[$i]."' AND vitesse < '".($vit[$j]*10)."' AND vitesse > '".($vit[($j-1)]*10)."'";
}
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($value0 = mysql_fetch_assoc($req0))
{
?>
                        <td class="data"><? echo ($value0['sum']*100/$totalresult); ?></td>
<?
}
$j++;
}
?>
                </tr>
<?
$i++;
}
?>
        </table>
</div>
<div id="<? echo $periph['id']; ?>-r" style="width:<? echo $width; ?>;height:<? echo $height; ?>;margin: 0 auto"></div>