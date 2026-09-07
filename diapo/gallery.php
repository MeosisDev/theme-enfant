<?php

require_once(get_stylesheet_directory() .'/diapo/diapo.php');

add_action('admin_head', function(){
    remove_meta_box('my-meta-box', array('post', 'page'), 'side');
});
remove_action( 'init', 'add_diaporama_post_type');
remove_action( 'add_meta_boxes', array( $meoatt, 'meta_box_init' ) );

function deactivate_plugin_conditional() {
  if ( is_plugin_active('wp-simple-zoombox/wp-simple-zoombox.php') ) {
    deactivate_plugins('wp-simple-zoombox/wp-simple-zoombox.php');    
  }
}
add_action( 'admin_init', 'deactivate_plugin_conditional' );

function galerie_metabox_enqueue_scripts($hook) {
    if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
      wp_enqueue_script('galerie-metabox-js', get_stylesheet_directory_uri() . '/diapo/js/gallery-metabox.js', array('jquery', 'jquery-ui-sortable'));
      wp_enqueue_style('galerie-metabox-css', get_stylesheet_directory_uri() . '/diapo/css/gallery-metabox.css');
    }
}
add_action('admin_enqueue_scripts', 'galerie_metabox_enqueue_scripts');

function add_galerie_metabox() {
    add_meta_box( 'galerie-metabox', 'Galerie', 'galerie_render', array('post', 'page'), 'normal', 'high' );
}
add_action('add_meta_boxes', 'add_galerie_metabox');

function galerie_render($post) {
    wp_nonce_field( basename(__FILE__), 'galerie_meta_nonce' );
    $idtest = get_post_meta($post->ID, 'attachments', true);
    if (is_string($idtest)) {
        $idtest = json_decode($idtest, true);
        $idtest = $idtest['attachments'];
    }
    ?>
    <table class="form-table">
      <tr><td>
        <a class="add-button button" href="#" data-uploader-title="Ajouter à la galerie" data-uploader-button-text="Ajouter une image">Ajouter une image</a>

        <?php if ($idtest) : ?>
            <div id="galerie-metabox-list">
            <?php foreach ($idtest as $key => $value) : $image = wp_get_attachment_image_src($idtest[$key]['id'], 'full'); ?>

              <div class="galerie-metabox-item">
                <div class="galerie-metabox-image">
                    <input type="hidden" name="attachments[<?php echo $key; ?>][id]" value="<?php echo $idtest[$key]['id']; ?>">
                    <div class="image-preview" style="background-image: url(<?php echo $image[0]; ?>);"></div>
                    <a class="change-button button button-small" href="#" data-uploader-title="Modifier image" data-uploader-button-text="Modifier image">Modifier l'image</a>
                    <a class="remove-button" href="#">Supprimer l'image</a>
                    <div class="caption-preview">
                        <span><?php if(!empty($idtest[$key]['fields']['title'])) {echo $idtest[$key]['fields']['title']; } ?></span>
                        <a class="caption-button" href="#" data-uploader-title="Modifier légende" data-uploader-button-text="Modifier légende">Modifier légende</a>
                    </div>
                </div>
                <div class="image-caption">
                    <div class="image-caption-title">
                          <p class="image-caption-wrapper"><label for="image-caption-title" class="image-caption-label">Titre de l'image</label></p>
                          <input type="text" id="image-caption-title" name="attachments[<?php echo $key; ?>][fields][title]" value="<?php echo $idtest[$key]['fields']['title']; ?>">
                          <p class="image-caption-wrapper"><label for="caption-<?php echo $idtest[$key]['id']; ?>" class="image-caption-label">Légende de l'image</label></p>
                          <textarea name="attachments[<?php echo $key; ?>][fields][caption]" id="caption-<?php echo $idtest[$key]['id']; ?>" value="<?php echo $idtest[$key]['fields']['caption']; ?>"><?php echo $idtest[$key]['fields']['caption']; ?></textarea>
                    </div>
                    <a class="save-button" href="#" data-uploader-title="Sauvegarder légende" data-uploader-button-text="Sauvegarder légende">Sauvegarder légende</a>
                    <a class="close-button" href="#">Supprimer l'image</a>
                </div>
              </div>

            <?php endforeach; ?>
            </div>
        <?php endif; ?>

      </td></tr>
    </table>
<?php }

function save_galerie_metabox($post_id) {
    if (!isset($_POST['galerie_meta_nonce']) || !wp_verify_nonce($_POST['galerie_meta_nonce'], basename(__FILE__))) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if(isset($_POST['attachments'])) {
      update_post_meta($post_id, 'attachments', $_POST['attachments']);
    } else {
      delete_post_meta($post_id, 'attachments');
    }
}
add_action('save_post', 'save_galerie_metabox');