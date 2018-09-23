module.exports = selectableTable = {
    $selectableTable: null,
    selected: [],
    $selAll: null,
    init: function () {
        this.$selectableTable = $('.table-selectable');
        this.$selAll = this.$selectableTable.find("#selectAll");
        this.controller();
    },
    controller: function () {
        this.$selectableTable.on('click', 'tbody tr :not(.btn)', selectableTable.on.rowSelect)
        this.$selectableTable.on('change', 'tbody .custom-checkbox .custom-control-input', function () {
            selectableTable.on.checkboxChanged(this);
            selectableTable.checkSelected()
        });
        this.$selAll.on('change', selectableTable.on.selectAll);
        this.extra();
    },
    extra: function () {
        $('.dataTables_wrapper .page-link').on("click", function () {
            selectableTable.checkSelected();
        });
    },
    on: {
        rowSelect: function (e) {
            if ($(e.target).is('.custom-checkbox, .custom-checkbox *')) return;
            var checkbox = $(this).find('.custom-checkbox .custom-control-input');
            var oldVal = checkbox.prop('checked')
            checkbox.prop('checked', !oldVal).trigger('change');
        },
        checkboxChanged: function (_this) {
            var $this = _this ? $(_this) : $(this)
            var $row = $this.closest('tr');
            if ($this.is(":checked")) {
                $row.addClass('selected');
                selectableTable.selected.push($row.data('id'));
            } else {
                $row.removeClass('selected');
                var position = selectableTable.selected.indexOf($row.data('id'));
                if (position !== -1)
                    selectableTable.selected.splice(position, 1);
            }
        },
        selectAll: function () {
            var $this = $(this)
            var $checkBoxes = selectableTable.$selectableTable.find('tbody .custom-checkbox .custom-control-input');
            if ($this.is(":checked")) {
                $checkBoxes.prop('checked', true);
            } else {
                $checkBoxes.prop('checked', false);
            }
            $checkBoxes.each(function () {
                selectableTable.on.checkboxChanged(this);
            });
            selectableTable.checkSelected();
        }
    },
    checkSelected: function () {
        var $selected = $('.table-selectable tbody tr.selected');
        var $notSelected = $('.table-selectable tbody tr:not(.selected)');
        var $actions = $(".reports-actions");
        if ($actions.length) {
            if ($selected.length) {
                $('.selection-indicator').text($selected.length + " Selected");
                $actions.find('input[name=shipments]').val(selectableTable.selected.join(','));
                $(".page-heading").addClass('sticky');
                if ($notSelected.length) {
                    selectableTable.$selAll.prop('indeterminate', true);
                } else {
                    selectableTable.$selAll.prop('checked', true);
                    selectableTable.$selAll.prop('indeterminate', false);
                }
                $actions.removeClass('disabled');
                $actions.find('.btn').prop('disabled', false);
            } else {
                $('.selection-indicator').text("With Selected:")
                $(".page-heading").removeClass('sticky');
                selectableTable.$selAll.prop('selected', false);
                $actions.addClass('disabled');
                $actions.find('.btn').prop('disabled', true);
            }
        }
        var $clientsAddresses = $(".custom-addresses-actions, .addresses-table-actions");
        if ($clientsAddresses.length) {
            var clientTable = $clientsAddresses.is('.custom-addresses-actions');
            if ($selected.length) {
                var selected = [];
                $selected.each(function () {
                    var val = $(this).find('input[type=checkbox]').val();
                    if (clientTable) {
                        if ($(this).is('.modified, .new'))
                            selected.push(val + ":customize");
                        else {
                            selected.push(val + ":new");
                        }
                    } else {
                        selected.push(val);
                    }
                })
                $clientsAddresses.find('input[name=addresses]').val(selected.join(','));
                $('.selection-action').prop('disabled', false);
                if ($selected.not('.modified, .new').length)
                    $('.selection-action-delete').prop('disabled', true);
            } else {
                $('.selection-action').prop('disabled', true);
            }
        }
    },
    clearSelected: function () {
        $('.table-selectable tr.selected').removeClass('selected');
        selectableTable.selected = [];
        var $actions = $(".reports-actions");
        $actions.find('input[name=shipments]').val("");
        $actions.prop('disabled', true);
    }
}