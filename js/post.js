function postComment(id, form) {
	var btn = form.find('button');
	btn.attr('disabled', true).css('opacity', '0.4');

	$.ajax({
		type: 'POST',
		url: 'php/comment.php?post=' + id,
		data: new FormData(form[0]),
		processData: false,
		contentType: false,
		success: function (data, textStatus, request) {
			btn.attr('disabled', false).css('opacity', '1');
			if (request.getResponseHeader('error') !== null)
				toast(request.getResponseHeader('error'));
			else {
				form.find("textarea[name='comment']").val('');
				var reply = form.find("input[name='reply']").val();
				var edit = form.find("input[name='edit']").val();

				if (reply != undefined) {
					//se è una risposta
					var depth = $('.comment-' + reply).parents(
						"[class^='comment-']"
					).length;
					if (depth < 2) {
						form.next().prepend(data);
					} else {
						$(data).insertAfter($('.comment-' + reply));
					}
					form.remove();
				} else if (edit != undefined) {
					//se è una modifica
					$('.comment-' + edit + ' .message:first p .message_text').html(data);
					form.remove();
				} else form.next().prepend(data);
			}
		},
		error: function (xhr, desc, err) {
			console.log(err);
		},
	});
}
function deleteComment(id) {
	$.ajax({
		type: 'POST',
		url: 'php/delete_comment.php?id=' + id,
		data: '',
		success: function (data, textStatus, request) {
			if (request.getResponseHeader('error') !== null)
				toast(request.getResponseHeader('error'));
			else {
				toast('Commento rimosso');
				$('.comment-' + id).remove();
			}
		},
		error: function (xhr, desc, err) {
			console.log(err);
		},
	});
}
function loadComments(post, reply, element) {
	$.ajax({
		type: 'POST',
		url: 'php/load_comments.php?post=' + post + '&reply=' + reply,
		success: function (data, textStatus, request) {
			$(element).find('.loader').remove();
			if (data != '') {
				$(element).prev().append(data);
			} else {
				$(element).remove();
				toast('Non ci sono altri commenti da mostrare');
			}
		},
		error: function (xhr, desc, err) {
			console.log(err);
		},
	});
}
function replyComment(id, element) {
	if ($(element).closest('.message').next()[0].tagName != 'FORM') {
		var form = $('form#comment')
			.clone()
			.removeAttr('id')
			.addClass('mt-3 reply');

		/* aggiunge placeholder informativo della risposta */
		var reply_to = $(element).closest('.message').find('.message_from').text();
		form
			.find('textarea:not(:disabled)')
			.attr('placeholder', 'Stai rispondendo a ' + reply_to)
			.next()
			.html('Stai rispondendo a ' + reply_to);
		/* aggiunge placeholder informativo della risposta */

		form
			.insertAfter($(element).closest('.message'))
			.prepend("<input name='reply' value='" + id + "' hidden>");
	} else $(element).closest('.message').next().remove();
}

function editComment(id, element) {
	var msg = $(element).closest('.message');
	if (msg.next()[0].tagName != 'FORM') {
		var form = $('form#comment').clone().removeAttr('id').addClass('mt-3 edit');

		form.find('textarea').val(
			msg.find('p .message_text').text().trim() //rimuove spazi iniziali e finali
		);
		form
			.find('textarea')
			.attr('placeholder', 'Modifica commento')
			.next()
			.html('Modifica commento');
		form.find('button').html('Modifica');

		form
			.insertAfter(msg)
			.prepend("<input name='edit' value='" + id + "' hidden>");
	} else msg.next().remove();
}

function likeComment(id, type, element) {
	$.ajax({
		type: 'POST',
		url: 'php/like_comment.php?id=' + id + '&type=' + type,
		success: function (data, textStatus, request) {
			if (request.getResponseHeader('error') !== null)
				toast(request.getResponseHeader('error'));
			else {
				var icons = ['bi-hand-thumbs-down', 'bi-hand-thumbs-up'];
				if (data == 'like') {
					//aggiunge nuovo like-unlike
					$(element)
						.find('i')
						.toggleClass(icons[type] + ' ' + icons[type] + '-fill')
						.next()
						.html(parseInt($(element).find('span').text()) + 1);
					var other = $(element)
						.closest('ul')
						.find('.' + icons[1 - type] + '-fill');
					if (other.length)
						other
							.toggleClass(icons[1 - type] + ' ' + icons[1 - type] + '-fill')
							.next()
							.html(parseInt(other.next().text()) - 1);
				} else if (data == 'unlike')
					//rimuove nuovo like-unlike
					$(element)
						.find('i')
						.toggleClass(icons[type] + ' ' + icons[type] + '-fill')
						.next()
						.html(parseInt($(element).find('span').text()) - 1);
			}
		},
		error: function (xhr, desc, err) {
			console.log(err);
		},
	});
}
function favoritePost(id, element) {
	$.ajax({
		type: 'POST',
		url: 'php/favorite_post.php?id=' + id,
		success: function (data, textStatus, request) {
			if (request.getResponseHeader('error') !== null)
				toast(request.getResponseHeader('error'));
			else {
				toast(
					$(element).find('i').hasClass('bi-heart-fill')
						? 'Rimosso dai preferiti'
						: 'Aggiunto ai preferiti'
				);
				$(element).find('i').toggleClass('bi-heart bi-heart-fill');
				$(element).find('span:last').html(data);
			}
		},
		error: function (xhr, desc, err) {
			console.log(err);
		},
	});
}
function pinComment(id) {
	$.ajax({
		type: 'POST',
		url: 'php/pin_comment.php?id=' + id,
		success: function (data, textStatus, request) {
			toast(data);
		},
		error: function (xhr, desc, err) {
			console.log(err);
		},
	});
}
function banUser(id) {
	$.ajax({
		type: 'POST',
		url: 'php/ban_user.php?id=' + id,
		success: function (data, textStatus, request) {
			toast(data);
		},
		error: function (xhr, desc, err) {
			console.log(err);
		},
	});
}
