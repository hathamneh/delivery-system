import mixitup from 'mixitup';

(function ($) {
    var containerEl = document.querySelector('.pickups-list');
    if (containerEl)
        mixitup(containerEl,
            {
                selectors: {
                    control: '[data-mixitup-control]'
                },
                animation: {
                    clampHeight: false
                }
            });

    $(document).ready(function () {
        $(".pickup-item").each(function () {
            $(this).css({
                "max-height": $(this).innerHeight()
            });
        });
        $(".pickup-toggle-details").on('click', function () {
            var $this = $(this);
            var $parent = $this.closest('.pickup-item');
            var expanded = $this.attr("aria-expanded") !== "true";
            if (expanded) {
                $('body').addClass('lock-screen');
                $parent.addClass('item-expanded');
            } else {
                setTimeout(function () {
                    $parent.removeClass('item-expanded');
                    $('body').removeClass('lock-screen');
                }, 350)
            }
        });
        $(document).on('click', 'body.lock-screen', function (e) {
            e.stopPropagation();
            if ($(e.target).closest('.item-expanded').length === 0) {
                var $expanded = $('.item-expanded');
                $expanded.find(".pickup-meta.collapse").collapse('hide')
                setTimeout(function () {
                    $expanded.removeClass('item-expanded');
                    $('body').removeClass('lock-screen');
                }, 350)
            }
        });
    });

    let pickupForm = document.querySelector('.pickup-form');
    if (pickupForm) {
        $(pickupForm.querySelector("#client_account_number")).on('select2:select', e => {
            let client = e.params.data;
            pickupForm.querySelector('#client_name').value = client.trade_name;
            pickupForm.querySelector('#phone_number').value = client.phone_number;
            pickupForm.querySelector('#pickup_address_text').value = client.address_pickup_text;
            pickupForm.querySelector('#pickup_address_maps').value = client.address_pickup_maps;
        });
    }

    let pills = document.querySelector('.pickup-pills');
    if (pills) {
        pills.querySelectorAll('.nav-link').forEach(item => {
            let filter = item.dataset.filter;
            let count = 0;
            if (filter === "all")
                count = document.querySelectorAll('.pickups-list .pickup-item').length;
            else
                count = document.querySelector('.pickups-list').querySelectorAll(filter).length;
            item.querySelector('.badge').textContent = count;
        });
    }

    let isGuestRadios = document.getElementsByName('is_guest');
    let guestInputs = ['guest_name', 'client_national_id', 'guest_country', 'guest_city', 'prepaid_cash'];
    isGuestRadios.forEach(radio => {
        radio.addEventListener('change', e => {
            if (e.target.value === "1") {
                guestInputs.forEach(id => {
                    let item = document.getElementById(id);
                    item.disabled = false;
                    if (id === 'prepaid_cash')
                        item.closest('.form-group').style.display = 'block';
                    else
                        item.closest('.form-group').style.display = 'flex';
                });
                let clientAccNum = document.getElementById('client_account_number');
                clientAccNum.disabled = true;
                clientAccNum.nextSibling.style.display = 'none';
            } else {
                guestInputs.forEach(id => {
                    let item = document.getElementById(id);
                    item.disabled = true;
                    item.closest('.form-group').style.display = 'none';
                });
                let clientAccNum = document.getElementById('client_account_number');
                clientAccNum.disabled = false;
                clientAccNum.nextSibling.style.display = 'block';
            }
        })
    });

    let nationalId = document.getElementById('client_national_id');
    if (nationalId) {
        nationalId.addEventListener('change', e => {
            let val = e.target.value;
            axios.get('/api/suggest/guest/' + val).then(res => {
                document.getElementById('guest_name').value = res.data.trade_name;
                document.getElementById('client_name').value = res.data.trade_name;
                document.getElementById('guest_country').value = res.data.country;
                document.getElementById('guest_city').value = res.data.city;
                document.getElementById('phone_number').value = res.data.phone_number;
            })
        });
    }
})(jQuery);