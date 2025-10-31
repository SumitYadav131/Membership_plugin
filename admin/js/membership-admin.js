(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	 
	 
	   // Handle delete button click
	  
   
	$(document).on('click', '.members-delete-role-link', function(e) {
        e.preventDefault();

        var userId = $(this).closest('tr').data('user-id');
		var deleteMemberAjax = 'https://alqimi.mydevitsolution.com/wp-admin/admin-ajax.php';
        
        // Confirmation prompt
        var confirmDelete = confirm('Are you sure you want to delete this member?');
        if (confirmDelete) {
            // Send AJAX request to delete the member
            $.ajax({
                url: deleteMemberAjax,
                type: 'POST',
                data: {
                    action: 'md_delete_member',
                    user_id: userId,
                    nonce: deleteMemberAjax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.data.message);
                        // Remove the row from the table
                        $('tr[data-user-id="' + userId + '"]').remove();
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                },
                error: function() {
                    alert('There was an error processing your request.');
                }
            });
        }
    });
	$(document).on('click', '.members-level-delete-link', function(e) {
        e.preventDefault();

        var levelId = $(this).closest('tr').data('level-id');
		var deleteMemberAjax = 'https://alqimi.mydevitsolution.com/wp-admin/admin-ajax.php';
        
        // Confirmation prompt
        var confirmDelete = confirm('Are you sure you want to delete this member?');
        if (confirmDelete) {
            // Send AJAX request to delete the member
            $.ajax({
                url: deleteMemberAjax,
                type: 'POST',
                data: {
                    action: 'md_delete_member_level',
                    level_id: levelId,
                    nonce: deleteMemberAjax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.data.message);
                        // Remove the row from the table
                        $('tr[data-level-id="' + levelId + '"]').remove();
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                },
                error: function() {
                    alert('There was an error processing your request.');
                }
            });
        }
    });

})( jQuery );
