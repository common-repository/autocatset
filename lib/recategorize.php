<?php

global $current_user;
wp_get_current_user();
if ($current_user->user_level == 10) {
//Login check

if(isset($_POST["autocatset_start"])){ ?>
<h1>AutoCatSet</h1>
<?php
if(isset($_POST["experimental_5"])){
	$per_page = 5;
}else{
	$per_page = -1;
}

if(isset($_POST["case_sensitive"])){
	$case_sensitive = 1;
}else{
	$case_sensitive = 0;
}

//Setting
$targetIds = array();
$error = "";
$count = 0;
$args = array(
	"order" => 'ASC',
	"orderby" => 'ID',
	'posts_per_page' => $per_page
	);


$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$targetIds[] = $the_query->post->ID;
		$count++;
	}
	wp_reset_postdata();
} else {
	// no posts found
	$error = __("No posts found.","autocatset");
}
?>

<?php if($targetIds != "" && $error == ""){ ?>
<script>
finish_txt = "<?php _e("Finish!! SAYONARA.","autocatset"); ?>";
nothing_post_txt = "<?php _e("Nothing any target post.","autocatset"); ?>";
done_retry_txt = "<?php _e("It done or Return to setting panel and retry again.","autocatset"); ?>";


targetIds = Array(<?php

if(is_array($targetIds)){
$i = 0;
$countRecodes = count($targetIds)-1;
foreach($targetIds as $key => $array){
if($i == 0){
	echo 'Array(';
}
echo '"'.esc_js($array).'",';
$i++;
if($i == 10 || $key == $countRecodes){
	echo '),'."\n";
	$i = 0;
}
}
} ?>);
<?php if(isset($_POST["ex_cat_reset"]) && $_POST["ex_cat_reset"] != ""){ ?>
ex_cat_reset_val = <?php echo esc_html(esc_js($_POST["ex_cat_reset"])); ?>;
<?php }else{ ?>
ex_cat_reset_val = "";
<?php } ?>
<?php if(isset($_POST["post_content_aswell"]) && $_POST["post_content_aswell"] != ""){ ?>
post_content_aswell_val = <?php echo esc_html(esc_js($_POST["post_content_aswell"])); ?>;
<?php }else{ ?>
post_content_aswell_val = "";
<?php } ?>
case_sensitive = <?php echo $case_sensitive; ?>;
<?php if(isset($_POST["unclassified"]) && $_POST["unclassified"] != ""){ ?>
unclassified_val = <?php echo esc_html(esc_js($_POST["unclassified"])); ?>;
<?php }else{ ?>
unclassified_val = "";
<?php } ?>
</script>
<?php } ?>

<?php if($error != ""){ ?>
<p class="description"><?php echo esc_js($error); ?></p>
<?php }else if($count > 0){ ?>
<p class="description"><strong><?php echo esc_js($count); ?> <?php _e("posts","autocatset"); ?></strong> <?php _e("set for re-set category. Start.","autocatset"); ?></p>

<p><button type="button" id="autocatset_pause" class="button button-primary"><?php _e("PAUSE","autocatset"); ?></button> <button type="button" id="autocatset_play" class="button button-primary"><?php _e("PLAY","autocatset"); ?></button></p>

<?php } ?>
<table id="autocatset_result"></table>
<?php

}

}
