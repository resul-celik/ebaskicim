jQuery(function($){
    
    $('.update-address-summary').on('click', function(){
        
        var data = {
            
            action: 'get_address_field'
            
        }
        
        var ajaxUrl = ajax_get_address_params.ajaxurl;
        
        $.ajax({
            
            url: ajaxUrl,
            data: data,
            type: 'POST',
            beforeSend: function(){
                
                $('.billing-summary-fields').css({
                
                    opacity: '.3'
                
                });
                
            },
            success: function(data){
                
                $('.billing-summary-fields').html(data).css({
                    
                    opacity: 1
                    
                });
                
            }
            
        });
        
    });
    
    $(document).ready(function () {
  function media_upload(button_selector) {
    var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;
    $('body').on('click', button_selector, function () {
      var button_id = $(this).attr('id');
      wp.media.editor.send.attachment = function (props, attachment) {
        if (_custom_media) {
          $('.' + button_id + '_img').attr('src', attachment.url);
          $('.' + button_id + '_url').val(attachment.url);
        } else {
          return _orig_send_attachment.apply($('#' + button_id), [props, attachment]);
        }
      }
      wp.media.editor.open($('#' + button_id));
      return false;
    });
  }
  media_upload('.js_custom_upload_media');
});
    
});