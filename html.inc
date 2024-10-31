<script type="text/javascript">
jQuery(document).ready(function ($) {
  if (window.Highcharts === undefined) {
    $.getScript("<?php echo plugins_url("highcharts.js", __FILE__); ?>", function () {
      buildChart();
    });
  }

  var buildChart = function() {
    var categories = []
    var dataset = []
    <?php
    for($i = 0; $i < sizeof($data); $i++){
      ?>
      categories.push('<?php echo $data[$i]["month"]; ?>');
      dataset.push({y:<?php echo $data[$i]["count"]; ?>, url: '<?php echo $data[$i]['url']; ?>'});
      <?php
    }
    ?>
    $("#posts_per_month").highcharts({
      chart: {
        type: 'column',
        backgroundColor: 'rgba(255, 255, 255, 0)'
      },
      credits: {
        enabled: false
      },
      title: {
        text: null,
      },
      legend: {
        enabled: false,
      },
      exporting: {
        enabled: false
      },
      plotOptions: {
        column: {
          animation: false,
          borderWidth: 0,
          color: '#8fb8ce',
          pointPadding: -0.15,
          point: {
            events: {
              click: function() {
                var archiveurl = this.options.url;
                var win=window.open(''+archiveurl, '_blank');
                win.focus();
              }
            }
          }
        }
      },
      xAxis: {
        labels: {
          staggerLines: 2,
          step: <?php echo ceil(sizeof($data)/20); ?>,
        },
        categories: categories
      },
      yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
          text: null,
        },
      },
      series: [{
        name: '<?php echo __('Posts', 'ppm') ?>',
        data: dataset
        }]
      });

    $('#dashboard_posts_per_month > h2 span:first').append(" - &oslash; <?php
      echo ( round($sum/$months, 2) . ' (' . $months . ' '. _n( 'month', 'months', $months, 'ppm' ) .')' );?>");
  };
});
</script>
<div id="posts_per_month" style="width: 100%; height: 300px;"></div>