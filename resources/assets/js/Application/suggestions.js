import axios from 'axios';

axios.defaults.headers.common['X-CSRF-TOKEN'] = window.csrf_token;
const url = "/api/suggest/status/";

(function () {
    let suggestionsTriggers = document.querySelectorAll('[data-status-suggest]');
    let suggestionsList = document.querySelector('.suggestions');
    suggestionsTriggers.forEach(trigger => {
        trigger.addEventListener('change', function (e) {
            let value = this.value;
            suggestionsList.innerHTML = "";
            axios.get(url + value).then((res) => {
                let items = [];
                if (res.data.suggestions && res.data.suggestions.length) {
                    res.data.suggestions.forEach(sugg => {
                        let item = document.createElement('button');
                        item.classList.add('suggestions-item');
                        item.textContent = sugg;
                        items.push(item.outerHTML);
                    });
                }
                suggestionsList.innerHTML = items.join(',');
                suggestionsList.style.display = 'block';
            });
        });
    })
    if (suggestionsList)
        suggestionsList.addEventListener('click', e => {
            e.preventDefault();
            if (!e.target.matches(".suggestions-item")) return;
            let target = document.querySelector('[data-target-for="' + suggestionsList.id + '"]');
            if (target) {
                target.value = e.target.textContent;
                target.focus();
            }
        })

})();