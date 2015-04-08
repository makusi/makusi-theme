;(function($) {

    /**
     * Upload handler helper
     *
     * @param string {browse_button} browse_button ID of the pickfile
     * @param string {container} container ID of the wrapper
     * @param int {max} maximum number of file uplaods
     * @param string {type}
     */
    window.WPUF_Uploader = function (browse_button, container, max, type, allowed_type, max_file_size) {
    	  //console.log(browse_button);
    	  //console.log(container);
    	  //console.log(max);
    	  //console.log(type);
    	  //console.log(allowed_type);
    	  //console.log(max_file_size);
        //container is the place where loade files will appear 'wpuf-file-upload-container' provided from source code of webpage, but it works and defined at class/render-form.php ln 750'
        this.container = container;
        //browse_button is the button we browse
        this.browse_button = browse_button;
        //max number of files as defined in wordpress admin site, plugin wp user frontend pro
        this.max = max || 1;
        
        this.count = $('#' + container).find('.wpuf-attachment-list > li').length; //count how many items are there

        //if no element found on the page, bail out
        if( !$('#'+browse_button).length ) {
            return;
        }

        //instantiate the uploader, pl upload from wp-includes
        this.uploader = new plupload.Uploader({
            runtimes: 'html5,html4',
            browse_button: browse_button,
            container: container,
            multipart: true,
            multipart_params: {
                action: 'mk_upload_file'
            },
            multiple_queues: false,
            multi_selection: false,
            urlstream_upload: true,
            file_data_name: 'wpuf_file',
            max_file_size: max_file_size + 'kb',
            url: wpuf_frontend_upload.plupload.url + '&type=' + type,
            flash_swf_url: wpuf_frontend_upload.flash_swf_url,
            filters: [{
                title: 'Allowed Files',
                extensions: allowed_type
            }]
        });

        //attach event handlers events defined in plupload
        //Fires when the current RunTime has been initialized.
        this.uploader.bind('Init', $.proxy(this, 'init'));
        //Fires after files were filtered and added to the queue.
        this.uploader.bind('FilesAdded', $.proxy(this, 'added'));
        //QueueChanged
        this.uploader.bind('QueueChanged', $.proxy(this, 'upload'));
        //Fires while a file is being uploaded. Use this event to update the current file upload progress.
        this.uploader.bind('UploadProgress', $.proxy(this, 'progress'));
        //Fires when a error occurs.
        this.uploader.bind('Error', $.proxy(this, 'error'));
        //Fires when a file is successfully uploaded.
        this.uploader.bind('FileUploaded', $.proxy(this, 'uploaded'));

        this.uploader.init();

        $('#' + container).on('click', 'a.attachment-delete', $.proxy(this.removeAttachment, this));
    };

    WPUF_Uploader.prototype = {

        init: function (up, params) {
            this.showHide();
        },

        showHide: function () {

            if ( this.count >= this.max) {
                $('#' + this.container).find('.file-selector').hide();

                return;
            };

            $('#' + this.container).find('.file-selector').show();
        },

        added: function (up, files) {
            var $container = $('#' + this.container).find('.wpuf-attachment-upload-filelist');

            this.count += 1;
            this.showHide();

            $.each(files, function(i, file) {
                $container.append(
                    '<div class="upload-item" id="' + file.id + '"><div class="progress progress-striped active"><div class="bar"></div></div><div class="filename original">' +
                    file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                    '</div></div>');
            });

            up.refresh(); // Reposition Flash/Silverlight
            up.start();
        },

        upload: function (uploader) {
            this.uploader.start();
        },

        progress: function (up, file) {
            var item = $('#' + file.id);

            $('.bar', item).css({ width: file.percent + '%' });
            $('.percent', item).html( file.percent + '%' );
            //MAKUSI
            $('.bar').html(file.percent+ '%');
        },

        error: function (up, error) {
            //alert('error');
            $('#' + this.container).find('#' + error.file.id).remove();
            alert('Error #' + error.code + ': ' + error.message);

            this.count -= 1;
            this.showHide();
            this.uploader.refresh();
        },

        uploaded: function (up, file, response) {
            $('#' + file.id + " b").html("100%");
            $('#' + file.id).remove();
            console.log(response.response);
            if(response.response !== 'error') {
                var $container = $('#' + this.container).find('.wpuf-attachment-list');
                $container.append(response.response);
                //MAKUSI
                //ACTIVATE BUTTON
                $('.wpuf-submit input').show('slow');
            } else {
                alert(response.error);
 
                this.count -= 1;
                this.showHide();
            }
        },
        
        removeAttachment: function(e) {
            e.preventDefault();

            var self = this,
            el = $(e.currentTarget);

            if ( confirm(wpuf_frontend_upload.confirmMsg) ) {
                var data = {
                    'attach_id' : el.data('attach_id'),
                    'nonce' : wpuf_frontend_upload.nonce,
                    'action' : 'wpuf_file_del'
                };

                jQuery.post(wpuf_frontend_upload.ajaxurl, data, function() {
                    el.parent().parent().remove();

                    self.count -= 1;
                    self.showHide();
                    self.uploader.refresh();
                });
            }
        }
    };
})(jQuery);