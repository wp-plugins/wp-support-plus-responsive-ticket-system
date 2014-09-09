jQuery(document).ready(function(){
	getGeneralSettings();
	jQuery('#tab_general_container').click(function(){
		getGeneralSettings();
	});
	jQuery('#tab_category_container').click(function(){
		getCategorySettings();
	});
	jQuery('#tab_mail_container').click(function(){
		getMailSettings();
	});
});

function getGeneralSettings(){
	jQuery('#settingsGeneral .settingsGeneralContainer').hide();
	jQuery('#settingsGeneral .wait').show();
	
	var data = {
		'action': 'getGeneralSettings'
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#settingsGeneral .wait').hide();
		jQuery('#settingsGeneral .settingsGeneralContainer').html(response);
		jQuery('#settingsGeneral .settingsGeneralContainer').show();
	});
}

function setGeneralSettings(){
	jQuery('#settingsGeneral .settingsGeneralContainer').hide();
	jQuery('#settingsGeneral .wait').show();
	var enable_btn=0;
	if(jQuery('#setEnableSupportBtn').is(':checked')){
		enable_btn=1;
	}
	var enable_guest_ticket=0;
	if(jQuery('#setEnableGuestTicket').is(':checked')){
		enable_guest_ticket=1;
	}
	var data = {
		'action': 'setGeneralSettings',
		'post_id': jQuery('#setSupportPage').val(),
		'enable_support_button':enable_btn,
		'support_button_position':jQuery('#setBtnPosition').val(),
		'enable_guest_ticket':enable_guest_ticket
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		getGeneralSettings();
	});
}

function getCategorySettings(){
	jQuery('#settingsCategories .wait').show();
	jQuery('#settingsCategories .settingsCategoriesContainer').hide();
	
	var data = {
		'action': 'getCategories'
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#settingsCategories .wait').hide();
		jQuery('#settingsCategories .settingsCategoriesContainer').html(response);
		jQuery('#settingsCategories .settingsCategoriesContainer').show();
	});
}

function getMailSettings(){
	jQuery('#settingsMail .wait').show();
	jQuery('#settingsMail .settingsMailContainer').hide();
	
	var data = {
		'action': 'getEmailNotificationSettings'
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		jQuery('#settingsMail .wait').hide();
		jQuery('#settingsMail .settingsMailContainer').html(response);
		jQuery('#settingsMail .settingsMailContainer').show();
	});
}

function createNewCategory(){
	if(jQuery('#newCatName').val().trim()!=''){
		jQuery('#settingsCategories .wait').show();
		jQuery('#settingsCategories .settingsCategoriesContainer').hide();
		
		var data = {
			'action': 'createNewCategory',
			'cat_name':jQuery('#newCatName').val()
		};

		jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
			getCategorySettings();
		});
	}
	else{
		alert('Please insert category name!');
		jQuery('#newCatName').val('');
		jQuery('#newCatName').focus();
	}
}

function editCategory(id,name){
	jQuery('#editCategoryContainer').show();
	jQuery('#editCatID').val(id);
	jQuery('#editCatName').val(name);
	window.location.href='#editCategoryContainer';
	jQuery('#editCatName').focus();
}

function updateCategory(){
	if(jQuery('#editCatName').val().trim()!=''){
		jQuery('#settingsCategories .wait').show();
		jQuery('#settingsCategories .settingsCategoriesContainer').hide();
		
		var data = {
			'action': 'updateCategory',
			'cat_id': jQuery('#editCatID').val(),
			'cat_name':jQuery('#editCatName').val()
		};

		jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
			getCategorySettings();
		});
	}
	else{
		alert('Please insert category name!');
		jQuery('#editCatName').val('');
		jQuery('#editCatName').focus();
	}
}

function deleteCategory(id,name){
	var str="All Tickets in this category will be moved to General.\nAre you sure to delete '"+name+"'?";
	if(confirm(str)){
		jQuery('#settingsCategories .wait').show();
		jQuery('#settingsCategories .settingsCategoriesContainer').hide();
		
		var data = {
			'action': 'deleteCategory',
			'cat_id': id
		};

		jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
			getCategorySettings();
		});
	}
}

function setEmailSettings(){
	jQuery('#settingsMail .wait').show();
	jQuery('#settingsMail .settingsMailContainer').hide();
	var admin_new_ticket=0;
	if(jQuery('#email_admin_new_ticket').is(':checked')){
		admin_new_ticket=1;
	}
	var admin_reply_ticket=0;
	if(jQuery('#email_admin_reply_ticket').is(':checked')){
		admin_reply_ticket=1;
	}
	var data = {
		'action': 'setEmailSettings',
		'admin_new_ticket': admin_new_ticket,
		'admin_reply_ticket':admin_reply_ticket,
		'default_from_email': jQuery('#txtFromEmail').val(),
		'default_from_name': jQuery('#txtFromName').val()
	};

	jQuery.post(display_ticket_data.wpsp_ajax_url, data, function(response) {
		getMailSettings();
	});
}