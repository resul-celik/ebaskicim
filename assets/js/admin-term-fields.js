jQuery(function ($) {

  // Color picker
  $('.ebs-color-picker').wpColorPicker();

  // Media uploader — one instance shared across buttons
  var mediaUploader;

  $(document).on('click', '.ebs-upload-image-btn', function (e) {
    e.preventDefault();
    var $btn     = $(this);
    var $wrap    = $btn.closest('.ebs-term-image-wrap');
    var $input   = $wrap.find('#ebs_term_image');
    var $preview = $wrap.find('#ebs_term_image_preview');
    var $remove  = $wrap.find('.ebs-remove-image-btn');

    if (mediaUploader) {
      mediaUploader.open();
      return;
    }

    mediaUploader = wp.media({
      title: 'Görsel Seç',
      button: { text: 'Seç' },
      multiple: false,
      library: { type: 'image' },
    });

    mediaUploader.on('select', function () {
      var attachment = mediaUploader.state().get('selection').first().toJSON();
      $input.val(attachment.id);
      $preview.attr('src', attachment.url).show();
      $remove.show();
    });

    mediaUploader.open();
  });

  $(document).on('click', '.ebs-remove-image-btn', function (e) {
    e.preventDefault();
    var $wrap    = $(this).closest('.ebs-term-image-wrap');
    $wrap.find('#ebs_term_image').val('');
    $wrap.find('#ebs_term_image_preview').attr('src', '').hide();
    $(this).hide();
  });

});
