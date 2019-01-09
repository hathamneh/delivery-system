import axios from 'axios';

(function () {
    let nationalId = document.getElementById('national_id');
    if (nationalId) {
        nationalId.addEventListener('change', e => {
            let val = e.target.value;
            axios.get('/ajax/suggest/guest/' + val).then(res => {
                document.getElementById('clientName').value = res.data.trade_name || "";
                document.getElementById('clientCountry').value = res.data.country || "Jordan";
                document.getElementById('clientCity').value = res.data.city || "Amman";
                document.getElementById('clientPhone').value = res.data.phone_number || "";
            })
        });
    }
})();