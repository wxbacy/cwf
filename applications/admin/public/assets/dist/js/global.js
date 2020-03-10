var Constant = (function() { 
	var constants = {
		UEDITOR_TOOLBAR: [
		    [
	      	    'fontfamily', 'fontsize','bold', 'italic', 'underline', 'strikethrough', 
	      	    'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 
	      	    'forecolor', 'insertorderedlist', 'insertunorderedlist','justifyleft','justifyright',
	      	    'justifycenter','simpleupload','insertimage', ''
      	    ]
		]
	}
	return {
		get:function(name){
			return constants[name];
		}
	}
})();

function ajaxRequest(url, type, data, callback){
	$.ajax({
        type: type,
        url: url,
        data: data,
        dataType: "json",
        success: function(data){
        	callback(eval(data));
        },
        error: function(request){
        	layer.msg('服务器开小差了', {offset:'20px', time:2000});
        }
	});
}

function datatableInit(element, params, url, columns){
	return element.dataTable({
	    "serverSide": true,  // 数据每次都请求服务器
	    "ajax": {
			"url":url,
			"data":params,
		},
		"searching": false,
		"ordering": false,
		"order": [],
		"bStateSave": false,  // 状态保存
		"language": {
	       "sProcessing": "处理中...",
	       "sLengthMenu": "显示 _MENU_ 项结果",
	       "sZeroRecords": "没有匹配结果",
	       "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
	       "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
	       "sInfoFiltered": "",
	       "sInfoPostFix": "",
	       "sSearch": "从当前数据中检索:",
	       "sUrl": "",
	       "sEmptyTable": "表中数据为空",
	       "sLoadingRecords": "载入中...",
	       "sInfoThousands": ",",
	       "oPaginate": {
	           "sFirst": "首页",
	           "sPrevious": "上页",
	           "sNext": "下页",
	           "sLast": "末页"
	       },
	    },
	    "columns": columns
	});
}

function layerIframe($title, $url, $width, $height){
	var $windowHeight = $(window).height()-30;
	if ($windowHeight < $height.substring(0, $height.length-2)) {
		$height = $windowHeight+'px';
	}
	layer.open({
	    type: 2,
	    title: $title,
	    area: [$width, $height],
	    offset: '20px',
	    skin: 'layui-layer-lan',
	    shift: 5,
	    content: $url
    })
}

function layerMsg($message){
	layer.msg($message, {offset:'20px', time:3000});
}

function layerParentMsg($message){
	parent.layer.msg($message, {offset:'20px', time:3000});
}

function selectAll(name, obj){
	$('input[name*='+name+']').prop('checked', obj.prop('checked'));
}

$(document).ajaxStart(function(){
	$("button:submit").attr("disabled", true);
}).ajaxStop(function(){
	$("button:submit").attr("disabled", false);
});

function layerConfirm($message, callback){
	layer.confirm($message, {offset:'20px', title:''}, function(index){
		callback(index);
	});
}

function layerImg($src){
	layer.closeAll();
	var loadIndex = layer.load(0);
	var img = new Image();
	img.src = $src;
	if (img.complete){
		var imgWidth = img.width;
		var imgHeight = img.height;
		layerShowImg($src, imgWidth, imgHeight);
		layer.close(loadIndex);
	}else{
	    img.onload = function(){
	    	var imgWidth = img.width;
			var imgHeight = img.height;
			layerShowImg($src, imgWidth, imgHeight);
			layer.close(loadIndex);
	    };
	}
	
}

function layerShowImg($src, imgWidth, imgHeight){
	if (imgWidth >= imgHeight) {
		var maxSize = imgWidth;
		var maxType = 'width';
	}else{
		var maxSize = imgHeight;
		var maxType = 'height';
	}
	if (maxSize > 600) {
		if (maxType == 'width') {
			var showWidth = '600px';
			var showHeight = (imgHeight/(imgWidth/600))+'px';
		} else {
			var showHeight = '600px';
			var showWidth = (imgWidth/(imgHeight/600))+'px';
		}
	} else {
		var showWidth = imgWidth+'px';
		var showHeight = imgHeight+'px';
	}
	
	layer.open({
	    type: 1,
	    title: false,
	    area: [showWidth, showHeight],
	    skin: 'layui-layer-nobg', //没有背景色
	    shade: 0,
	    shadeClose: true,
	    content: `<img src="${$src}" style="width:${showWidth};height:${showHeight}">`
	});
}

function parseQueryStringToJson(queryString){
	// 防止中文乱码
	queryString = decodeURIComponent(queryString, true);
	queryString = queryString.replace(/&/g, "\", \"");  
	queryString = queryString.replace(/=/g, "\":\"");  
	
	return JSON.parse("{\""+queryString+"\"}");  
}