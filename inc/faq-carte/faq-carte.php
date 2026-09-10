<?php
/**
 * FAQ Salon de Coiffure - Shortcode réutilisable
 *
 * @package VotreTheme
 */

// Sécurité : Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// 1. Création des champs ACF (local)
function faq_acf_local_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_faq_salon_coiffure',
        'title' => 'FAQ cartes à retourner',
        'fields' => array(
            array(
                'key' => 'field_faq_shortcode_info',
                'label' => 'Shortcode à utiliser',
                'name' => 'faq_shortcode_info',
                'type' => 'message',
                'message' => 'Pour afficher la FAQ sur une page, insérez-y le shortcode : <code>[faq_cartes_a_retourner]</code>',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),
            array(
                'key' => 'field_faq_titre',
                'label' => 'Titre principal',
                'name' => 'faq_titre',
                'type' => 'text',
                'default_value' => 'FAQ',
            ),
            array(
                'key' => 'field_faq_titre_couleur',
                'label' => 'Couleur du titre principal',
                'name' => 'faq_titre_couleur',
                'type' => 'color_picker',
                'default_value' => '#6f9284',
            ),
            array(
                'key' => 'field_faq_titre_taille',
                'label' => 'Taille du titre principal (px)',
                'name' => 'faq_titre_taille',
                'type' => 'number',
                'default_value' => 38,
                'min' => 10,
                'max' => 100,
                'step' => 1,
                'append' => 'px',
            ),
            array(
                'key' => 'field_faq_intro',
                'label' => 'Texte d\'introduction',
                'name' => 'faq_intro',
                'type' => 'text',
                'default_value' => 'Cliquez sur une carte pour découvrir la réponse',
            ),
            array(
                'key' => 'field_faq_intro_couleur',
                'label' => 'Couleur du texte d\'introduction',
                'name' => 'faq_intro_couleur',
                'type' => 'color_picker',
                'default_value' => '#4a4a4a',
            ),
            array(
                'key' => 'field_faq_intro_taille',
                'label' => 'Taille du texte d\'introduction (px)',
                'name' => 'faq_intro_taille',
                'type' => 'number',
                'default_value' => 16,
                'min' => 8,
                'max' => 60,
                'step' => 1,
                'append' => 'px',
            ),
            array(
                'key' => 'field_faq_pied',
                'label' => 'Texte du pied de section',
                'name' => 'faq_pied',
                'type' => 'text',
                'default_value' => '✂️ Passez la souris ou touchez pour retourner la carte',
            ),
            array(
                'key' => 'field_faq_pied_couleur',
                'label' => 'Couleur du texte du pied de section',
                'name' => 'faq_pied_couleur',
                'type' => 'color_picker',
                'default_value' => '#a3a3a3',
            ),
            array(
                'key' => 'field_faq_pied_taille',
                'label' => 'Taille du texte du pied de section (px)',
                'name' => 'faq_pied_taille',
                'type' => 'number',
                'default_value' => 14,
                'min' => 8,
                'max' => 60,
                'step' => 1,
                'append' => 'px',
            ),
            array(
                'key' => 'field_faq_cartes',
                'label' => 'Cartes FAQ',
                'name' => 'faq_cartes',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Ajouter une carte',
                'sub_fields' => array(
                    array(
                        'key' => 'field_faq_emoji',
                        'label' => 'Émoji',
                        'name' => 'emoji',
                        'type' => 'text',
                        'default_value' => '📍',
                    ),
                    array(
                        'key' => 'field_faq_question',
                        'label' => 'Question',
                        'name' => 'question',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_faq_reponse',
                        'label' => 'Réponse',
                        'name' => 'reponse',
                        'type' => 'textarea',
                    ),
                ),
            ),
            array(
                'key' => 'field_faq_couleur_fond',
                'label' => 'Couleur de fond des cartes (recto)',
                'name' => 'faq_couleur_fond',
                'type' => 'color_picker',
                'default_value' => '#f2e8db',
            ),
            array(
                'key' => 'field_faq_couleur_fond_verso',
                'label' => 'Couleur de fond des cartes (verso)',
                'name' => 'faq_couleur_fond_verso',
                'type' => 'color_picker',
                'default_value' => '#6f9284',
            ),
            array(
                'key' => 'field_faq_arrondi',
                'label' => 'Arrondi des cartes (px)',
                'name' => 'faq_arrondi',
                'type' => 'number',
                'instructions' => 'Mettre 0 pour supprimer l\'arrondi.',
                'default_value' => 14,
                'min' => 0,
                'max' => 50,
                'step' => 1,
                'append' => 'px',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-faq-settings',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
}
add_action('acf/init', 'faq_acf_local_fields');

// 2. Shortcode générique pour plusieurs FAQ
function faq_shortcode($atts) {
    // Récupérer les attributs du shortcode
    $atts = shortcode_atts(array(
        'id' => 'salon-coiffure', // Identifiant unique pour le CSS
        'default' => false, // Utiliser les valeurs par défaut si ACF n'est pas configuré
    ), $atts);

    // Vérifier si ACF est disponible
    if (!function_exists('get_field')) {
        return '<p>ACF n\'est pas installé ou activé.</p>';
    }

    // Récupérer les données depuis ACF (page de réglages FAQ)
    $titre = get_field('faq_titre', 'option') ?: 'FAQ carte à retourner';
    $intro = get_field('faq_intro', 'option') ?: 'Cliquez sur une carte pour découvrir la réponse';
    $pied = get_field('faq_pied', 'option') ?: '✂️ Retournez la carte pour voir la réponse';
    $cartes = get_field('faq_cartes', 'option') ?: array();
    $couleur_fond = get_field('faq_couleur_fond', 'option') ?: '#f2e8db';
    $couleur_fond_verso = get_field('faq_couleur_fond_verso', 'option') ?: '#6f9284';
    $arrondi = get_field('faq_arrondi', 'option');
    if ($arrondi === '' || $arrondi === null || $arrondi === false) {
        $arrondi = 14;
    }
    $titre_couleur = get_field('faq_titre_couleur', 'option') ?: '#6f9284';
    $titre_taille = get_field('faq_titre_taille', 'option');
    if ($titre_taille === '' || $titre_taille === null || $titre_taille === false) {
        $titre_taille = 38;
    }
    $intro_couleur = get_field('faq_intro_couleur', 'option') ?: '#4a4a4a';
    $intro_taille = get_field('faq_intro_taille', 'option');
    if ($intro_taille === '' || $intro_taille === null || $intro_taille === false) {
        $intro_taille = 16;
    }
    $pied_couleur = get_field('faq_pied_couleur', 'option') ?: '#a3a3a3';
    $pied_taille = get_field('faq_pied_taille', 'option');
    if ($pied_taille === '' || $pied_taille === null || $pied_taille === false) {
        $pied_taille = 14;
    }

    // Valeurs par défaut si ACF n'est pas configuré
    if ($atts['default'] || empty($cartes)) {
        $cartes = array(
            array(
                'emoji' => '📍',
                'question' => 'Où se trouve le salon ?',
                'reponse' => 'Notre salon est situé à [adresse].'
            ),
            array(
                'emoji' => '👨‍👩‍👧',
                'question' => 'Accueillez-vous enfants ?',
                'reponse' => 'Oui, nous accueillons enfants, femmes et hommes.'
            ),
        );
    }

    // Générer le HTML
    ob_start();
    ?>
    <section class="faq-section faq-<?php echo esc_attr($atts['id']); ?>" style="--faq-couleur-fond: <?php echo esc_attr($couleur_fond); ?>; --faq-couleur-fond-verso: <?php echo esc_attr($couleur_fond_verso); ?>; --faq-arrondi: <?php echo esc_attr($arrondi); ?>px; --faq-titre-couleur: <?php echo esc_attr($titre_couleur); ?>; --faq-titre-taille: <?php echo esc_attr($titre_taille); ?>px; --faq-intro-couleur: <?php echo esc_attr($intro_couleur); ?>; --faq-intro-taille: <?php echo esc_attr($intro_taille); ?>px; --faq-pied-couleur: <?php echo esc_attr($pied_couleur); ?>; --faq-pied-taille: <?php echo esc_attr($pied_taille); ?>px;">
        <h2 class="faq-title"><?php echo esc_html($titre); ?></h2>
        <p class="faq-intro"><?php echo esc_html($intro); ?></p>
        <p class="faq-pied"><?php echo esc_html($pied); ?></p>

        <div class="faq-container" id="flip-faq-container-<?php echo esc_attr($atts['id']); ?>">
            <?php foreach ($cartes as $index => $carte) : ?>
                <div class="flip-card">
                    <div class="flip-inner">
                        <div class="flip-front">
                            <span class="card-emoji"><?php echo esc_html($carte['emoji']); ?></span>
                            <h3 class="card-question"><?php echo esc_html($carte['question']); ?></h3>
                        </div>
                        <div class="flip-back">
                            <p class="card-reponse"><?php echo wp_kses_post($carte['reponse']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <style>
        <?php include __DIR__ . '/faq-carte.css'; ?>
    </style>

    <script>
        <?php include __DIR__ . '/faq-carte.js'; ?>
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('faq_cartes_a_retourner', 'faq_shortcode');

// 3. Sélecteur d'émojis dans l'admin (page de réglages FAQ uniquement)
function faq_acf_emoji_picker_assets() {
    if (empty($_GET['page']) || $_GET['page'] !== 'theme-faq-settings') {
        return;
    }
    ?>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    <style>
        .faq-emoji-picker-btn {
            margin-left: 6px;
            vertical-align: middle;
        }
        .faq-emoji-picker-btn.is-open {
            background: #f0f0f1;
        }
        emoji-picker.faq-emoji-picker {
            position: fixed;
            z-index: 999999;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .2);
        }
    </style>
    <script>
    (function($) {
        function attachEmojiButton($input) {
            if ($input.data('faqEmojiPickerAttached')) {
                return;
            }
            $input.data('faqEmojiPickerAttached', true);
            $input.after('<button type="button" class="faq-emoji-picker-btn button" title="Choisir un émoji">😀</button>');
        }

        function initEmojiFields($context) {
            $context.find('.acf-field[data-name="emoji"] input[type="text"], .acf-field[data-name="faq_pied"] input[type="text"]').each(function() {
                attachEmojiButton($(this));
            });
        }

        $(document).ready(function() {
            initEmojiFields($(document));

            if (window.acf && acf.addAction) {
                acf.addAction('append', function($el) {
                    initEmojiFields($el);
                });
            }

            var $activeInput = null;
            var $picker = null;

            function closePicker() {
                if ($picker) {
                    $picker.remove();
                    $picker = null;
                }
                $('.faq-emoji-picker-btn').removeClass('is-open');
            }

            $(document).on('click', '.faq-emoji-picker-btn', function(e) {
                e.preventDefault();
                var $btn = $(this);
                var wasOpen = $btn.hasClass('is-open');
                closePicker();
                if (wasOpen) {
                    return;
                }

                $activeInput = $btn.prev('input');
                $btn.addClass('is-open');

                $picker = $('<emoji-picker class="faq-emoji-picker"></emoji-picker>');
                $('body').append($picker);

                var rect = $btn[0].getBoundingClientRect();
                $picker.css({ top: rect.bottom + 4, left: rect.left });

                $picker[0].addEventListener('emoji-click', function(evt) {
                    if ($activeInput && $activeInput.length) {
                        $activeInput.val(evt.detail.unicode).trigger('input').trigger('change');
                    }
                    closePicker();
                });
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.faq-emoji-picker, .faq-emoji-picker-btn').length) {
                    closePicker();
                }
            });
        });
    })(jQuery);
    </script>
    <?php
}
add_action('admin_footer', 'faq_acf_emoji_picker_assets');