<?php
$meta_Etat=get_post_meta($post->ID , 'meta-Etat' , true);

$meta_dateE=get_post_meta($post->ID , 'meta-dateE' , true);

$meta_Agent=get_post_meta($post->ID , 'meta-Agent' , true);

$meta_date=get_post_meta($post->ID , 'meta-date' , true);


header('Content-Type: application/json');

$title = get_the_title();

$arr = array('Etat' => $meta_Etat, 'Date de la réclamation' => $meta_dateE ,'Agent responsable' => $meta_Agent , 'Date de l’intervention' => $meta_date );

$myJSON = json_encode($arr);

echo $myJSON;
?>
