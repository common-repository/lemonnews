/*

	Admin javascripts we're gonna use
	@author Vitor Rigoni - vitor@lemonjuicewebapps.com

 */

jQuery.noConflict();
jQuery(document).ready( function($) {

	/* Some global variables we're gonna need */
	var emailRestore = [];
	var msg = {
		success: ajax_object.msg_success,
		error: ajax_object.msg_error,
		deletion: ajax_object.msg_confirm_delete
	}

	var $stylePreview = $('#stylePreview');
	var $formStyle = $('#formStyle');

	$('.ttip').tooltip();

	$formStyle.on('change', function() {

		var url = ajax_object.plugins_url + "img/form-samples/" + $(this).val() + ".png";
		$("#stylePreview").attr('src', url);

	});

	/* We have to re-bind DOM created elements. Sorry about that. */
	$(document).on('mouseover mouseout', '.ttip', function() {
		$(this).tooltip();
	});

	$(document).on('click', '.btn-edit', function(e) {
		e.preventDefault();
		var obj = $(this);
		var id = obj.attr("name").replace("edit-", "");
		var a = {
			value: obj.html(),
			id: id,
			name: 'email-' + id
		}

		emailRestore[a.id] = a;

		var input = "<div class=\"input-prepend input-append input-email-switcher\"><span class=\"add-on btn btn-mini btn-danger\" name=\"cancel-"+a.id+"\"><i class=\"icon-remove icon-white\"></i></span><input class=\"span2\" name=\"edit-"+a.id+"\" value=\""+a.value+"\" type=\"text\"><button class=\"add-on btn btn-mini btn-success\" name=\"submit-"+a.id+"\"><i class=\"icon-ok icon-white\"></i></button></div>";

		obj.tooltip('hide');
		obj.parent().append(input);
		obj.remove();
	});

	$(document).on('click', ".add-on.btn-danger", function(e) {
		e.preventDefault();
		var obj = $(this);
		var parentDiv = obj.parent();
		var id = obj.attr("name").replace("cancel-", "");
		var a = {
			id: id,
			name: 'email-' + id
		}

		var anchor = "<a href=\"#\" class=\"btn-edit\" name=\"edit-" + a.id + "\">" + emailRestore[a.id].value + "</a>";

		parentDiv.parent().append(anchor);
		parentDiv.remove();
	});

	$(document).on('click', ".btn-delete", function(ev){
		ev.preventDefault();
		var url = $(this).attr('href');

		alertify.set({
			labels: {
				ok: ajax_object.yes,
				cancel: ajax_object.cancel
			}
		});

		alertify.confirm(msg.deletion, function(e){
			if (e) window.location.href = url;
			else return false;
		});
	});

	$(document).on('click', '.add-on.btn-success', function(e) {
		e.preventDefault();
		var obj = $(this);
		var parentDiv = obj.parent();
		var id = obj.attr("name").replace("cancel-", "");
		var a = {
			id: id,
			name: 'email-' + id,
			value: $(this).siblings('input').val()
		}

		var data = {
			action: 'update_email',
			email: a.value,
			id: a.id.replace("submit-", ""),
			nonce: $("#nonce").val()
		}

		$.post(ajax_object.ajax_url, data, function(response){
			if (response == "true") {
				alertify.success(msg.success);
				
				emailRestore.pop(a.id);

				var anchor = "<a href=\"#\" class=\"btn-edit\" name=\"edit-" + data.id + "\">" + data.email + "</a>";

				parentDiv.parent().append(anchor);
				parentDiv.remove();
			} else {
				alertify.error(msg.error);
			}
		});


	});

	$("#list-emails-pagination li").on('click', function(e) {
		e.preventDefault();
		if ($(this).hasClass('active')) return false;

		var li = $(this);
		var chunk = this.id.replace("page-", '');
		var table = $("#list-email-body");

		var data = {
			action: 'change_email_list_page',
			page: chunk
		};

		table.children().fadeOut( function() {
			$("#emails-ajax-loader").css('display', 'inline-block');
		});

		$.post(ajax_object.ajax_url, data, function(response){
			table.append(response).css('display', 'none').fadeIn( function(){
				$("#emails-ajax-loader").css('display', 'none');
			});
			li.addClass('active').siblings().removeClass('active');
		});

	});

});















