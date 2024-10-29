<?php

global $current_user;
wp_get_current_user();
if ( $current_user->user_level == 10 ) {
	//Login check

	if ( isset( $_POST[ "autocatset_recat" ] ) && $_POST[ "autocatset_recat" ] == "1" ) {

		if ( isset( $_POST[ "ID" ] ) ) {
			$IDs = autocatset_array_htmlspecialchars( $_POST[ "ID" ] );
			foreach ( ( array )$IDs as $post_ID ) {
				$post_ID = intval( $post_ID );
				if ( is_numeric( $post_ID ) ) {
					$autocatsetID = esc_html( esc_js( $post_ID ) );

					//Setting
					$targetTitle = "";
					$targetContents = "";
					$targetLink = "";
					$error = "";
					$changeCats = array();
					$targetCats = array();
					$changed = 0;
					$args = array(
						'posts_per_page' => 1,
						'p' => $autocatsetID
					);
					//Loop
					$the_query = new WP_Query( $args );

					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$targetId = intval( $autocatsetID );
							$targetTitle = get_the_title();
							$targetContents = get_the_content();
							$targetLink = get_permalink();
							$tempCats = get_the_category();
							foreach ( $tempCats as $val ) {
								$targetCats[] = $val->term_id;
							}
						}
						wp_reset_postdata();
					} else {
						// no posts found
						$error = __( "No posts found.", "autocatset" );
					}

					//Options
					if ( isset( $_POST[ "ex_cat_reset" ] ) && $_POST[ "ex_cat_reset" ] == "1" ) {
						$changeCats = array();
					} else {
						$changeCats = $targetCats;
					}
					if ( isset( $_POST[ "case_sensitive" ] ) && $_POST[ "case_sensitive" ] == "1" ) {
						$case_sensitive = 1;
					} else {
						$case_sensitive = 0;
					}

					if ( isset( $_POST[ "post_content_aswell" ] ) && $_POST[ "post_content_aswell" ] == "1" ) {
						$autocatset_post_content_aswell = 1;
					} else {
						$autocatset_post_content_aswell = "";
					}

					//Recategorize
					$cat_all = get_terms( "category", "fields=all&get=all" );
					foreach ( $cat_all as $value ) {
						$name = $value->name;
						if ( $case_sensitive == 0 ) {
							$name_comp = mb_strtolower( $name );
							$targetTitle_comp = mb_strtolower( $targetTitle );
							$targetContents_comp = mb_strtolower( $targetContents );
						}else{
							$name_comp = $name;
							$targetTitle_comp = $targetTitle;
							$targetContents_comp = $targetContents;						
						}
						if ( strpos( $targetTitle_comp, $name_comp ) !== false ) {
							$changeCats[] = $value->term_id;
							$changed = 1;
						}
						if ( $autocatset_post_content_aswell ) {
							if ( strpos( $targetContents_comp, $name_comp ) !== false ) {
								$changeCats[] = $value->term_id;
								$changed = 1;
							}
						}
					}
					$changeCats = array_unique( $changeCats );

					//if category is empty
					if ( $changed == 0 ) {
						if ( isset( $_POST[ "unclassified" ] ) && $_POST[ "unclassified" ] != "" ) {
							$changeCats[] = esc_html( esc_js( $_POST[ "unclassified" ] ) );
						}
					}

					$pid = wp_set_post_terms( $targetId, $changeCats, 'category', false );

					//Output
					?>
<tr>
<?php if($error == ""){ ?>
<th>PostID: <strong><?php echo esc_js($targetId); ?></strong></th>
<td><a href="<?php echo $targetLink; ?>" target="_blank"><?php echo esc_js($targetTitle); ?></a>
<?php edit_post_link(__('Edit'),'[',']'); ?></td>
<td><?php
$categories = get_the_category( $targetId );
if ( empty( $categories ) ) {
	_e( "Category:", "autocatset" );
	_e( "No keyword in this post. The default category is applied.", "autocatset" );
} else {
	?>
<?php
_e( "Category:", "autocatset" );
foreach ( $categories as $val ) {
	$category = get_category( $val );
	echo "<span class='cat_name'>" . esc_js( $category->name ) . "</span>";
}
_e( "Done re-set.", "autocatset" );
}
?></td>
<?php }else{ ?>
<th><?php _e("Error:","autocatset"); ?></th>
<td><?php echo esc_js($error); ?></td>
<td></td>
<?php } ?>
</tr>
<?php
} else {
	?>
<tr>
<th><?php _e("Error:","autocatset"); ?></th>
<td><?php _e("Could not get correct ID.","autocatset"); ?></td>
<td></td>
</tr>
<?php
}

}

} else {
	// no ID
	$error = __( "No ID found.", "autocatset" );
}

}

}
