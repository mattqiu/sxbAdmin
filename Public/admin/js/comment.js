/*评论管理*/

if ($('.pass_btn').length) {

	//通过
	$('.pass_btn').on('click', function () {

		var commentid = $(this).attr('commentid');

		$(this).parent().css('display','none');

		var data = {
			'operation': 'pass',
			'commentid': commentid,
		}
		$.ajax('/Comment/Auditing', {
			'type': 'POST',
			'data': data,
			'dataType': 'json',
			'beforeSend': function (XHR) {
			},
			'success': function (resp, textStatus, jqXHR) {

				if ($.isFunction(callback)) {
					callback(resp);
					return;
				}

				if (resp.code == 200) {
					MessageBox.show('操作成功');
				} else {
					MessageBox.errorFadeout(resp.msg);
				}
			}
		});

	});
}
if ($('.refuse_btn').length) {
	//拒绝
	$('.refuse_btn').on('click', function () {

		var commentid = $(this).attr('commentid');

		$(this).parent().css('display','none');

		var data = {
			'operation': 'refuse',
			'commentid': commentid,
		}
		$.ajax('/Comment/Auditing', {
			'type': 'POST',
			'data': data,
			'dataType': 'json',
			'beforeSend': function (XHR) {
			},
			'success': function (resp, textStatus, jqXHR) {

				if ($.isFunction(callback)) {
					callback(resp);
					return;
				}

				if (resp.code == 200) {
					MessageBox.show('操作成功');
				} else {
					MessageBox.errorFadeout(resp.msg);
				}
			}
		});
	});
}

if ($('.del_btn').length) {
	//删除
	$('.del_btn').on('click', function () {
		var commentid = $(this).attr('commentid');

		$(this).parent().css('display','none');

		var data = {
			'operation': 'delete',
			'commentid': commentid,
		}
		$.ajax('/Comment/Auditing', {
			'type': 'POST',
			'data': data,
			'dataType': 'json',
			'beforeSend': function (XHR) {
			},
			'success': function (resp, textStatus, jqXHR) {

				if ($.isFunction(callback)) {
					callback(resp);
					return;
				}

				if (resp.code == 200) {
					MessageBox.show('操作成功');
				} else {
					MessageBox.errorFadeout(resp.msg);
				}
			}
		});
	});
}
if ($('.recomment_btn').length) {
	//置顶
	$('.recomment_btn').on('click', function () {
		var commentid = $(this).attr('commentid');

		$(this).parent().css('display','none');

		var data = {
			'operation': 'recomment',
			'commentid': commentid,
		}
		$.ajax('/Comment/Auditing', {
			'type': 'POST',
			'data': data,
			'dataType': 'json',
			'beforeSend': function (XHR) {
			},
			'success': function (resp, textStatus, jqXHR) {

				if ($.isFunction(callback)) {
					callback(resp);
					return;
				}

				if (resp.code == 200) {
					MessageBox.show('操作成功');
				} else {
					MessageBox.errorFadeout(resp.msg);
				}
			}
		});
	});
}


