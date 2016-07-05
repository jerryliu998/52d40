function getprovince(rid,pid) {
	 $.ajax({
		url:'/ajax/getregion',
		data:'exce=1&parent_id='+rid,
		success:function(json) {
			for(i=0;i<json.length;i++) {
				if(json[i].region_id == pid) {
					var slt;
					slt = document.getElementById('province');
					slt.options.add(new Option(json[i].region_name,json[i].region_id));
					slt.options[slt.options.length-1].selected='selected';
				} else {
					slt = document.getElementById('province');
					slt.options.add(new Option(json[i].region_name,json[i].region_id));
				}
			}
		}
	 });
 }
function getcity(rid,cid) {
	 $.ajax({
		url:'/ajax/getregion',
		data:'parent_id='+rid,
		success:function(json) {
			document.getElementById('city').options.length = 0;
			document.getElementById('city').options.add(new Option('---请选择城市---',''));
			for(i=0;i<json.length;i++) {
				if(json[i].region_id == cid) {
					var slt;
					slt = document.getElementById('city');
					slt.options.add(new Option(json[i].region_name,json[i].region_id));
					slt.options[slt.options.length-1].selected='selected';
				} else {
					slt = document.getElementById('city');
					slt.options.add(new Option(json[i].region_name,json[i].region_id));
				}
			}
		}
	 });
}

function preview(oper) {
	$('html').height('auto');
	if (oper < 10) {
		bdhtml=window.document.body.innerHTML;//获取当前页的html代码
		sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域
		eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域
		prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html
		prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
		window.document.body.innerHTML=prnhtml;
		window.print();
		window.document.body.innerHTML=bdhtml;
	}
    else {
		window.print();
	}
}