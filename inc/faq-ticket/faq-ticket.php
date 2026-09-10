<?php
/**
 * FAQ Ticket - Accordéon façon fiches de comptoir (Shortcode réutilisable)
 *
 * @package VotreTheme
 */

// Sécurité : Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// 1. Création des champs ACF (local)
function faq_ticket_acf_local_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_faq_ticket',
        'title' => 'FAQ Ticket (fiches)',
        'fields' => array(
            array(
                'key' => 'field_faq_ticket_shortcode_info',
                'label' => 'Shortcode à utiliser',
                'name' => 'faq_ticket_shortcode_info',
                'type' => 'message',
                'message' => 'Pour afficher la FAQ sur une page, insérez-y le shortcode : <code>[faq_ticket]</code>. Un balisage SEO FAQPage (JSON-LD) est généré automatiquement à partir des questions/réponses ci-dessous.',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),
            array(
                'key' => 'field_faq_ticket_eyebrow',
                'label' => 'Petit texte au-dessus du titre',
                'name' => 'faq_ticket_eyebrow',
                'type' => 'text',
                'default_value' => 'Questions fréquentes',
            ),
            array(
                'key' => 'field_faq_ticket_eyebrow_couleur',
                'label' => 'Couleur du petit texte',
                'name' => 'faq_ticket_eyebrow_couleur',
                'type' => 'color_picker',
                'default_value' => '#802E35',
            ),
            array(
                'key' => 'field_faq_ticket_titre',
                'label' => 'Titre principal',
                'name' => 'faq_ticket_titre',
                'type' => 'text',
                'default_value' => 'Toutes vos questions sur le traiteur à Strasbourg et Mundolsheim,',
            ),
            array(
                'key' => 'field_faq_ticket_titre_couleur',
                'label' => 'Couleur du titre principal',
                'name' => 'faq_ticket_titre_couleur',
                'type' => 'color_picker',
                'default_value' => '#363636',
            ),
            array(
                'key' => 'field_faq_ticket_titre_accent',
                'label' => 'Fin du titre mise en valeur (italique)',
                'name' => 'faq_ticket_titre_accent',
                'type' => 'text',
                'instructions' => 'Laisser vide pour ne rien afficher après le titre principal.',
                'default_value' => 'comme au comptoir',
            ),
            array(
                'key' => 'field_faq_ticket_titre_accent_couleur',
                'label' => 'Couleur du texte mis en valeur',
                'name' => 'faq_ticket_titre_accent_couleur',
                'type' => 'color_picker',
                'default_value' => '#802E35',
            ),
            array(
                'key' => 'field_faq_ticket_intro',
                'label' => 'Texte d\'introduction',
                'name' => 'faq_ticket_intro',
                'type' => 'text',
                'default_value' => 'Comme au comptoir : cliquez sur une fiche pour la déplier.',
            ),
            array(
                'key' => 'field_faq_ticket_intro_couleur',
                'label' => 'Couleur du texte d\'introduction',
                'name' => 'faq_ticket_intro_couleur',
                'type' => 'color_picker',
                'default_value' => '#5a5a5a',
            ),
            array(
                'key' => 'field_faq_ticket_questions',
                'label' => 'Fiches Questions / Réponses',
                'name' => 'faq_ticket_questions',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Ajouter une fiche',
                'sub_fields' => array(
                    array(
                        'key' => 'field_faq_ticket_tag',
                        'label' => 'Étiquette',
                        'name' => 'tag',
                        'type' => 'text',
                        'instructions' => 'Court texte affiché sur le ruban, ex : DÉLAI',
                    ),
                    array(
                        'key' => 'field_faq_ticket_emoji',
                        'label' => 'Émoji',
                        'name' => 'emoji',
                        'type' => 'text',
                        'default_value' => '❓',
                    ),
                    array(
                        'key' => 'field_faq_ticket_question',
                        'label' => 'Question',
                        'name' => 'question',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_faq_ticket_reponse',
                        'label' => 'Réponse',
                        'name' => 'reponse',
                        'type' => 'textarea',
                    ),
                ),
            ),
            array(
                'key' => 'field_faq_ticket_couleur_fond_section',
                'label' => 'Couleur de fond de la section',
                'name' => 'faq_ticket_couleur_fond_section',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
            ),
            array(
                'key' => 'field_faq_ticket_couleur_fond_carte',
                'label' => 'Couleur de fond des fiches',
                'name' => 'faq_ticket_couleur_fond_carte',
                'type' => 'color_picker',
                'default_value' => '#fffaf3',
            ),
            array(
                'key' => 'field_faq_ticket_couleur_bordure_carte',
                'label' => 'Couleur de bordure des fiches',
                'name' => 'faq_ticket_couleur_bordure_carte',
                'type' => 'color_picker',
                'default_value' => '#e7dccb',
            ),
            array(
                'key' => 'field_faq_ticket_couleur_ruban_fond',
                'label' => 'Couleur de fond du ruban (étiquette)',
                'name' => 'faq_ticket_couleur_ruban_fond',
                'type' => 'color_picker',
                'default_value' => '#881F28',
            ),
            array(
                'key' => 'field_faq_ticket_couleur_ruban_texte',
                'label' => 'Couleur du texte du ruban',
                'name' => 'faq_ticket_couleur_ruban_texte',
                'type' => 'color_picker',
                'default_value' => '#ffffff',
            ),
            array(
                'key' => 'field_faq_ticket_couleur_question',
                'label' => 'Couleur du texte des questions',
                'name' => 'faq_ticket_couleur_question',
                'type' => 'color_picker',
                'default_value' => '#363636',
            ),
            array(
                'key' => 'field_faq_ticket_couleur_icone_plus',
                'label' => 'Couleur de l\'icône +',
                'name' => 'faq_ticket_couleur_icone_plus',
                'type' => 'color_picker',
                'default_value' => '#881F28',
            ),
            array(
                'key' => 'field_faq_ticket_couleur_reponse',
                'label' => 'Couleur du texte des réponses',
                'name' => 'faq_ticket_couleur_reponse',
                'type' => 'color_picker',
                'default_value' => '#5a5a5a',
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
        'menu_order' => 3,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
}
add_action('acf/init', 'faq_ticket_acf_local_fields');

// 2. Shortcode générique pour plusieurs FAQ Ticket
function faq_ticket_shortcode($atts) {
    // Récupérer les attributs du shortcode
    $atts = shortcode_atts(array(
        'id' => 'salon-ticket', // Identifiant unique pour le CSS/JS
        'default' => false, // Utiliser les valeurs par défaut si ACF n'est pas configuré
    ), $atts);

    // Vérifier si ACF est disponible
    if (!function_exists('get_field')) {
        return '<p>ACF n\'est pas installé ou activé.</p>';
    }

    // Récupérer les données depuis ACF (page de réglages FAQ)
    $eyebrow = get_field('faq_ticket_eyebrow', 'option') ?: 'Questions fréquentes';
    $eyebrow_couleur = get_field('faq_ticket_eyebrow_couleur', 'option') ?: '#802E35';
    $titre = get_field('faq_ticket_titre', 'option') ?: 'Toutes vos questions,';
    $titre_couleur = get_field('faq_ticket_titre_couleur', 'option') ?: '#363636';
    $titre_accent = get_field('faq_ticket_titre_accent', 'option');
    $titre_accent_couleur = get_field('faq_ticket_titre_accent_couleur', 'option') ?: '#802E35';
    $intro = get_field('faq_ticket_intro', 'option') ?: 'Cliquez sur une fiche pour la déplier.';
    $intro_couleur = get_field('faq_ticket_intro_couleur', 'option') ?: '#5a5a5a';
    $questions = get_field('faq_ticket_questions', 'option') ?: array();
    $couleur_fond_section = get_field('faq_ticket_couleur_fond_section', 'option') ?: '#ffffff';
    $couleur_fond_carte = get_field('faq_ticket_couleur_fond_carte', 'option') ?: '#fffaf3';
    $couleur_bordure_carte = get_field('faq_ticket_couleur_bordure_carte', 'option') ?: '#e7dccb';
    $couleur_ruban_fond = get_field('faq_ticket_couleur_ruban_fond', 'option') ?: '#881F28';
    $couleur_ruban_texte = get_field('faq_ticket_couleur_ruban_texte', 'option') ?: '#ffffff';
    $couleur_question = get_field('faq_ticket_couleur_question', 'option') ?: '#363636';
    $couleur_icone_plus = get_field('faq_ticket_couleur_icone_plus', 'option') ?: '#881F28';
    $couleur_reponse = get_field('faq_ticket_couleur_reponse', 'option') ?: '#5a5a5a';

    // Valeurs par défaut si ACF n'est pas configuré
    if ($atts['default'] || empty($questions)) {
        $questions = array(
            array(
                'tag' => 'DÉLAI',
                'emoji' => '⏱️',
                'question' => 'Combien de temps à l\'avance faut-il commander ?',
                'reponse' => 'Quelques jours suffisent pour un plat du jour ou un petit plateau. Comptez 1 à 2 semaines pour un événement plus important, surtout en période de fêtes.'
            ),
            array(
                'tag' => 'CONVIVES',
                'emoji' => '👥',
                'question' => 'Y a-t-il un nombre minimum ou maximum d\'invités ?',
                'reponse' => 'Non, nous nous adaptons aussi bien à un repas pour 4 personnes qu\'à une réception pour plusieurs dizaines d\'invités.'
            ),
            array(
                'tag' => 'RETRAIT',
                'emoji' => '🚚',
                'question' => 'Retrait en boutique ou livraison ?',
                'reponse' => 'Les deux sont possibles : retrait à Strasbourg ou Mundolsheim, ou livraison dans les quartiers desservis par chaque boutique.'
            ),
            array(
                'tag' => 'SUR MESURE',
                'emoji' => '🍽️',
                'question' => 'Peut-on composer son propre plateau ?',
                'reponse' => 'Oui, selon vos envies et votre budget. Donnez-nous le nombre de convives et l\'occasion, nous vous proposons une sélection à ajuster ensemble.'
            ),
            array(
                'tag' => 'ANNULATION',
                'emoji' => '↩️',
                'question' => 'Peut-on annuler ou modifier une commande ?',
                'reponse' => 'Oui, vous pouvez annuler ou modifier votre commande, pour cela veuillez à respecter les délais. Vous êtes invités à nous appeler pour toute annulation ou modification.'
            ),
        );
    }

    // Balisage SEO FAQPage (JSON-LD), généré depuis les mêmes questions/réponses
    $jsonld = array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(function ($item) {
            return array(
                '@type' => 'Question',
                'name' => isset($item['question']) ? $item['question'] : '',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => isset($item['reponse']) ? $item['reponse'] : '',
                ),
            );
        }, $questions),
    );

    // Générer le HTML
    ob_start();
    ?>
    <section class="faqticket-<?php echo esc_attr($atts['id']); ?>" style="--faqticket-couleur-fond-section: <?php echo esc_attr($couleur_fond_section); ?>; --faqticket-couleur-eyebrow: <?php echo esc_attr($eyebrow_couleur); ?>; --faqticket-couleur-titre: <?php echo esc_attr($titre_couleur); ?>; --faqticket-couleur-titre-accent: <?php echo esc_attr($titre_accent_couleur); ?>; --faqticket-couleur-intro: <?php echo esc_attr($intro_couleur); ?>; --faqticket-couleur-fond-carte: <?php echo esc_attr($couleur_fond_carte); ?>; --faqticket-couleur-bordure-carte: <?php echo esc_attr($couleur_bordure_carte); ?>; --faqticket-couleur-ruban-fond: <?php echo esc_attr($couleur_ruban_fond); ?>; --faqticket-couleur-ruban-texte: <?php echo esc_attr($couleur_ruban_texte); ?>; --faqticket-couleur-question: <?php echo esc_attr($couleur_question); ?>; --faqticket-couleur-icone-plus: <?php echo esc_attr($couleur_icone_plus); ?>; --faqticket-couleur-reponse: <?php echo esc_attr($couleur_reponse); ?>;">

        <div class="faqticket-header">
            <p class="faqticket-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <h2 class="faqticket-titre">
                <?php echo esc_html($titre); ?>
                <?php if (!empty($titre_accent)) : ?> <em><?php echo esc_html($titre_accent); ?></em><?php endif; ?>
            </h2>
            <p class="faqticket-intro"><?php echo esc_html($intro); ?></p>
        </div>

        <div id="faqticket-cards-<?php echo esc_attr($atts['id']); ?>" class="faqticket-cards"></div>
    </section>

    <script type="application/ld+json"><?php echo wp_json_encode($jsonld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>

    <style>
        <?php include __DIR__ . '/faq-ticket.css'; ?>
    </style>

    <script>
        <?php include __DIR__ . '/faq-ticket.js'; ?>
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('faq_ticket', 'faq_ticket_shortcode');
