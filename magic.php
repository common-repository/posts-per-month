<?php

$widgets = get_option( 'dashboard_widget_options' );
$widget_id = 'dashboard_posts_per_month';
$limit = isset( $widgets[$widget_id] ) && isset( $widgets[$widget_id]['items'] ) ? absint( $widgets[$widget_id]['items'] ) : 15;
list($data, $sum, $months) = getDataPPM($limit);

include('html.inc');

function getDataPPM($limit){
  $year = date("Y");
  $month = date("m");
  $firstPost = getOldestPostPPM();
  $firstYear = substr($firstPost, 0, 4);
  $firstMonth = substr($firstPost, 5, 2);
  $sum = 0; $months = 0;
  for($i = 0; $i < $limit; $i++){
    $query = new WP_Query( 'year=' . $year . '&monthnum=' . $month . '&nopaging=true&post_status=publish' );
    $count = $query->post_count;
    $sum += $count; $months += 1;
    wp_reset_postdata();
    $data[] = addDataSetPPM($year, $month, $count);
    if($month == 1){
      $month = 12;
      $year = $year - 1;
    } else {
      $month = $month - 1;
    }
    if($year == $firstYear && $month < $firstMonth){
      $i = $limit;
    }
  }
  return array(array_reverse($data), $sum, $months);
}

function getOldestPostPPM() {
  $all_posts = get_posts('post_status=publish&order=ASC');
  $post = $all_posts[0];
  return $post->post_date;
}

function addDataSetPPM($year, $month, $count){
  return array(
    'month' => $year."/".twoDigitsPPM($month),
    'count' => $count,
    'url' => get_month_link( $year, $month ) );
}

function twoDigitsPPM($month){
  if(strlen($month) == 2) {
    return $month;
  } else {
    return "0".$month;
  }
}
?>