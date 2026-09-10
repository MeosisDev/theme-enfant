
(function () {
    var items = <?php echo wp_json_encode(array_map(function ($q) {
        return array(
            'q' => isset($q['question']) ? $q['question'] : '',
            'a' => isset($q['reponse']) ? $q['reponse'] : '',
        );
    }, $questions)); ?>;

    var labelsWrap = document.getElementById('faqhorloge-labels-<?php echo esc_attr($atts['id']); ?>');
    var hand = document.getElementById('faqhorloge-hand-<?php echo esc_attr($atts['id']); ?>');
    var panel = document.getElementById('faqhorloge-panel-<?php echo esc_attr($atts['id']); ?>');
    var qEl = document.getElementById('faqhorloge-q-<?php echo esc_attr($atts['id']); ?>');
    var aEl = document.getElementById('faqhorloge-a-<?php echo esc_attr($atts['id']); ?>');

    if (!labelsWrap || !hand || !panel) {
        return;
    }

    var radius = 150;
    var center = 160;

    items.forEach(function (item, idx) {
        var angleDeg = (idx / items.length) * 360;
        var angleRad = (angleDeg - 90) * Math.PI / 180;
        var x = center + radius * Math.cos(angleRad);
        var y = center + radius * Math.sin(angleRad);

        var dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'faqhorloge-dot';
        dot.style.left = x + 'px';
        dot.style.top = y + 'px';
        dot.setAttribute('aria-label', item.q);
        dot.textContent = (idx + 1);

        dot.addEventListener('click', function () {
            labelsWrap.querySelectorAll('.faqhorloge-dot').forEach(function (b) {
                b.classList.remove('is-active');
            });
            dot.classList.add('is-active');

            hand.style.transform = 'rotate(' + angleDeg + 'deg)';
            qEl.textContent = item.q;
            aEl.textContent = item.a;
            panel.classList.add('is-visible');
        });

        labelsWrap.appendChild(dot);
    });
})();
