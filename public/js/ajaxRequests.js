(function () {
    $(document).ready(function () {
        var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': _token
            }
        });

        $("#createAddressForm[data-ajax='true']").on('submit', function (e) {
            e.preventDefault()
            var $this = $(this);
            var zone_id = $this.data('zone-id')
            var $modal = $this.closest('.modal');
            var action = $this.attr('action');
            var form_data = {
                'name': $this.find('[name="name"]').val(),
                'sameday_price': $this.find('[name="sameday_price"]').val(),
                'scheduled_price': $this.find('[name="scheduled_price"]').val()
            }
            $modal.find('.modal-ajax-loading').css('display', 'flex');
            $.ajax({
                method: "post",
                url: action,
                data: form_data,
                error: function (jqXHR, textStatus, errorMessage) {
                    console.log(errorMessage); // Optional
                },
                success: function (res) {
                    if (res) {
                        var address = res.data;
                        var $addressesTable = $('.addresses-table');
                        $addressesTable.find('.empty-row').remove();
                        var newRow = '<tr>' +
                            '<td>' + address.name + '</td>' +
                            '<td>' + address.sameday_price + '</td>' +
                            '<td>' + address.scheduled_price + '</td>' +
                            '<td>' + addressesActions(zone_id, address.id) + '</td>' +
                            '</tr>'

                        $addressesTable.find('tbody').append(newRow);
                    }
                    $modal.find('.modal-ajax-loading').css('display', 'none');
                    $modal.modal('hide')
                }

            })
        })
        var addressesActions = function (zone, address) {
            return '<div class="d-flex">\n' +
                '<a class="btn btn-sm btn-outline-secondary mr-1"\n' +
                'href="/zone/' + zone + '/address/' + address + '"' +
                'title="Delete Address"><i class="fa fa-edit"></i></a>' +
                '<form action="/zone/' + zone + '/address" method="post">' +
                '<input type="hidden" name="_token" value="' + _token + '">' +
                '<input type="hidden" name="_method" value="DELETE">' +
                '<button class="btn btn-sm btn-link" title="Delete"' +
                'type="submit"><i class="fa fa-trash"></i></button>' +
                '</form>' +
                '</div>'

        }
    })
})()