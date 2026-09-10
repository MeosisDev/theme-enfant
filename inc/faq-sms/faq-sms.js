
(function () {
    var items = <?php echo wp_json_encode(array_map(function ($q) {
        return array(
            'q' => isset($q['question']) ? $q['question'] : '',
            'a' => isset($q['reponse']) ? $q['reponse'] : '',
        );
    }, $questions)); ?>;
    var delaiReponse = <?php echo (int) $delai_reponse; ?>;

    var thread = document.getElementById('faqsms-thread-<?php echo esc_attr($atts['id']); ?>');
    var chipRow = document.getElementById('faqsms-chips-<?php echo esc_attr($atts['id']); ?>');
    var doneMsg = document.getElementById('faqsms-done-<?php echo esc_attr($atts['id']); ?>');
    var ctaBox = document.getElementById('faqsms-cta-<?php echo esc_attr($atts['id']); ?>');
    var asked = [];

    if (!thread || !chipRow) {
        return;
    }

    function addBubble(text, fromUser) {
        var row = document.createElement('div');
        row.className = 'faqsms-bulle-row ' + (fromUser ? 'faqsms-user' : 'faqsms-bot');

        var bubble = document.createElement('div');
        bubble.className = 'faqsms-bulle ' + (fromUser ? 'faqsms-user' : 'faqsms-bot');
        bubble.textContent = text;

        row.appendChild(bubble);
        thread.appendChild(row);
        thread.scrollTop = thread.scrollHeight;

        return row;
    }

    function addTypingIndicator() {
        var row = document.createElement('div');
        row.className = 'faqsms-bulle-row faqsms-bot';

        var bubble = document.createElement('div');
        bubble.className = 'faqsms-bulle faqsms-bot faqsms-typing';
        bubble.innerHTML = '<span class="faqsms-typing-dot"></span><span class="faqsms-typing-dot"></span><span class="faqsms-typing-dot"></span>';

        row.appendChild(bubble);
        thread.appendChild(row);
        thread.scrollTop = thread.scrollHeight;

        return row;
    }

    function renderChips() {
        chipRow.innerHTML = '';
        items.forEach(function (item, idx) {
            if (asked.indexOf(idx) !== -1) return;
            var chip = document.createElement('button');
            chip.type = 'button';
            chip.className = 'faqsms-chip';
            chip.textContent = item.q;

            chip.addEventListener('click', function () {
                addBubble(item.q, true);
                asked.push(idx);
                renderChips();

                var typingRow = addTypingIndicator();

                setTimeout(function () {
                    typingRow.remove();
                    addBubble(item.a, false);
                    if (asked.length === items.length) {
                        if (doneMsg) doneMsg.style.display = 'block';
                        if (ctaBox) ctaBox.style.display = 'block';
                    }
                }, delaiReponse);
            });

            chipRow.appendChild(chip);
        });
    }

    renderChips();
})();
