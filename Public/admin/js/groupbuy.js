/*团购管理*/

/*if ($('#groupbuy_status_sel').length) {

	//单人购买
	$('#groupbuy_status_sel').on('click', function () {

		var groupbuyingtmlid = $(this).attr('groupbuyingtmlid');

		var items = {
			'type': 'singlebuy',
			'groupbuyingtmlid': groupbuyingtmlid
		};

		var $ths = $(this);
		GroupbuySend.begingroupbuy(items, function (resp) {
			if (resp.code == 200) {
				location.href = resp.msg;
				//MessageBox.show('恭喜您，商品已成功加入购物车',3000,'downslide');

			} else {
				MessageBox.errorFadeout(resp.msg);
			}
		});
	});
}*/
function selectgroupbuy(opentime_begin,opentime_end,groupbuystate,timetype) {

	if(opentime_begin == 0 || opentime_begin==null)
	{
		var begintimeDate = 0;
		var endtimeDate = 0;
		window.location.href = '/GroupBuying/getgroupbuy_condition/opentime_begin/'+begintimeDate+'/opentime_end/'+endtimeDate+'/groupbuystate/'+groupbuystate+'/timetype/'+timetype;
	}
	else{
		opentime_begin = opentime_begin.replace(/-/g,"/");
		var begintimeDate = new Date(opentime_begin).getTime()/1000;

		opentime_end = opentime_end.replace(/-/g,"/");
		var endtimeDate = new Date(opentime_end).getTime()/1000;
		window.location.href = '/GroupBuying/getgroupbuy_condition/opentime_begin/'+begintimeDate+'/opentime_end/'+endtimeDate+'/groupbuystate/'+groupbuystate+'/timetype/'+timetype;
	}

}

function selectgroupbuyonchage() {
	var objS = document.getElementById("groupbuy_status_sel");
	var groupbuytype = objS.options[objS.selectedIndex].value;

	var objtime = document.getElementById("groupbuy_time_type");
	var timetype = objtime.options[objtime.selectedIndex].value;

	var objDate = document.getElementById("datepickerDateRange");
	var timeArr = objDate.value;
	if(timeArr.length != 0)
	{
		timeArr = timeArr.split(' - ');
		var opentime_begin = timeArr[0];
		var opentime_end = timeArr[1]+" 23:59:59";

		selectgroupbuy(opentime_begin,opentime_end,groupbuytype,timetype);
	}
	else
	{
		selectgroupbuy(0,0,groupbuytype,timetype);
	}



}

function selectjoingroupbuyonchange() {
	var objS = document.getElementById("groupbuy_status_sel");
	var groupbuytype = objS.options[objS.selectedIndex].value;

	var objtime = document.getElementById("groupbuy_time_type");
	var timetype = objtime.options[objtime.selectedIndex].value;

	var tmp_ids = document.getElementById('tmp_id');
	var tmp_id = tmp_ids.value;
	var objDate = document.getElementById("datepickerDateRange");
	var timeArr = objDate.value;
	if(timeArr.length != 0)
	{
		timeArr = timeArr.split(' - ');
		var opentime_begin = timeArr[0];
		var opentime_end = timeArr[1]+" 23:59:59";

		selectjoingroupbuy(opentime_begin,opentime_end,groupbuytype,timetype,tmp_id);
	}
	else
	{
		selectjoingroupbuy(0,0,groupbuytype,timetype,tmp_id);
	}



}

function selectjoingroupbuy(opentime_begin,opentime_end,groupbuystate,timetype,tmp_id) {

	if(opentime_begin == 0 || opentime_begin==null)
	{
		var begintimeDate = 0;
		var endtimeDate = 0;
		window.location.href = '/GroupBuying/joinindex/opentime_begin/'+begintimeDate+'/opentime_end/'+endtimeDate+'/groupbuystate/'+groupbuystate+'/timetype/'+timetype+'/tmp_id/'+tmp_id;
	}
	else{
		opentime_begin = opentime_begin.replace(/-/g,"/");
		var begintimeDate = new Date(opentime_begin).getTime()/1000;

		opentime_end = opentime_end.replace(/-/g,"/");
		var endtimeDate = new Date(opentime_end).getTime()/1000;
		window.location.href = '/GroupBuying/joinindex/opentime_begin/'+begintimeDate+'/opentime_end/'+endtimeDate+'/groupbuystate/'+groupbuystate+'/timetype/'+timetype+'/tmp_id/'+tmp_id;
	}

}


