$(function(){

    $('#customdesign').change(function(e){
        
        console.log("ok");
        
        e.preventDefault();
        
        var fileName = $(this).prop('files')[0].name;
        var fileSize = $(this).prop('files')[0].size;
        var fileType = $(this).prop('files')[0].type;
        var fileError = $(this).prop('files')[0].error;
        
        
        if (fileSize > 105906176) {
            
            $('.file-upload-field').addClass('file-error');
            $('.percent-bar').width('0%');
            $('.custom-file-name').text('Dosya boyutu izin verilen boyutu aşıyor. (max. 100 MB)');
            $('.upload-percent').text(' ');
            
        } else if (fileType != 'application/zip' && fileType != 'application/x-zip-compressed') {
                   
            $('.file-upload-field').addClass('file-error');
            $('.percent-bar').width('0%');
            $('.custom-file-name').text('Dosya türü geçersiz, lütfen sadece ".zip" deneyin.');
            $('.upload-percent').text(' ');
                   
        } else {
            
            $('.custom-file-name').text(fileName);

            var formData = new FormData(document.getElementById('custom-design-form'));

            var button = $(this);

            formData.append('action', 'ozeltasarim');
            formData.append('postid', ozel_tasarim_params.postID);
            formData.append('columnindex', 'request');
            
            console.log(formData);

            $.ajax({

                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {

                        if (evt.lengthComputable) {
                            
                            var percentComplete = Math.floor((evt.loaded / evt.total) * 100);
                            $(".upload-percent").text('('+percentComplete+'%)');
                            $(".percent-bar").width(percentComplete+'%');

                        }

                    }, false);
                    return xhr;
                },
                url : ozel_tasarim_params.ajaxurl,
                data : formData,
                type : 'POST',
                processData: false,
                contentType: false,
                success : function( data ){

                    if (data == 'size_err') {

                        $('.file-upload-field').addClass('file-error');
                        $('.percent-bar').width('0%');
                        $('.custom-file-name').text('Dosya boyutu izin verilen boyutu aşıyor. (max. 100 MB)');
                        $('.upload-percent').text(' ');

                    } else if (data == 'filetype_err') {

                        $('.file-upload-field').addClass('file-error');
                        $('.percent-bar').width('0%');
                        $('.custom-file-name').text('Dosya türü geçersiz, lütfen sadece ".zip" deneyin.');
                        $('.upload-percent').text(' ');

                    } else {

                        $('#custom-design-form').hide();
                        $('#customdesign').val('');
                        $('.uploaded-file-field').css('display', 'flex');
                        $(".uploaded-file-name").text(fileName);

                    }

                },
                error: function(resp) {
                    
                    console.log(resp);

                    $('.file-upload-field').addClass('file-error');
                    $('.percent-bar').width('0%');
                    $('.custom-file-name').text('Bilinmeyen bir hata oluştu.');
                    $('.upload-percent').text(' ');

                },
                

            });
            
        }  

    });
    
    $('.remove-uploaded-file').click(function(){
        
        var cookpoID = $(this).attr('post-in');
        
        $('.file-upload-field').removeClass('file-error');
        
        Cookies.remove("ozel_tasarim_"+cookpoID);
        Cookies.remove("ozel_tasarim_adi_"+cookpoID);
        $('.uploaded-file-field').hide();
        $('#custom-design-form').show();
        $('.custom-file-name').text('Özel tasarım dosyası seç');
        $('.upload-percent').text(' ');
        $('.percent-bar').width('0%');
        
    });

});