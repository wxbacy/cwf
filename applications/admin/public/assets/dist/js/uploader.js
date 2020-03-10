var Upload = {
	init: function(config) {
        this.config = {
            swf: '/static/webuploader/Uploader.swf',
            server: 'http://up-z2.qiniu.com/',
            pick: {
                id: config.container
            },
            fileVal: 'file',
            formData: {
                token: config.token
            },
            resize: false,
            compress: config.compress || false,
            auto: true,
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,png',
                mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'
            }
        };
        this.domain = config.domain;
        this.container = config.container;
        
        var uploader = WebUploader.create(this.config);
        var _this = this;
        
    	// 当有文件添加进来的时候
        uploader.on('fileQueued', function(file){
        	var $li = $(_this.container);
        	$li.find("img").prop("src", '');
        });
        
        // 文件上传过程中创建进度条实时显示。
        uploader.on('uploadProgress', function(file, percentage){
        	var $li = $(_this.container);
        	var $percent = $li.find('.progress-bar');

            // 避免重复创建
            if (!$percent.length) {
                $percent = $('<div id="uploader-progress" class="progress progress-sm">'+
					             '<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" width="0%">'+
					                 '<span class="sr-only">20% Complete</span>'+
					             '</div>'+
					         '</div>')
                    .prependTo($li.find('.webuploader-pick'))
                    .find('.progress-bar');
            }

            $percent.css('width', percentage * 100 + '%');
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function(file, res){
        	var thumb = _this.domain + '/' + res.key;
        	var $li = $(_this.container);
        	var width = $li.width();
        	var height = $li.height();
        	$li.find("img").prop("src", thumb + '?imageView2/1/w/'+width+'/h/'+height).css("display","block");
        	$li.find(".img-url").val(res.key);
        });
        

        // 文件上传失败，显示上传出错。
        uploader.on('uploadError', function(file, reason){
        	console.log('uploadError', file, reason);
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on('uploadComplete', function(file){
        	$('#uploader-progress').remove();
        });
    }
}