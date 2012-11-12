	function load_clobber_user_table( ){
		jQuery('#clobber-users-table').html( "<p><img src=\"" + clobber.loading_gif_path + "\" alt=\"\"> Loading users...</p>" );
		jQuery.post(ajaxurl, {
			action: 'load_table'
		}, function(data) {
			jQuery('#clobber-users-table').html( data );
		});
	}
	
	function clobber_checked_users( ){
		var array = new Array( );
		jQuery('input[id^="clobber-user-id-"][type="checkbox"]:checked').each(function(){
			array.push(jQuery(this).val());
		});
		if( array.length ){
			jQuery.post(ajaxurl, {
				action: 'clobber_users',
				user_ids: array.join(",")		
			}, function(data) {
				load_clobber_user_table( );
			});
		} else{
			alert("Check some users to clobber before clicking the button.");
		}
	}