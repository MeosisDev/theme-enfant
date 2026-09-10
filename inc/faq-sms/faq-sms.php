<?php
/**
 * FAQ SMS - Conversation interactive avec une assistante virtuelle (Shortcode réutilisable)
 *
 * @package VotreTheme
 */

// Sécurité : Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// 1. Création des champs ACF (local)
function faq_sms_acf_local_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_faq_sms',
        'title' => 'FAQ SMS (conversation)',
        'fields' => array(
            array(
                'key' => 'field_faq_tab_sms',
                'label' => 'FAQ SMS',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_faq_sms_shortcode_info',
                'label' => 'Shortcode à utiliser',
                'name' => 'faq_sms_shortcode_info',
                'type' => 'message',
                'message' => 'Pour afficher la FAQ sur une page, insérez-y le shortcode : <code>[faq_sms]</code>',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),
            array(
                'key' => 'field_faq_sms_assistant_nom',
                'label' => 'Prénom de l\'assistante',
                'name' => 'faq_sms_assistant_nom',
                'type' => 'text',
                'default_value' => 'Malika',
            ),
            array(
                'key' => 'field_faq_sms_assistant_statut',
                'label' => 'Statut affiché sous le nom',
                'name' => 'faq_sms_assistant_statut',
                'type' => 'text',
                'default_value' => 'en ligne au salon',
            ),
            array(
                'key' => 'field_faq_sms_titre',
                'label' => 'Titre principal',
                'name' => 'faq_sms_titre',
                'type' => 'text',
                'default_value' => 'Posez vos questions à Malika',
            ),
            array(
                'key' => 'field_faq_sms_titre_couleur',
                'label' => 'Couleur du titre principal',
                'name' => 'faq_sms_titre_couleur',
                'type' => 'color_picker',
                'default_value' => '#6f9284',
            ),
            array(
                'key' => 'field_faq_sms_intro',
                'label' => 'Texte d\'introduction',
                'name' => 'faq_sms_intro',
                'type' => 'text',
                'default_value' => 'Cliquez sur une question pour voir la réponse arriver dans la conversation',
            ),
            array(
                'key' => 'field_faq_sms_intro_couleur',
                'label' => 'Couleur du texte d\'introduction',
                'name' => 'faq_sms_intro_couleur',
                'type' => 'color_picker',
                'default_value' => '#4a4a4a',
            ),
            array(
                'key' => 'field_faq_sms_questions',
                'label' => 'Questions / Réponses',
                'name' => 'faq_sms_questions',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Ajouter une question',
                'sub_fields' => array(
                    array(
                        'key' => 'field_faq_sms_question',
                        'label' => 'Question',
                        'name' => 'question',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_faq_sms_reponse',
                        'label' => 'Réponse',
                        'name' => 'reponse',
                        'type' => 'textarea',
                    ),
                ),
            ),
            array(
                'key' => 'field_faq_sms_delai_reponse',
                'label' => 'Délai avant la réponse (ms)',
                'name' => 'faq_sms_delai_reponse',
                'type' => 'number',
                'default_value' => 450,
                'min' => 0,
                'max' => 3000,
                'step' => 50,
                'append' => 'ms',
            ),
            array(
                'key' => 'field_faq_sms_message_fin',
                'label' => 'Message affiché une fois toutes les questions posées',
                'name' => 'faq_sms_message_fin',
                'type' => 'text',
                'default_value' => 'Toutes les questions ont été posées 💬 Envie d\'un vrai rendez-vous ?',
            ),
            array(
                'key' => 'field_faq_sms_afficher_cta',
                'label' => 'Afficher le bouton de prise de rendez-vous',
                'name' => 'faq_sms_afficher_cta',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ),
            array(
                'key' => 'field_faq_sms_cta_texte',
                'label' => 'Texte du bouton',
                'name' => 'faq_sms_cta_texte',
                'type' => 'text',
                'default_value' => 'Prendre rendez-vous',
            ),
            array(
                'key' => 'field_faq_sms_cta_lien',
                'label' => 'Lien du bouton',
                'name' => 'faq_sms_cta_lien',
                'type' => 'url',
                'default_value' => 'https://www.linstantcoiffure70.fr/contact.html',
            ),
            array(
                'key' => 'field_faq_sms_couleur_accent',
                'label' => 'Couleur d\'accent (avatar, bulles utilisateur, bouton)',
                'name' => 'faq_sms_couleur_accent',
                'type' => 'color_picker',
                'default_value' => '#6f9284',
            ),
            array(
                'key' => 'field_faq_sms_couleur_fond_section',
                'label' => 'Couleur de fond de la section',
                'name' => 'faq_sms_couleur_fond_section',
                'type' => 'color_picker',
                'default_value' => '#f2e8db',
            ),
            array(
                'key' => 'field_faq_sms_couleur_fond_widget',
                'label' => 'Couleur de fond du widget de conversation',
                'name' => 'faq_sms_couleur_fond_widget',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
            ),
            array(
                'key' => 'field_faq_sms_couleur_fond_bulle',
                'label' => 'Couleur de fond des bulles de réponse',
                'name' => 'faq_sms_couleur_fond_bulle',
                'type' => 'color_picker',
                'default_value' => '#f2e8db',
            ),
            array(
                'key' => 'field_faq_sms_couleur_bordure',
                'label' => 'Couleur des bordures',
                'name' => 'faq_sms_couleur_bordure',
                'type' => 'color_picker',
                'default_value' => '#e3d4e8',
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
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
}
add_action('acf/init', 'faq_sms_acf_local_fields');

// 2. Shortcode générique pour plusieurs conversations FAQ SMS
function faq_sms_shortcode($atts) {
    // Récupérer les attributs du shortcode
    $atts = shortcode_atts(array(
        'id' => 'salon-sms', // Identifiant unique pour le CSS/JS
        'default' => false, // Utiliser les valeurs par défaut si ACF n'est pas configuré
    ), $atts);

    // Vérifier si ACF est disponible
    if (!function_exists('get_field')) {
        return '<p>ACF n\'est pas installé ou activé.</p>';
    }

    // Récupérer les données depuis ACF (page de réglages FAQ)
    $assistant_nom = get_field('faq_sms_assistant_nom', 'option') ?: 'Malika';
    $assistant_statut = get_field('faq_sms_assistant_statut', 'option') ?: 'en ligne au salon';
    $titre = get_field('faq_sms_titre', 'option') ?: 'Posez vos questions à ' . $assistant_nom;
    $titre_couleur = get_field('faq_sms_titre_couleur', 'option') ?: '#6f9284';
    $intro = get_field('faq_sms_intro', 'option') ?: 'Cliquez sur une question pour voir la réponse arriver dans la conversation';
    $intro_couleur = get_field('faq_sms_intro_couleur', 'option') ?: '#4a4a4a';
    $questions = get_field('faq_sms_questions', 'option') ?: array();
    $delai_reponse = get_field('faq_sms_delai_reponse', 'option');
    if ($delai_reponse === '' || $delai_reponse === null || $delai_reponse === false) {
        $delai_reponse = 450;
    }
    $message_fin = get_field('faq_sms_message_fin', 'option') ?: 'Toutes les questions ont été posées 💬 Envie d\'un vrai rendez-vous ?';
    $afficher_cta = get_field('faq_sms_afficher_cta', 'option');
    if ($afficher_cta === '' || $afficher_cta === null) {
        $afficher_cta = true;
    }
    $cta_texte = get_field('faq_sms_cta_texte', 'option') ?: 'Prendre rendez-vous';
    $cta_lien = get_field('faq_sms_cta_lien', 'option') ?: 'https://www.linstantcoiffure70.fr/contact.html';
    $couleur_accent = get_field('faq_sms_couleur_accent', 'option') ?: '#6f9284';
    $couleur_fond_section = get_field('faq_sms_couleur_fond_section', 'option') ?: '#f2e8db';
    $couleur_fond_widget = get_field('faq_sms_couleur_fond_widget', 'option') ?: '#ffffff';
    $couleur_fond_bulle = get_field('faq_sms_couleur_fond_bulle', 'option') ?: '#f2e8db';
    $couleur_bordure = get_field('faq_sms_couleur_bordure', 'option') ?: '#e3d4e8';

    // Valeurs par défaut si ACF n'est pas configuré
    if ($atts['default'] || empty($questions)) {
        $questions = array(
            array(
                'question' => 'Quelle est LA meilleure coupe pour des cheveux fins ?',
                'reponse' => 'Le carré droit, ou blunt cut, reste la valeur sûre : ça concentre la matière au même niveau pour un effet densité maximal.'
            ),
            array(
                'question' => 'Je peux garder mes cheveux longs ?',
                'reponse' => 'Oui, mais il faut entretenir les pointes régulièrement et éviter un dégradé trop marqué, sinon ça fait clairsemé.'
            ),
            array(
                'question' => 'Faut-il éviter le dégradé ?',
                'reponse' => 'Pas complètement : un léger mouvement en pointes seulement, ça apporte du naturel sans retirer de matière.'
            ),
            array(
                'question' => 'La couleur aide vraiment pour le volume ?',
                'reponse' => 'Carrément, un balayage crée un jeu d\'ombre et de lumière qui donne de la profondeur à l\'œil.'
            ),
            array(
                'question' => 'Tous les combien je dois couper ?',
                'reponse' => 'Toutes les 6 à 8 semaines, pour garder une ligne nette et éviter que les pointes s\'affinent.'
            ),
            array(
                'question' => 'On peut faire un diagnostic ensemble ?',
                'reponse' => 'Bien sûr, chaque rendez-vous commence toujours par un diagnostic capillaire pour cibler la coupe adaptée.'
            ),
        );
    }

    $avatar_lettre = mb_strtoupper(mb_substr($assistant_nom, 0, 1));

    // Générer le HTML
    ob_start();
    ?>
    <section class="faqsms-<?php echo esc_attr($atts['id']); ?>" style="--faqsms-titre-couleur: <?php echo esc_attr($titre_couleur); ?>; --faqsms-intro-couleur: <?php echo esc_attr($intro_couleur); ?>; --faqsms-couleur-accent: <?php echo esc_attr($couleur_accent); ?>; --faqsms-couleur-fond-section: <?php echo esc_attr($couleur_fond_section); ?>; --faqsms-couleur-fond-widget: <?php echo esc_attr($couleur_fond_widget); ?>; --faqsms-couleur-fond-bulle: <?php echo esc_attr($couleur_fond_bulle); ?>; --faqsms-couleur-bordure: <?php echo esc_attr($couleur_bordure); ?>;">

        <h2 class="faqsms-title"><?php echo esc_html($titre); ?></h2>
        <p class="faqsms-intro"><?php echo esc_html($intro); ?></p>

        <div id="faqsms-widget-<?php echo esc_attr($atts['id']); ?>" class="faqsms-widget">

            <div class="faqsms-header">
                <div class="faqsms-avatar"><?php echo esc_html($avatar_lettre); ?></div>
                <div>
                    <p class="faqsms-nom"><?php echo esc_html($assistant_nom); ?></p>
                    <p class="faqsms-statut"><span class="faqsms-puce"></span><?php echo esc_html($assistant_statut); ?></p>
                </div>
            </div>

            <div id="faqsms-thread-<?php echo esc_attr($atts['id']); ?>" class="faqsms-thread"></div>

            <div id="faqsms-chips-<?php echo esc_attr($atts['id']); ?>" class="faqsms-chips"></div>

            <p id="faqsms-done-<?php echo esc_attr($atts['id']); ?>" class="faqsms-done" style="display:none;"><?php echo esc_html($message_fin); ?></p>
            <?php if ($afficher_cta) : ?>
                <div id="faqsms-cta-<?php echo esc_attr($atts['id']); ?>" class="faqsms-cta" style="display:none;">
                    <a href="<?php echo esc_url($cta_lien); ?>"><?php echo esc_html($cta_texte); ?></a>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <style>
        <?php include __DIR__ . '/faq-sms.css'; ?>
    </style>

    <script>
        <?php include __DIR__ . '/faq-sms.js'; ?>
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('faq_sms', 'faq_sms_shortcode');
