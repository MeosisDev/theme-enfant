<?php
/**
 * Onglets d'administration pour la page "Informations > FAQ"
 *
 * ACF affiche chaque groupe de champs (FAQ cartes à retourner, FAQ SMS, ...)
 * comme une boîte séparée les unes sous les autres. Ce fichier ajoute une
 * barre d'onglets WordPress native au-dessus de ces boîtes pour n'en
 * afficher qu'une seule à la fois et raccourcir la page.
 *
 * @package VotreTheme
 */

// Sécurité : Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

function faq_admin_tabs_assets() {
    if (empty($_GET['page']) || $_GET['page'] !== 'theme-faq-settings') {
        return;
    }
    ?>
    <style>
        .faq-admin-tabs-wrapper { margin: 20px 0 0; }
        .acf-postbox.faq-admin-tab-hidden { display: none; }
    </style>
    <script>
    (function ($) {
        $(function () {
            var $boxes = $('#poststuff .postbox').filter(function () {
                return /^acf-group_/.test(this.id);
            });

            if ($boxes.length < 2) {
                return;
            }

            var storageKey = 'faq_admin_active_tab';
            var savedId = window.localStorage.getItem(storageKey);
            var activeIndex = 0;

            $boxes.each(function (index) {
                if (this.id === savedId) {
                    activeIndex = index;
                }
            });

            var $tabs = $('<h2 class="nav-tab-wrapper faq-admin-tabs-wrapper"></h2>');

            $boxes.each(function (index) {
                var $box = $(this).addClass('acf-postbox');
                var label = $box.find('.hndle span, .hndle').first().text().trim();
                var boxId = this.id;

                var $tab = $('<a href="#" class="nav-tab"></a>').text(label);
                if (index === activeIndex) {
                    $tab.addClass('nav-tab-active');
                } else {
                    $box.addClass('faq-admin-tab-hidden');
                }

                $tab.on('click', function (e) {
                    e.preventDefault();
                    $tabs.find('.nav-tab').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active');
                    $boxes.addClass('faq-admin-tab-hidden');
                    $box.removeClass('faq-admin-tab-hidden');
                    window.localStorage.setItem(storageKey, boxId);
                });

                $tabs.append($tab);
            });

            $boxes.first().before($tabs);
        });
    })(jQuery);
    </script>
    <?php
}
add_action('admin_footer', 'faq_admin_tabs_assets');
