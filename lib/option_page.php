<?php
global $current_user;
wp_get_current_user();
if ($current_user->user_level == 10) {
//Login check
?>
<div id="autocatset">
<h1>AutoCatSet</h1>
<p id="autocatset_explain"><?php _e("AutoCatSet plugin is for <strong>automatically re-set category from keywords in the tile and the content</strong> of each post.","autocatset"); ?></p>

<h2 class="title"><?php _e("Cautions","autocatset"); ?></h2>
<ul>
<li><?php _e("Recommending for do <strong>Database backup</strong> before start this AutoCatSet plugin.","autocatset"); ?></li>
<li><?php _e("You must set up all categories before start this plugin. If the post has the keyword same as a category name in categories, the post be going to add the category. ","autocatset"); ?></li>
<li><?php _e("This plugin is for only default Post. Not for custom post type and custom taxonomy, I will update or not from needs, Sorry.","autocatset"); ?></li>
<li><?php _e("You can use trying option for only 5 posts re-setting. You should try before do for all posts's category re-set.","autocatset"); ?></li>
</ul>
<h2 class="title"><?php _e("Options","autocatset"); ?></h2>
<form method="post">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table" role="presentation">
<tr>
<th><?php _e("Set Basic category","autocatset"); ?></th>
<td><?php $cat_all = get_terms( "category", "fields=all&get=all&orderby=id" );
if($cat_all != ""){
?>
<select name="unclassified">
<option value=""><?php _e("None","autocatset"); ?></option>
<?php foreach($cat_all as $value){ ?>
<option value="<?php echo esc_js($value->term_id); ?>"><?php echo esc_js($value->name); ?></option>
<?php } ?>
</select>
<?php } ?>
<p class="description"><?php _e("taxonomySet basic category is for when can not find any keyword in the post, put the basic category to the post.","autocatset"); ?></p>
</td>
</tr>
<tr>
<th><?php _e("Find keyword in the content too","autocatset"); ?></th>
<td><p class="description"><label><input type="checkbox" name="post_content_aswell" value="1" /><?php _e("If you want to find keyword in the content too, check this. Default is from the title of the post only.","autocatset"); ?></label></p></td>
</tr>
</td>
</tr>
<tr>
<th><?php _e("Case-sensitive","autocatset"); ?></th>
<td><p class="description"><label><input type="checkbox" name="case_sensitive" value="1" /><?php _e("If you do not want to case-sensitive of keywords, No check. <br>Example:<br><strong>Check this</strong> -> 'Hello' is not 'hello'.<br><strong>No check this</strong> -> 'Hello' is same as 'hello'","autocatset"); ?></label></p></td>
</tr>
<tr>
<th><?php _e("Refresh existing category","autocatset"); ?></th>
<td><p class="description"><label><input type="checkbox" name="ex_cat_reset" value="1" /><?php _e("If you want to refresh existing category of the post, check this. If you remain Existing category of the post, No check.","autocatset"); ?></label></p></td>
</tr>
<tr>
<th><?php _e("Tryal small re-set","autocatset"); ?></th>
<td><p class="description"><label><input type="checkbox" name="experimental_5" value="1" checked /><?php _e("If you want to try before start all, You can try just 5 posts re-set category, check this. You should do this before get on a Jet coaster.","autocatset"); ?></label></p></td>
</tr>
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="autocatset_start" value="1" />
<h4><?php _e("Recommending for do backup before you start this!!","autocatset"); ?></h4>
<p class="submit">
<button type="submit" class="button button-primary"><?php _e("AutoCatSet Start!","autocatset"); ?></button>
</p>
</form>

<div id="autocatset_footer">Copyright &copy; 2011 gyaku Some rights reserved.</div>
</div>

<?php }