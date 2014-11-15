var page_no=0;

jQuery(document).ready(function(){
	getTickets();
	//alert(display_ticket_data.wpsp_ajax_url);
	jQuery('#tab_ticket_container').click(function(){
		jQuery('#filter_by_type').val('all');
		jQuery('#filter_by_status').val('all');
		jQuery('#filter_by_category').val('all');
		jQuery('#filter_by_priority').val('all');
		jQuery('#filter_by_no_of_ticket').val('10');
		jQuery('#filter_by_search').val('');
		page_no=0;
		getTickets();
	});
	
	jQuery('#tab_agent_settings').click(function(){
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
	
	jQuery("#filter_by_type,#filter_by_status,#filter_by_category,#filter_by_priority,#filter_by_no_of_ticket").change(function(){
		page_no=0;
		getTickets();
	});
	
	jQuery('#filter_by_search').keyup(function(){
		page_no=0;
		getTickets();
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
		'action': 'getTickets',
		'type': jQuery('#filter_by_type').val(),
		'status': jQuery('#filter_by_status').val(),
		'category': jQuery('#filter_by_category').val(),
		'priority': jQuery('#filter_by_priority').val(),
		'no_of_ticket': jQuery('#filter_by_no_of_ticket').val(),
		'search': jQuery('#filter_by_search').val(),
		'page_no': page_no
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#ticketContainer .wait').hide();
		jQuery('#ticketContainer .ticket_list').html(response);
		jQuery('#ticketContainer .ticket_list').show();
	});
}

function openTicket(ticket_id){
	jQuery('#ticketContainer .ticket_filter,#ticketContainer .ticket_list,#ticketContainer .ticket_indivisual').hide();
	jQuery('#ticketContainer .wait').show();
	
	var data = {
		'action': 'openTicket',
		'ticket_id': ticket_id
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#ticketContainer .wait').hide();
		jQuery('#ticketContainer .ticket_indivisual').html(response);
		jQuery('#ticketContainer .ticket_indivisual').show();
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
