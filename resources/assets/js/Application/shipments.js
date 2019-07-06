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

    const shipmentsTable = document.querySelector('.shipments-table');
    const assignCourierToggle = document.querySelector('[data-target="#assignCourierModal"]');
    const assignCourierForm = document.querySelector('#assignCourierForm');
    if (shipmentsTable && assignCourierToggle && assignCourierForm) {
        shipmentsTable.addEventListener('change', e => {
            assignCourierForm.querySelectorAll('input[name="shipments[]"]').forEach(elem => elem.parentNode.removeChild(elem))
            let selectedIds = [];
            shipmentsTable.querySelectorAll('tbody .custom-control-input:checked').forEach(item => {
                let newNode = document.createElement('input')
                newNode.name = "shipments[]";
                newNode.type = "hidden";
                newNode.value = item.value;
                selectedIds.push(item.value);
                assignCourierForm.appendChild(newNode)
            })
            assignCourierToggle.disabled = !selectedIds.length;
        })
    }
})();