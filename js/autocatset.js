/*
AutoCatSet Javascript;
*/
jQuery(document).ready(function($) {

autocatset_pause = 0;

function recat(){

	var error = "";
	var finish = "";

	
	if (typeof targetIds !== 'undefined' && targetIds != '') {
			$.ajax({
				url:'/wp-admin/admin-ajax.php?action=autocatset_ajax',
				type:'POST',
				data:{
				'action': "autocatset_ajax",
					'ID':targetIds[0],
					'autocatset_recat':1,
					'ex_cat_reset':ex_cat_reset_val,
					'case_sensitive':case_sensitive,
					'post_content_aswell':post_content_aswell_val,
					'unclassified':unclassified_val
					}
				}).done(function(data){
					$('#autocatset_result').append(data);
					targetIds.shift();
					if (typeof targetIds !== 'undefined' && targetIds != '') {
						if(autocatset_pause == 0){
							recat(targetIds);
						}
					}else{
						$("#autocatset_result").after("<p class=\"\">"+finish_txt+"</p>");
					}
				})
				.fail(function(data){
					$('#autocatset_result').html("Fail to Connect.");
					targetIds.shift();
					if (typeof targetIds !== 'undefined' && targetIds != '') {
						if(autocatset_pause == 0){
							recat(targetIds);
						}
					}else{
						$("#autocatset_result").after("<p class=\"\">"+finish_txt+"</p>");
					}
				})
				.always( function(data){
				});		
	}else{
		error = nothing_post_txt;
	}

	if(error != ""){
		$("#autocatset_result").after("<p>" + error + "</p>");
	}
}

if(typeof targetIds !== 'undefined') {
	recat();
}


$("#autocatset_pause").on("click",function(){
	autocatset_pause = 1;
});

$("#autocatset_play").on("click",function(){
	if (autocatset_pause = 1) {
		autocatset_pause = 0;
		if (typeof targetIds !== 'undefined' && targetIds != '') {
			recat();
		}else{
			alert(done_retry_txt);
		}
	}
});

});