
(function () {
    var items = <?php echo wp_json_encode(array_map(function ($q) {
        return array(
            'tag' => isset($q['tag']) ? $q['tag'] : '',
            'icon' => isset($q['emoji']) ? $q['emoji'] : '',
            'q' => isset($q['question']) ? $q['question'] : '',
            'a' => isset($q['reponse']) ? $q['reponse'] : '',
        );
    }, $questions)); ?>;

    var container = document.getElementById('faqticket-cards-<?php echo esc_attr($atts['id']); ?>');

    if (!container) {
        return;
    }

    items.forEach(function (item) {
        var card = document.createElement('div');
        card.className = 'faqticket-card';

        var tag = document.createElement('div');
        tag.className = 'faqticket-tag';
        tag.textContent = item.tag;

        var row = document.createElement('div');
        row.className = 'faqticket-row';

        var icon = document.createElement('span');
        icon.className = 'faqticket-icon';
        icon.textContent = item.icon;

        var question = document.createElement('h3');
        question.className = 'faqticket-question';
        question.textContent = item.q;

        var plus = document.createElement('span');
        plus.className = 'faqticket-plus';
        plus.textContent = '＋';

        row.appendChild(icon);
        row.appendChild(question);
        row.appendChild(plus);

        var answer = document.createElement('div');
        answer.className = 'faqticket-answer';
        var answerText = document.createElement('p');
        answerText.textContent = item.a;
        answer.appendChild(answerText);

        card.appendChild(tag);
        card.appendChild(row);
        card.appendChild(answer);

        card.addEventListener('click', function () {
            var answer = card.querySelector('.faqticket-answer');
            var isOpen = card.classList.contains('is-open');

            answer.style.maxHeight = isOpen ? '0px' : answer.scrollHeight + 'px';
            card.classList.toggle('is-open', !isOpen);
        });

        container.appendChild(card);
    });
})();
