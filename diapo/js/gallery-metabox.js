jQuery(function($) {

  var file_frame;

  $(document).on('click', '#galerie-metabox a.add-button', function(e) {

    e.preventDefault();

    if (file_frame) file_frame.close();

    file_frame = wp.media.frames.file_frame = wp.media({
      title: $(this).data('uploader-title'),
      button: {
        text: $(this).data('uploader-button-text'),
      },
      multiple: true
    });

    file_frame.on('select', function() {
      var listIndex = $('#galerie-metabox-list .galerie-metabox-item').index($('#galerie-metabox-list .galerie-metabox-item:last')),
          selection = file_frame.state().get('selection');

      selection.map(function(attachment, i) {
        attachment = attachment.toJSON(),
        index      = listIndex + (i + 1);

        if ( $( "#galerie-metabox-list" ).length ) {
        } else {
          $('<div id="galerie-metabox-list"></div>').insertAfter($('.form-table .add-button'));
        }

        $('#galerie-metabox-list').append('<div class="galerie-metabox-item"><div class="galerie-metabox-image"><input type="hidden" name="attachments[' + index + '][id]" value="' + attachment.id + '"><div class="image-preview" style="background-image: url(' + attachment.url + ');"></div><a class="change-button button button-small" href="#" data-uploader-title="Modifier image" data-uploader-button-text="Modifier image">Modifier l\'image</a><a class="remove-button" href="#">Supprimer l\'image</a><div class="caption-preview"><span></span><a class="caption-button" href="#" data-uploader-title="Modifier légende" data-uploader-button-text="Modifier légende">Modifier légende</a></div></div><div class="image-caption"><div class="image-caption-title"><p class="image-caption-wrapper"><label for="image-caption-title" class="image-title-label">Titre de l\'image</label></p><input type="text" id="image-caption-title" name="attachments[' + index + '][fields][title]" value=""><p class="image-caption-wrapper"><label for="caption-' + attachment.id + '" class="image-caption-label">Légende de l\'image</label></p><textarea name="attachments[' + index + '][fields][caption]" id="caption-' + attachment.id + '" value="attachments[' + index + '][fields][caption]"></textarea></div><a class="save-button" href="#" data-uploader-title="Sauvegarder légende" data-uploader-button-text="Sauvegarder légende">Sauvegarder légende</a><a class="close-button" href="#">Fermer</a></div></div>');
      });
    });

    makeSortable();
    
    file_frame.open();

  });

  $(document).on('click', '#galerie-metabox a.change-button', function(e) {

    e.preventDefault();

    var that = $(this);

    if (file_frame) file_frame.close();

    file_frame = wp.media.frames.file_frame = wp.media({
      title: $(this).data('uploader-title'),
      button: {
        text: $(this).data('uploader-button-text'),
      },
      multiple: false
    });

    file_frame.on( 'select', function() {
      attachment = file_frame.state().get('selection').first().toJSON();

      that.parent().find('input:hidden').attr('value', attachment.id);
      that.parent().find('.image-preview').css('background-image', 'url('+attachment.url+')');
    });

    file_frame.open();

  });

  $(document).on('click', '#galerie-metabox a.save-button', function(e) {

    e.preventDefault();

    $(this).parent().find('.image-caption-title #image-caption-title').attr('value', $(this).parent().find('.image-caption-title #image-caption-title').val());
    $(this).parent().find('.image-caption-title textarea').attr('value', $(this).parent().find('.image-caption-title textarea').val());
    $(this).parent().find('.image-caption-title textarea').html($(this).parent().find('.image-caption-title textarea').val());
    $(this).parents('.galerie-metabox-item').find('.caption-preview span').html($(this).parent().find('.image-caption-title #image-caption-title').val());
    $(this).parents('.image-caption').animate({ right: '-350px', opacity: 0 }, 200);
    $(this).parents('.image-caption').parents('.galerie-metabox-item').find('a.caption-button').attr('data-click-state', 0);

  });

  function resetIndex() {
    $('#galerie-metabox-list .galerie-metabox-item').each(function(i) {
      $(this).find('input:hidden').attr('name', 'attachments[' + i + '][id]');
      $(this).find('.image-caption-title #image-caption-title').attr('name', 'attachments[' + i + '][fields][title]');
      $(this).find('.image-caption-title textarea').attr('name', 'attachments[' + i + '][fields][caption]');
    });
  }

  function makeSortable() {
    $('#galerie-metabox-list').sortable({
      opacity: 0.6,
      stop: function() {
        resetIndex();
      }
    });
  }

  $(document).on('click', '#galerie-metabox a.remove-button', function(e) {
    e.preventDefault();

    $(this).parents('.galerie-metabox-item').animate({ opacity: 0 }, 200, function() {
      $(this).remove();
      resetIndex();
    });
  });

  $('#galerie-metabox a.caption-button').attr('data-click-state', 0);
  $(document).on('click', '#galerie-metabox a.caption-button', function(e) {
    e.preventDefault();
    if($(this).attr('data-click-state') == 1) {
      $(this).attr('data-click-state', 0);
      $(this).parents('.galerie-metabox-image').parents('.galerie-metabox-item').find('.image-caption').animate({ right: '-350px', opacity: 0 }, 200);
    } else {
      $('#galerie-metabox a.caption-button').attr('data-click-state', 0);
      $('#galerie-metabox a.caption-button').parents('.galerie-metabox-image').parents('.galerie-metabox-item').find('.image-caption').animate({ right: '-350px', opacity: 0 }, 200);
      $(this).attr('data-click-state', 1);
      $(this).parents('.galerie-metabox-image').parents('.galerie-metabox-item').find('.image-caption').animate({ right: 0, opacity: 1 }, 200);
    }
  });
  $(document).on('click', '#galerie-metabox a.close-button', function(e) {
    e.preventDefault();
    $(this).parents('.image-caption').animate({ right: '-350px', opacity: 0 }, 200);
    $(this).parents('.image-caption').parents('.galerie-metabox-item').find('a.caption-button').attr('data-click-state', 0);
  });

  makeSortable();

});