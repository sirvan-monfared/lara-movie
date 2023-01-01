(function(){

    var uploaded_images = [];
    var all_uploaded_images = [];
    var hidden_form_input = $("#uploaded_images_input");
    var hidden_all_images_input = $("#all_uploaded_images_input");
    var uploader_wrapper = $("#upload_images_part");
    var uploader_div = $("#uploader-part");
    var upload_url = '../process/pr_ajax_upload.php';
    if(typeof form_upload_url != 'undefined') {
        upload_url = form_upload_url;
    }

    // handles removing of uploaded images
    $("#upload_images_part").on('click', '*[data-click-removes-image]', function(e)
    {
        var $this = $(this);
        image_id       = $this.attr("data-id");
        parent_wrapper = $this.parent();

        parent_wrapper.html("<div class='drop-images uploading'><span class='hover-icon'><i class='fa fa-spinner fa-spin'></i><br/>" + LANG__DELETING + "</span></div>")

        $.ajax({
            url: "../process/pr_delete.php",
            type:"POST",
            data:{
                name: getImageName(image_id),
                action: "remove-uploaded-image"
            },
            success:function(z){
                removeFromImages(image_id);
                parent_wrapper.html("<div class='drop-images' data-click-starts-choose-file id='upload_btn_"+image_id+"'><span class='hover-icon'><i class='fa fa-plus'></i><br/>" + LANG__ADD_IMAGE + "</span></div>");
                create_new_bind_event_for_upload(image_id);
            }
        })
    });

    // function for bind event on upload forms
    function create_new_bind_event_for_upload(form_id) {
        var btn = $('#upload_btn_'+form_id);
        var parent_wrapper = btn.parent();
        var field_id = parent_wrapper.attr("data-field-id");

        new ss.SimpleUpload({
            button: btn,
            url: upload_url,
            name: 'estateImages',
            multipart: true,
            hoverClass: 'hover',
            focusClass: 'focus',
            responseType: 'json',
            customHeaders: {
                'X-CSRF-TOKEN': getCsrfToken()
            },
            startXHR: function(xhr) {
            },
            onSubmit: function() {
                btn.addClass('uploading');
                btn.find('.hover-icon').html("<i class='fa fa-spinner fa-spin'></i><br/>" + LANG__UPLOADING + " ... ");
            },
            onComplete: function( filename, response ) {

                if ( ! response ) {
                    btn.removeClass('uploading').addClass('upload-error');
                    return;
                }

                if ( response.status ) {

                    addToImages(field_id, response.file_name);

                    btn.removeClass('uploading').addClass('upload-success');

                    btn.remove();
                    parent_wrapper.html("<img src='" + response.file_path + "' class='drop-images'/>");
                    parent_wrapper.append("<figcaption data-click-removes-image data-id='"+field_id+"' class='figcaption'><i class='fa fa-times'></i></figcaption>")
                } else {
                    errorToast(response.errors);
                    btn.removeClass('uploading').addClass('upload-error');
                    btn.find('.hover-icon').html("<i class='fa fa-times'></i><br> " + LANG__ADD_IMAGE);
                }
            },
            onError: function() {
                btn.removeClass('uploading').addClass('upload-error');
                btn.find('.hover-icon').html("<i class='fa fa-times'></i><br> " + LANG__ADD_IMAGE);
            },
            onSizeError: function( filename, fileSize ) {
                btn.removeClass('uploading').addClass('upload-error');
                msgBox.html(LANG__MAX_SIZE_ERROR);
            }
        });
    }

    function addToImages(image_id, file_name) {
        var index = findIndexOfImage(image_id);

        uploaded_images[index] = {
            id: image_id,
            name: file_name
        };

        all_uploaded_images.push(file_name);
        updateFormInput();
    }

    function removeFromImages(image_id) {
        var index = findIndexOfImage(image_id);

        uploaded_images[index] = {
            id: image_id,
            name: null
        };

        updateFormInput();
    }

    function getImageName(image_id) {
        var index = findIndexOfImage(image_id);

        return uploaded_images[index].name;
    }

    function findIndexOfImage(image_id) {

        var indexes = $.map(uploaded_images, function(obj, index) {
            if(obj.id == image_id) {
                return index;
            }
        });

        return indexes[0];
    }

    function updateFormInput() {
        hidden_form_input.val(JSON.stringify(uploaded_images));
        hidden_all_images_input.val(JSON.stringify(all_uploaded_images));
    }

    function escapeTags( str ) {
        return String( str )
            .replace( /&/g, '&amp;' )
            .replace( /"/g, '&quot;' )
            .replace( /'/g, '&#39;' )
            .replace( /</g, '&lt;' )
            .replace( />/g, '&gt;' );
    }


    function initiate() {
        var start = 1;
        if(preuploaded_images_count > 0) {
            start = parseInt(preuploaded_images_count) + 1;
            for(var i = 1; i < start; i++) {
                uploaded_images.push({ id: i, name: i+'.jpg'});
            }
        }

        for (var i = start; i <= images_count; i++) {

            create_new_bind_event_for_upload(i);
            uploaded_images.push({ id: i, name: null });
        }

        uploader_wrapper.on("mouseenter", ".hover-wrapper", function() {
            $(this).find('.figcaption').animate({'opacity':1})
        });
        uploader_wrapper.on("mouseleave", ".hover-wrapper", function() {
            $(this).find('.figcaption').animate({'opacity':0})
        });
    }

    function reInitiate() {

        if(images_count > 0) {
            uploader_div.slideDown();
        }

        if(shouldDeleteUploaders()) {
            deleteRedudantUploaders()
            uploaded_images.length = images_count;
        }

        if(shouldAddUploaders()) {
            addNeededUploaders();
        }

        if(images_count == 0) {
            uploader_div.slideUp();
        }

    }

    function shouldAddUploaders() {
        return (images_count > uploaded_images.length);
    }

    function addNeededUploaders() {
        var start = (uploaded_images.length) + 1;
        var end   = images_count;

        for(var i = start; i <= end; i++) {
            addAnUploader(i);
        }
    }

    function addAnUploader(uploader_id) {
        var html = " <figure class='hover-wrapper' data-field-id='"+uploader_id+"'> <div class='drop-images' data-click-starts-choose-file id='upload_btn_"+uploader_id+"'> <span class='hover-icon'><i class='fa fa-plus'></i><br/>" + LANG__ADD_IMAGE + "</span> </div> </figure> ";
        uploader_wrapper.append(html);
        create_new_bind_event_for_upload(uploader_id);
        uploaded_images.push({ id: uploader_id, name: null});
    }


    function shouldDeleteUploaders() {
        return (uploaded_images.length > images_count);
    }

    function deleteRedudantUploaders() {
        var start = parseInt(images_count) + 1;
        var end   = uploaded_images.length;

        for (var i = start; i <= end; i++) {
            deleteUploader(i);
        }
    }

    function deleteUploader(id) {
        uploader_wrapper.find("[data-field-id='" + id + "']").remove();
    }

    function getCsrfToken() {
        return uploader_wrapper.find("input[name='token']").val();
    }

    $("#create-more-uploaders").on('click', function() {
        images_count = parseInt(images_count) + 3;
        reInitiate();
    });

    initiate();

})();