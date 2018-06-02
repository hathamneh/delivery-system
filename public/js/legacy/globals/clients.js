$(document).ready(function () {
    $("#clientIdInput").blur(function () {
        var val = $(this).val();
        var $this = $(this);
        var error = $("#client_id_error");
        var $client_name = $("#ClientName");
        var $client_phone_number = $("#client_phone_number");
        var $address_pickup_text = $("#address_pickup_text");
        var $address_pickup_maps = $("#address_pickup_maps");
        var $client_name_with_zone = $("#ClientNameWithZone");
        if (val.trim() !== "")
            $.ajax({
                type: "POST",
                url: "/ajax_requests.php",
                data: {
                    action: "retrieve_client_info",
                    account_number: val
                },
                success: function (data) {
                    console.log(data);
                    if (data === "error") {
                        error.show();
                        $this.addClass(".error");

                        if ($client_name.length)
                            $client_name.val("");
                        if ($client_name_with_zone.length)
                            $client_name_with_zone.val("");
                        if ($client_phone_number.length)
                            $client_phone_number.val("");
                        if ($address_pickup_text.length)
                            $address_pickup_text.val("");
                        if ($address_pickup_maps.length)
                            $address_pickup_maps.val("");
                        return;
                    }
                    error.hide();
                    $this.removeClass(".error");
                    var json = JSON.parse(data);

                    if ($client_name.length)
                        $client_name.val(json.trade_name);
                    if ($client_name_with_zone.length)
                        $client_name_with_zone.val(json.trade_name + " - " + json.zone_name);
                    if ($client_phone_number.length)
                        $client_phone_number.val(json.phone_number);
                    if ($address_pickup_text.length)
                        $address_pickup_text.val(json.address_pickup_text);
                    if ($address_pickup_maps.length)
                        $address_pickup_maps.val(json.address_pickup_maps);
                }
            });
    });

    $("#address_from_zones").change(function () {
        var val = $(this).val();
        var $this = $(this);
        //console.log(val);
        if(val.trim() !== "")
            $.ajax({
                type: "POST",
                url: "/ajax_requests.php",
                data: {
                    action: "address_zone_data",
                    address_id: val
                },
                success: function (data) {
                    if(data == "error") {
                        return;
                    }
                    var json = JSON.parse(data);
                    var $package_weight = $("#package_weight");
                    if($package_weight.length && json.zone && json.zone.base_weight)
                        $package_weight.val(json.zone.base_weight);

                }
            });
    });

    $("#addPickupForm").submit(function (e) {
        if ($("#clientIdInput").hasClass("error")) {
            e.preventDefault();
            return false;
        }
        return true;
    });
});