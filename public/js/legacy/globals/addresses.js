$(document).ready(function () {
    var $addressModal = $("#addressModal");
    $(".edit-address").on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var address_id = $this.data('id');
        var $address_row = $this.closest("tr");
        var address_name = $address_row.find('.address_name').text();
        var address_sameday_p = $address_row.find('.address_sameday_p').text();
        var address_schedule_p = $address_row.find('.address_schedule_p').text();


        $addressModal.find("input[name='address_id']").val(address_id);
        $addressModal.find("input[name='address_name']").val(address_name);
        $addressModal.find("input[name='address_sameday_p']").val(address_sameday_p);
        $addressModal.find("input[name='address_schedule_p']").val(address_schedule_p);

        $addressModal.find("button[name='action']").val("updateAddress");

        $addressModal.modal('show');
    });

    $addressModal.on("hidden.bs.modal", function (e) {
        $addressModal.find("button[name='action']").val("newAddress");
    });
});
