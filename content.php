<div class="blog-post">
<h2 class="blog-post-itle"><?php the_title(); ?></h2>
<p class="blog-post-meta"><?php the_date(); ?> par <a
href="#"><?php the_author(); ?></a></p>
<?php the_content(); 

$meta=get_post_meta($post->ID , 'meta-Etat' , true);
echo $meta;  ?> </br> <?php
$meta2=get_post_meta($post->ID , 'meta-dateE' , true);
echo $meta2;?> </br> <?php
$meta_Agent=get_post_meta($post->ID , 'meta-Agent' , true);
echo $meta_Agent;?> </br> <?php
$meta_date=get_post_meta($post->ID , 'meta-date' , true);
echo $meta_date; ?> </br> <?php

?>

</div><!-- /.blog-post -->