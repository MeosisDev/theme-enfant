
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('flip-faq-container-<?php echo esc_attr($atts['id']); ?>');
        if (container) {
            container.querySelectorAll('.flip-card').forEach(function(card) {
                card.addEventListener('click', function() {
                    this.classList.toggle('flipped');
                });
            });
        }
    });
    