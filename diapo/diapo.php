<?php 

class Galerie_Meta_Box {
    public $meta_box = array(
        'id' => 'elementor-gallery-meta-box',
        'title' => 'Personnalisation de la galerie',
        'page' => array('page', 'post'),
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => 'Type de galerie',
                'id' => 'gallery-type',
                'type' => 'radio',
                'options' => array(
                    array('name' => 'Aucune galerie', 'value' => 'nogallery'),
                    array('name' => 'Miniatures', 'value' => 'thumbnailgallery'),
                    array('name' => '2 Colonnes', 'value' => 'twocolumnsgallery'),
                    array('name' => 'Grand Format', 'value' => 'fullwidthgallery'),
                    array('name' => 'Grand Format sans miniatures', 'value' => 'fullwidthonly')
                )
            ),
            array(
                'name' => 'Montrer une légende',
                'id' => 'gallery-caption',
                'type' => 'select',
                'options' => array(
                    array('name' => 'Non', 'value' => 'hidecaption'),
                    array('name' => 'Titre', 'value' => 'title'),
                    array('name' => 'Légende', 'value' => 'caption'),
                    array('name' => 'Titre + Légende', 'value' => 'titleandcaption')
                )
            ),
            array(
                'name' => 'Affichage',
                'id' => 'gallery-image',
                'type' => 'select',
                'options' => array(
                    array('name' => 'Auto', 'value' => 'auto'),
                    array('name' => 'Ajuster', 'value' => 'contain'),
                    array('name' => 'Remplir', 'value' => 'cover')
                )
            ),
            array(
                'name' => 'Navigation',
                'id' => 'gallery-navigation',
                'type' => 'select',
                'options' => array(
                    array('name' => 'Non', 'value' => 'hidenavigation'),
                    array('name' => 'Oui', 'value' => 'shownavigation')
                )
            )            
        )
    );
    public function __construct() {
        if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }
    }
    public function init_metabox() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
    }
    public function add_metabox() {
        add_meta_box($this->meta_box['id'], $this->meta_box['title'], array( $this, 'render_metabox' ), apply_filters( 'filter_add_post_type_metabox', $this->meta_box['page']), $this->meta_box['context'], $this->meta_box['priority']);
    }
    public function render_metabox( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'galerie_nonce_action', 'galerie_nonce' );
        $echo = '';
        foreach ($this->meta_box['fields'] as $field) {
            // get current post meta data
            $meta = get_post_meta( $post->ID, $field['id'], true );
            switch ($field['id']) {
                case 'gallery-type':
                    $echo .= '<div class="gallery-custom-item">';
                    $echo .= '<span class="gallery-custom-label-wrapper"><label class="gallery-custom-label" for="gallery-type">'.$field['name'].'</label></span>';
                    $echo .= '<select name="' . $field['id'] . '" id="' . $field['id'] . '" class="gallery-custom-select">';
                    foreach ($field['options'] as $option) {
                        $echo .= '<option value="' . $option['value'] . '"'. ( $meta == $option['value'] ? ' selected="selected"' : '' ) . '> ' . $option['name'] . '</option>';
                    }
                    $echo .= '</select>';
                    $echo .= '</div>';
                    break;
                case 'gallery-caption':
                    $echo .= '<div class="gallery-custom-item">';
                    $echo .= '<span class="gallery-custom-label-wrapper"><label class="gallery-custom-label" for="gallery-caption">'.$field['name'].'</label></span>';
                    $echo .= '<select name="' . $field['id'] . '" id="' . $field['id'] . '" class="gallery-custom-select">';
                    foreach ($field['options'] as $option) {
                        $echo .= '<option value="' . $option['value'] . '"'. ( $meta == $option['value'] ? ' selected="selected"' : '' ) . '> ' . $option['name'] . '</option>';
                    }
                    $echo .= '</select>';
                    $echo .= '<i>(seul le titre s\'affichera si vous avez sélectionné "miniatures" en type de gallerie)</i>';
                    $echo .= '</div>';
                    break;
                case 'gallery-image':
                    $echo .= '<div class="gallery-custom-item">';
                    $echo .= '<span class="gallery-custom-label-wrapper"><label class="gallery-custom-label" for="gallery-image">'.$field['name'].'</label></span>';
                    $echo .= '<select name="' . $field['id'] . '" id="' . $field['id'] . '" class="gallery-custom-select">';
                    foreach ($field['options'] as $option) {
                        $echo .= '<option value="' . $option['value'] . '"'. ( $meta == $option['value'] ? ' selected="selected"' : '' ) . '> ' . $option['name'] . '</option>';
                    }
                    $echo .= '</select>';
                    $echo .= '</div>';
                    break;
                case 'gallery-navigation':
                    $echo .= '<div class="gallery-custom-item">';
                    $echo .= '<span class="gallery-custom-label-wrapper"><label class="gallery-custom-label" for="gallery-navigation">'.$field['name'].'</label></span>';
                    $echo .= '<select name="' . $field['id'] . '" id="' . $field['id'] . '" class="gallery-custom-select">';
                    foreach ($field['options'] as $option) {
                        $echo .= '<option value="' . $option['value'] . '"'. ( $meta == $option['value'] ? ' selected="selected"' : '' ) . '> ' . $option['name'] . '</option>';
                    }
                    $echo .= '</select>';
                    $echo .= '</div>';
                    break;
            }
        }
        echo $echo;
        
    }
    public function save_metabox( $post_id, $post ) {
        // Add nonce for security and authentication.
        $nonce_name   = $_POST['galerie_nonce'];
        $nonce_action = 'galerie_nonce_action';
        // Check if a nonce is set.
        if ( ! isset( $nonce_name ) )
            return;
        // Check if a nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
            return;
        // Check if the user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;
        // Check if it's not an autosave.
        if ( wp_is_post_autosave( $post_id ) )
            return;
        // Check if it's not a revision.
        if ( wp_is_post_revision( $post_id ) )
            return;
        foreach ( $this->meta_box['fields'] as $field ) {
            $old = get_post_meta( $post_id, $field['id'], true );
            $new = isset( $_POST[$field['id']] ) ? sanitize_text_field( $_POST[ $field['id'] ] ) : '';
            if ($new && $new != $old) {
                update_post_meta( $post_id, $field['id'], $new );
            } elseif ('' == $new && $old) {
                delete_post_meta( $post_id, $field['id'], $old );
            }
        }
    }
}
$gmb = new Galerie_Meta_Box();

add_action('admin_head', 'override_jerico_ui_meosis');
function override_jerico_ui_meosis() {
  echo '<style>
    #elementor-gallery-meta-box .gallery-custom-label {
        width: 130px;
        text-align: right;
        display: inline-block;
        margin-right: 10px;
        font-weight: bold;
    }
    #elementor-gallery-meta-box .gallery-custom-select {
        width: 20%;
        display: inline-block;
    }
    #elementor-gallery-meta-box .gallery-custom-item {
        margin-bottom: 15px;
    }
    #elementor-gallery-meta-box .gallery-custom-item:last-of-type {
        margin-bottom: 0;
    }
    #elementor-gallery-meta-box .gallery-custom-item i {
        margin-left: 15px;
    }
  </style>';
}

// shortcode a ajouter dans les pages interne
if( !function_exists( 'function_shortcode_galerie' ) ):
function function_shortcode_galerie() {
    ob_start();
    $type_gallerie = get_post_meta(get_the_ID(), 'gallery-type', true); 
    $gallerie_navigation = get_post_meta(get_the_ID(), 'gallery-navigation', true);
    if ( $type_gallerie != 'nogallery' ) { ?>
    <section class="galerie-dynamique-wrapper<?php if($type_gallerie == 'fullwidthgallery' || $type_gallerie == 'fullwidthonly'): ?> fullwidth<?php elseif($type_gallerie == 'twocolumnsgallery'): ?> twocolumns<?php else: ?> thumbnails<?php endif; ?>">
        <?php get_gallerie_image(); ?>
    </section>
<?php }
    return ob_get_clean();
}
endif;
add_shortcode('galerie', 'function_shortcode_galerie');

// ajout des tailles d'image
add_image_size( 'diapo-thumb', 120, 120, true );
add_image_size( 'diapo', 1180, 500, true );

if ( ! function_exists( 'is_plugin_active' ) ){
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

// fontion de la gallerie
if( !function_exists( 'get_gallerie_image' ) ):
function get_gallerie_image() {
    global $post, $_wp_additional_image_sizes;

    $type_gallerie = get_post_meta(get_the_ID(), 'gallery-type', true); 
    $gallerie_display = get_post_meta(get_the_ID(), 'gallery-image', true);
    $gallerie_caption = get_post_meta(get_the_ID(), 'gallery-caption', true);
    $gallerie_navigation = get_post_meta(get_the_ID(), 'gallery-navigation', true);

    $meoattachments = get_post_meta(get_the_ID(), 'attachments', true); /* pass the instance name */
    if( !empty($meoattachments) ) : ?>
        <div id="galerie-dynamique">
        <?php foreach ($meoattachments as $key => $value) :
            $img_url = wp_get_attachment_image_src($value['id'], 'full');
            $img_url = $img_url[0];
            $attachment_title = $value['fields']['title'];
            $attachment_caption = $value['fields']['caption']; ?>
            <a class="galerie-dynamique-slide galerie-item galerie-id-<?php echo $value['id']; ?> swipebox" <?php if ( is_plugin_active('elementor/elementor.php') ) { echo 'data-elementor-open-lightbox="no"'; } ?> href="<?php echo $img_url; ?>" title="<?php echo $attachment_title; ?>" data-title="<?php echo $attachment_title; ?>" data-caption="<?php echo $attachment_caption; ?>"style="background-image: url(<?php echo $img_url; ?>); <?php if ( $gallerie_display == 'cover' ): ?>background-size: cover;<?php elseif ( $gallerie_display == 'contain' ): ?>background-size: contain;<?php endif; ?>"><?php if (($gallerie_caption != 'hidecaption') && (!empty($attachment_title) || !empty($attachment_caption)) ) : ?><span class="galerie-dynamique-caption<?php if ( $gallerie_caption == 'title' ) : ?> title<?php elseif ( $gallerie_caption == 'caption' ) : ?> caption<?php else : ?> titleandcaption<?php endif; ?>"><?php if ( $gallerie_caption == 'title' || $type_gallerie == 'thumbnailgallery' ) : ?><?php if( !empty($attachment_title) ) { ?><span class="title"><?php echo strip_tags($attachment_title); ?></span><?php } ?><?php elseif ( $gallerie_caption == 'caption' ) : ?><?php if( !empty($attachment_caption) ) { ?><span class="caption"><?php echo strip_tags($attachment_caption); ?></span><?php } ?><?php else : ?><?php if( !empty($attachment_title) ) { ?><span class="title"><?php echo strip_tags($attachment_title); ?></span><?php } ?><?php if( !empty($attachment_caption) ) { ?><span class="caption"><?php echo strip_tags($attachment_caption); ?></span><?php } ?><?php endif; ?></span><?php endif; ?></a>
        <?php endforeach; ?>
        </div>
    <?php endif;
    if ($type_gallerie != 'thumbnailgallery' ) {
        if ( $gallerie_navigation == 'shownavigation' ) { 
            $arrows = 'true'; 
        } else { 
            $arrows = 'false'; 
        }
        if ( $type_gallerie == 'twocolumnsgallery' || $type_gallerie == 'fullwidthgallery' ): ?>
            <script type="text/javascript">

              // galerie page internes
              var $meoDiapo = $('#galerie-dynamique');
              var arrows = <?php echo $arrows; ?>;
              $(window).on('load', function () {
                $meoDiapo.slick({
                    arrows: arrows,
                    dots: true,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    speed : 400,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    customPaging : function(slider, i) {
                        var thumb = $(slider.$slides[i]).attr('href');
                        var title = $(slider.$slides[i]).attr('title');
                        return '<span class="galerie-thumb" title="'+title+'" style="background-image: url('+thumb+');"></span>';
                    }
                });
              });
            </script>
        <?php else : ?>
            <script type="text/javascript">
              // galerie page internes
              var $meoDiapo = $('#galerie-dynamique');
              var arrows = <?php echo $arrows; ?>;
              $(window).on('load', function () {
                $meoDiapo.slick({
                  arrows: arrows,
                  dots: false,
                  autoplay: true,
                  autoplaySpeed: 5000,
                  speed : 400,
                  slidesToShow: 1,
                  slidesToScroll: 1,
                });
              });
            </script>
        <?php endif; ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                $(window).on({
                    scroll: function() {
                        scrollCheck();
                    },
                    load: function(){
                        scrollCheck();
                    },
                    resize: function(){
                        scrollCheck();
                    }
                });
                function scrollCheck(){
                    var bigImgHeight = $("#galerie-dynamique .slick-list").outerHeight();
                    var arrowsHeight = bigImgHeight / 2;
                    $("#galerie-dynamique .slick-prev, #galerie-dynamique .slick-next").css("top", arrowsHeight);
                }
            });
        </script>
    <?php }
}
endif;

add_action( 'init', 'diapo', 999);
function diapo() {
    if (file_exists(get_stylesheet_directory() . '/diapo/css/magnific-popup.css')) {
       wp_enqueue_style( 'magnific-popup-css', get_stylesheet_directory_uri() . '/diapo/css/magnific-popup.css' );
    }
    if (file_exists(get_stylesheet_directory() . '/diapo/js/jquery.magnific-popup.js')) {
       wp_enqueue_script( 'magnific-popup-js', get_stylesheet_directory_uri() . '/diapo/js/jquery.magnific-popup.js', array('jquery', 'jquery-ui-sortable') );
    }
    if (file_exists(get_stylesheet_directory() . '/diapo/css/diapo.css')) {
       wp_enqueue_style( 'meo-slider', get_stylesheet_directory_uri() . '/diapo/css/diapo.css' );
    }
    if (file_exists(get_stylesheet_directory() . '/diapo/js/diapo.js')) {
       wp_enqueue_script( 'meo-slider-js', get_stylesheet_directory_uri() . '/diapo/js/diapo.js', array('jquery', 'jquery-ui-sortable') );
    }
}

?>