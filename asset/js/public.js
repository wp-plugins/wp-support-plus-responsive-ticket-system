var page_no=0;

jQuery(document).ready(function(){
	getTickets();
	//alert(display_ticket_data.wpsp_ajax_url);
	jQuery('#tab_ticket_container').click(function(){
		
		jQuery('#tab_create_ticket').parent().removeClass('active');
		jQuery('#tab_agent_settings').parent().removeClass('active');
		jQuery('#tab_ticket_container').parent().addClass('active');
		jQuery('#create_ticket').removeClass('active');
		jQuery('#agent_settings').removeClass('active');
		jQuery('#ticketContainer').addClass('active');
		
		page_no=0;
		if(display_ticket_data.user_logged_in==1){
			getTickets();
		}
	});

	jQuery('#tab_create_ticket').click(function(){
		jQuery('#tab_ticket_container').parent().removeClass('active');
		jQuery('#tab_agent_settings').parent().removeClass('active');
		jQuery('#tab_create_ticket').parent().addClass('active');
		jQuery('#ticketContainer').removeClass('active');
		jQuery('#agent_settings').removeClass('active');
		jQuery('#create_ticket').addClass('active');
		
	});
	
	jQuery('#tab_agent_settings').click(function(){
		
		jQuery('#tab_create_ticket').parent().removeClass('active');
		jQuery('#tab_ticket_container').parent().removeClass('active');
		jQuery('#tab_agent_settings').parent().addClass('active');
		jQuery('#create_ticket').removeClass('active');
		jQuery('#ticketContainer').removeClass('active');
		jQuery('#agent_settings').addClass('active');
				
		jQuery('#agent_settings #agent_settings_area').hide();
		jQuery('#agent_settings .wait').show();
		
		var data = {
			'action': 'getAgentSettings'
		};

		jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
			jQuery('#agent_settings .wait').hide();
			jQuery('#agent_settings #agent_settings_area').html(response);
			jQuery('#agent_settings #agent_settings_area').show();
		});
	});
	
	jQuery( '#frmCreateNewTicket' ).submit( function( e ) {
		
		if(validateTicketSubmit()){
			
			jQuery('#create_ticket_container').hide();
			jQuery('#create_ticket .wait').show();
			
			jQuery.ajax( {
		      url: display_ticket_data.wpsp_ajax_url,
		      type: 'POST',
		      data: new FormData( this ),
		      processData: false,
		      contentType: false
		    }) 
		    .done(function( msg ) {
		    	if(msg=='1'){
		    		jQuery( '#frmCreateNewTicket' ).get(0).reset();
		    		jQuery('#create_ticket .wait').hide();
		    		jQuery('#create_ticket_container').show();
		    		jQuery('#tab_ticket_container').trigger('click');
		    	}
		    });
		}
		
		e.preventDefault();
	});
	
	jQuery( '#frmCreateNewTicketGeuest' ).submit( function( e ) {
		    e.preventDefault();
			if(validateTicketSubmitGuest()){
				
				jQuery('#create_ticket_container').hide();
				jQuery('#create_ticket .wait').show();
				
				jQuery.ajax( {
			      url: display_ticket_data.wpsp_ajax_url,
			      type: 'POST',
			      data: new FormData( this ),
			      processData: false,
			      contentType: false
			    }) 
			    .done(function( msg ) {
			    	if(msg=='1'){
			    		jQuery('#create_ticket .wait').hide();
			    		jQuery('#create_ticket_container').show();
			    		jQuery('#create_ticket_container').html('<h1>Thank You</h1>We will shortly get back to you on your given mail address!');
			    	}
			    });
			}
			
			e.preventDefault();
	});
});

function replyTicket(e,obj){
	if(validateReplyTicketSubmit()){
		jQuery('#ticketContainer .ticket_indivisual').hide();
		jQuery('#ticketContainer .wait').show();
		
		jQuery.ajax( {
	      url: display_ticket_data.wpsp_ajax_url,
	      type: 'POST',
	      data: new FormData( obj ),
	      processData: false,
	      contentType: false
	    }) 
	    .done(function( msg ) {
	    	if(msg=='1'){
	    		jQuery('#tab_ticket_container').trigger('click');
	    	}
	    });
	}
	e.preventDefault();
}

function getTickets(){
	jQuery('#ticketContainer .ticket_list,#ticketContainer .ticket_indivisual').hide();
	jQuery('#ticketContainer .ticket_filter,#ticketContainer .wait').show();
	
	var data = {
		'action': 'getFrontEndTickets',
		'page_no': page_no
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#ticketContainer .wait').hide();
		jQuery('#ticketContainer .ticket_list').html(response);
		jQuery('#ticketContainer .ticket_list').show();
		var body = jQuery("html, body");
		body.animate({scrollTop:0}, '500', 'swing', function() {});
	});
}

function openTicket(ticket_id){
	jQuery('#ticketContainer .ticket_filter,#ticketContainer .ticket_list,#ticketContainer .ticket_indivisual').hide();
	jQuery('#ticketContainer .wait').show();
	
	var data = {
		'action': 'openTicketFront',
		'ticket_id': ticket_id
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#ticketContainer .wait').hide();
		jQuery('#ticketContainer .ticket_indivisual').html(response);
		jQuery('#ticketContainer .ticket_indivisual').show();
		var body = jQuery("html, body");
		body.animate({scrollTop:0}, '500', 'swing', function() {});
	});
}

function load_prev_page(prev_page_no){
	if(prev_page_no!=0){
		page_no=prev_page_no-1;
		getTickets();
	}
}

function load_next_page(next_page_no){
	if(next_page_no!=page_no){
		page_no=next_page_no;
		getTickets();
	}
}

function validateTicketSubmit(){
	if(jQuery('#create_ticket_subject').val().trim()==''){
		alert("Subject not set");
		jQuery('#create_ticket_subject').focus();
		return false;
	}
	if(jQuery('#create_ticket_body').val().trim()==''){
		alert("Description not set");
		jQuery('#create_ticket_body').focus();
		return false;
	}
	return true;
}

function validateTicketSubmitGuest(){
	if(jQuery('#create_ticket_guest_name').val().trim()==''){
		alert("Please Enter Your Name");
		jQuery('#create_ticket_guest_name').focus();
		return false;
	}
	if(jQuery('#create_ticket_guest_email').val().trim()==''){
		alert("Please Enter Your Email");
		jQuery('#create_ticket_guest_email').focus();
		return false;
	}
	if(jQuery('#create_ticket_subject').val().trim()==''){
		alert("Subject not set");
		jQuery('#create_ticket_subject').focus();
		return false;
	}
	if(jQuery('#create_ticket_body').val().trim()==''){
		alert("Description not set");
		jQuery('#create_ticket_body').focus();
		return false;
	}
	return true;
}

function validateReplyTicketSubmit(){
	if(jQuery('#replyBody').val().trim()==''){
		alert("Reply can not be empty!");
		jQuery('#replyBody').focus();
		return false;
	}
	return true;
}

function backToTicketFromIndisual(){
	getTickets();
}

function setSignature(id){
	jQuery('#agent_settings #agent_settings_area').hide();
	jQuery('#agent_settings .wait').show();
	
	var data = {
		'action': 'setAgentSettings',
		'id':id,
		'signature':jQuery('#agentSignature').val()
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#tab_agent_settings').trigger('click');
	});
}
