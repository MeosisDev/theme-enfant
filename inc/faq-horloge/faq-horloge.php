<?php
/**
 * FAQ Horloge - Conversation interactive façon cadran d'horloge (Shortcode réutilisable)
 *
 * @package VotreTheme
 */

// Sécurité : Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// 1. Création des champs ACF (local)
function faq_horloge_acf_local_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_faq_horloge',
        'title' => 'FAQ Horloge (cadran)',
        'fields' => array(
            array(
                'key' => 'field_faq_horloge_shortcode_info',
                'label' => 'Shortcode à utiliser',
                'name' => 'faq_horloge_shortcode_info',
                'type' => 'message',
                'message' => 'Pour afficher la FAQ sur une page, insérez-y le shortcode : <code>[faq_horloge]</code>',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),
            array(
                'key' => 'field_faq_horloge_titre',
                'label' => 'Titre principal',
                'name' => 'faq_horloge_titre',
                'type' => 'text',
                'default_value' => 'FAQ — Il est l\'heure de répondre à vos questions',
            ),
            array(
                'key' => 'field_faq_horloge_titre_couleur',
                'label' => 'Couleur du titre principal',
                'name' => 'faq_horloge_titre_couleur',
                'type' => 'color_picker',
                'default_value' => '#6f9284',
            ),
            array(
                'key' => 'field_faq_horloge_intro',
                'label' => 'Texte d\'introduction',
                'name' => 'faq_horloge_intro',
                'type' => 'text',
                'default_value' => 'Cliquez sur une heure du cadran pour lire la réponse',
            ),
            array(
                'key' => 'field_faq_horloge_intro_couleur',
                'label' => 'Couleur du texte d\'introduction',
                'name' => 'faq_horloge_intro_couleur',
                'type' => 'color_picker',
                'default_value' => '#4a4a4a',
            ),
            array(
                'key' => 'field_faq_horloge_questions',
                'label' => 'Questions / Réponses',
                'name' => 'faq_horloge_questions',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Ajouter une question',
                'instructions' => 'Les questions sont réparties automatiquement autour du cadran, quel que soit leur nombre.',
                'sub_fields' => array(
                    array(
                        'key' => 'field_faq_horloge_question',
                        'label' => 'Question',
                        'name' => 'question',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_faq_horloge_reponse',
                        'label' => 'Réponse',
                        'name' => 'reponse',
                        'type' => 'textarea',
                    ),
                ),
            ),
            array(
                'key' => 'field_faq_horloge_couleur_accent',
                'label' => 'Couleur d\'accent (cadran, points, point actif)',
                'name' => 'faq_horloge_couleur_accent',
                'type' => 'color_picker',
                'default_value' => '#6f9284',
            ),
            array(
                'key' => 'field_faq_horloge_couleur_aiguille',
                'label' => 'Couleur de l\'aiguille et des textes forts',
                'name' => 'faq_horloge_couleur_aiguille',
                'type' => 'color_picker',
                'default_value' => '#3f5c50',
            ),
            array(
                'key' => 'field_faq_horloge_couleur_rayure_1',
                'label' => 'Couleur de fond n°1 (rayures + points au repos)',
                'name' => 'faq_horloge_couleur_rayure_1',
                'type' => 'color_picker',
                'default_value' => '#f2e8db',
            ),
            array(
                'key' => 'field_faq_horloge_couleur_rayure_2',
                'label' => 'Couleur de fond n°2 (rayures)',
                'name' => 'faq_horloge_couleur_rayure_2',
                'type' => 'color_picker',
                'default_value' => '#eee0cf',
            ),
            array(
                'key' => 'field_faq_horloge_couleur_cadran_fond',
                'label' => 'Couleur de fond du cadran et de la carte réponse',
                'name' => 'faq_horloge_couleur_cadran_fond',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
            ),
            array(
                'key' => 'field_faq_horloge_couleur_bordure',
                'label' => 'Couleur des bordures (cercle intérieur, carte réponse)',
                'name' => 'faq_horloge_couleur_bordure',
                'type' => 'color_picker',
                'default_value' => '#e3d4e8',
            ),
            array(
                'key' => 'field_faq_horloge_couleur_texte_reponse',
                'label' => 'Couleur du texte de la réponse',
                'name' => 'faq_horloge_couleur_texte_reponse',
                'type' => 'color_picker',
                'default_value' => '#4a4a4a',
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
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
}
add_action('acf/init', 'faq_horloge_acf_local_fields');

// 2. Shortcode générique pour plusieurs horloges FAQ
function faq_horloge_shortcode($atts) {
    // Récupérer les attributs du shortcode
    $atts = shortcode_atts(array(
        'id' => 'salon-horloge', // Identifiant unique pour le CSS/JS
        'default' => false, // Utiliser les valeurs par défaut si ACF n'est pas configuré
    ), $atts);

    // Vérifier si ACF est disponible
    if (!function_exists('get_field')) {
        return '<p>ACF n\'est pas installé ou activé.</p>';
    }

    // Récupérer les données depuis ACF (page de réglages FAQ)
    $titre = get_field('faq_horloge_titre', 'option') ?: 'FAQ — Il est l\'heure de répondre à vos questions';
    $titre_couleur = get_field('faq_horloge_titre_couleur', 'option') ?: '#6f9284';
    $intro = get_field('faq_horloge_intro', 'option') ?: 'Cliquez sur une heure du cadran pour lire la réponse';
    $intro_couleur = get_field('faq_horloge_intro_couleur', 'option') ?: '#4a4a4a';
    $questions = get_field('faq_horloge_questions', 'option') ?: array();
    $couleur_accent = get_field('faq_horloge_couleur_accent', 'option') ?: '#6f9284';
    $couleur_aiguille = get_field('faq_horloge_couleur_aiguille', 'option') ?: '#3f5c50';
    $couleur_rayure_1 = get_field('faq_horloge_couleur_rayure_1', 'option') ?: '#f2e8db';
    $couleur_rayure_2 = get_field('faq_horloge_couleur_rayure_2', 'option') ?: '#eee0cf';
    $couleur_cadran_fond = get_field('faq_horloge_couleur_cadran_fond', 'option') ?: '#ffffff';
    $couleur_bordure = get_field('faq_horloge_couleur_bordure', 'option') ?: '#e3d4e8';
    $couleur_texte_reponse = get_field('faq_horloge_couleur_texte_reponse', 'option') ?: '#4a4a4a';

    // Valeurs par défaut si ACF n'est pas configuré
    if ($atts['default'] || empty($questions)) {
        $questions = array(
            array(
                'question' => 'Comment prendre rendez-vous dans mon salon de coiffure à Vesoul ?',
                'reponse' => 'Vous pouvez réserver directement en ligne via le bouton "Prendre RDV", par téléphone ou en passant au salon. Je vous confirme votre créneau rapidement.'
            ),
            array(
                'question' => 'Proposez-vous des coupes pour hommes, femmes et enfants ?',
                'reponse' => 'Oui, mon salon accueille toute la famille : coupes homme, femme et enfant, avec des prestations adaptées à chacun.'
            ),
            array(
                'question' => 'Quels produits utilisez-vous pour les colorations et soins ?',
                'reponse' => 'J\'utilise exclusivement des produits professionnels, sélectionnés pour respecter la santé de vos cheveux tout en garantissant des résultats durables.'
            ),
            array(
                'question' => 'Faut-il un rendez-vous ou puis-je passer directement au salon ?',
                'reponse' => 'Le rendez-vous est fortement recommandé pour vous garantir un créneau adapté à vos disponibilités et un accompagnement personnalisé, sans attente.'
            ),
            array(
                'question' => 'Où se situe le salon et où puis-je me garer ?',
                'reponse' => 'Le salon L\'Instant Coiffure se situe à Vesoul, facilement accessible avec des possibilités de stationnement à proximité immédiate.'
            ),
            array(
                'question' => 'Proposez-vous des balayages et mèches personnalisés ?',
                'reponse' => 'Oui, chaque balayage ou jeu de mèches est étudié selon votre couleur naturelle, votre style et vos envies, pour un résultat sur-mesure.'
            ),
        );
    }

    // Générer le HTML
    ob_start();
    ?>
    <section class="faqhorloge-<?php echo esc_attr($atts['id']); ?>" style="--faqhorloge-titre-couleur: <?php echo esc_attr($titre_couleur); ?>; --faqhorloge-intro-couleur: <?php echo esc_attr($intro_couleur); ?>; --faqhorloge-couleur-accent: <?php echo esc_attr($couleur_accent); ?>; --faqhorloge-couleur-aiguille: <?php echo esc_attr($couleur_aiguille); ?>; --faqhorloge-couleur-rayure-1: <?php echo esc_attr($couleur_rayure_1); ?>; --faqhorloge-couleur-rayure-2: <?php echo esc_attr($couleur_rayure_2); ?>; --faqhorloge-couleur-cadran-fond: <?php echo esc_attr($couleur_cadran_fond); ?>; --faqhorloge-couleur-bordure: <?php echo esc_attr($couleur_bordure); ?>; --faqhorloge-couleur-texte-reponse: <?php echo esc_attr($couleur_texte_reponse); ?>;">

        <h2 class="faqhorloge-title"><?php echo esc_html($titre); ?></h2>
        <p class="faqhorloge-intro"><?php echo esc_html($intro); ?></p>

        <div class="faqhorloge-wrap">

            <div class="faqhorloge-cadran-wrap">
                <svg viewBox="0 0 320 320" class="faqhorloge-svg">
                    <circle cx="160" cy="160" r="150" fill="var(--faqhorloge-couleur-cadran-fond)" stroke="var(--faqhorloge-couleur-accent)" stroke-width="6"></circle>
                    <circle cx="160" cy="160" r="132" fill="none" stroke="var(--faqhorloge-couleur-bordure)" stroke-width="1"></circle>
                    <line id="faqhorloge-hand-<?php echo esc_attr($atts['id']); ?>" class="faqhorloge-hand" x1="160" y1="160" x2="160" y2="60" stroke="var(--faqhorloge-couleur-aiguille)" stroke-width="5" stroke-linecap="round"></line>
                    <circle cx="160" cy="160" r="8" fill="var(--faqhorloge-couleur-aiguille)"></circle>
                </svg>
                <div id="faqhorloge-labels-<?php echo esc_attr($atts['id']); ?>" class="faqhorloge-labels"></div>
            </div>

            <div id="faqhorloge-panel-<?php echo esc_attr($atts['id']); ?>" class="faqhorloge-panel">
                <h3 id="faqhorloge-q-<?php echo esc_attr($atts['id']); ?>" class="faqhorloge-q"></h3>
                <p id="faqhorloge-a-<?php echo esc_attr($atts['id']); ?>" class="faqhorloge-a"></p>
            </div>

        </div>
    </section>

    <style>
        <?php include __DIR__ . '/faq-horloge.css'; ?>
    </style>

    <script>
        <?php include __DIR__ . '/faq-horloge.js'; ?>
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('faq_horloge', 'faq_horloge_shortcode');
