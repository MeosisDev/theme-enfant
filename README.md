# Mode factu

Thème enfant WordPress basé sur **Hello Elementor**, développé par [Meosis](https://www.meosis.fr/).

## Prérequis

- WordPress avec le thème parent **Hello Elementor**
- Elementor
- [Advanced Custom Fields (ACF)](https://www.advancedcustomfields.com/) — requis pour le module FAQ

## Structure du projet

```
├── functions.php          # Point d'entrée : shortcodes globaux et includes
├── style.css               # En-tête du thème enfant (nom, version, template parent)
├── meo-config/              # Fonctions communes Meosis (NE PAS SUPPRIMER)
│   ├── meo-functions.php    # Enqueue des styles/scripts, pages enfants, ACF...
│   └── meo-avis.php          # Gestion des avis clients
├── inc/
│   ├── faq-carte/            # Module FAQ à cartes retournables
│   │   ├── faq-carte.php     # Champs ACF + shortcode [faq_cartes_a_retourner]
│   │   ├── faq-carte.css
│   │   └── faq-carte.js
│   ├── faq-sms/              # Module FAQ en conversation façon SMS
│   │   ├── faq-sms.php       # Champs ACF + shortcode [faq_sms]
│   │   ├── faq-sms.css
│   │   └── faq-sms.js
│   ├── faq-horloge/          # Module FAQ façon cadran d'horloge
│   │   ├── faq-horloge.php   # Champs ACF + shortcode [faq_horloge]
│   │   ├── faq-horloge.css
│   │   └── faq-horloge.js
│   └── faq-admin-tabs.php    # Onglets natifs WP sur la page Informations > FAQ
├── diapo/                   # Module diaporama / galerie
│   ├── diapo.php
│   ├── gallery.php
│   ├── css/
│   └── js/
├── scripts/
│   ├── main.js               # Script principal du thème
│   └── gsap/                  # Librairie d'animation GSAP
└── styles/
    ├── global.css
    ├── form.css
    ├── custom.css
    └── faq.css
```

## Fonctionnalités

- **Widget Elfsight** via le shortcode `[elfsight_shortcode]`
- **FAQ à cartes retournables** via le shortcode `[faq_cartes_a_retourner]` (champs configurables dans ACF)
- **FAQ en conversation façon SMS** via le shortcode `[faq_sms]` (questions/réponses, couleurs et bouton de RDV configurables dans ACF)
- **FAQ façon cadran d'horloge** via le shortcode `[faq_horloge]` (questions réparties automatiquement autour du cadran, couleurs configurables dans ACF)
- **Diaporama / galerie** (`diapo/`)
- Enqueue automatique des styles et scripts du thème (jQuery, Slick, GSAP, Lenis...)

## Installation

1. Copier le dossier du thème dans `wp-content/themes/`
2. Activer le thème parent **Hello Elementor**, puis activer ce thème enfant depuis l'administration WordPress
3. Installer et activer le plugin **ACF**
