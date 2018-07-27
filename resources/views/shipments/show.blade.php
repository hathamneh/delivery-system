@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shipments.show', $shipment) }}
@endsection

@section('pageTitle')
    <i class='fa-shipment'></i> @lang("shipment.single"): {{ $shipment->waybill }}
@endsection

@section('content')
    <nav class="nav inner-nav">
        <a href="{{ route('shipments.show', ['shipment'=>$shipment->id, 'tab'=>'status']) }}"
           class="{{ $tab != "status" ?: "active" }}"><i class="fa-info-circle"></i> @lang('shipment.status')</a>
        <a href="{{ route('shipments.show', ['shipment'=>$shipment->id, 'tab'=>'summery']) }}"
           class="{{ $tab != "summery" ?: "active" }}"><i class="fa-info-circle"></i> @lang('shipment.summery')</a>
        <a href="{{ route('shipments.show', ['shipment'=>$shipment->id, 'tab'=>'actions']) }}"
           class="{{ $tab != "actions" ?: "active" }}"><i class="fa-cogs"></i> @lang('shipment.actions')</a>
        <a href="{{ route('shipments.edit', ['shipment'=>$shipment->id]) }}"
           class="{{ $tab != "edit" ?: "active" }}"><i class="fa-pencil-alt"></i> @lang('shipment.edit')</a>
    </nav>

    @includeWhen($tab == "status", "shipments.tabs.status")
    @includeWhen($tab == "summery", "shipments.tabs.summery")
    @includeWhen($tab == "edit", "shipments.tabs.edit")
    @includeWhen($tab == "actions", "shipments.tabs.actions")

@endsection

@section('beforeBody')
    @if($tab == "actions")
        <script>
            $(document).ready(function () {
                $("select#status, select#original_status").on('change', function () {
                    var val = $(this).val();
                    var $container = $(this).closest('form');
                    var $subStatuses = $container.find("select#sub_status");
                    var $suggestions = $container.find(".suggestions");
                    if($subStatuses.length) {
                        $subStatuses.html("");
                        $subStatuses.closest(".subStatus-field").hide();
                    }
                    $suggestions.html("");
                    $.ajax({
                        url: "/api/suggest/status/" + val,
                        method: "GET",
                        success: function (data) {
                            if (data.subStatuses && data.subStatuses.length) {
                                var options = "";
                                for (var sub of data.subStatuses) {
                                    options += `<option value="${sub.id}">${sub.name}</option>`
                                }
                                $subStatuses.html(options);
                                $subStatuses.selectpicker('refresh');
                                $subStatuses.closest(".subStatus-field").show();
                            }
                            if (data.suggestions && data.suggestions.length) {
                                var suggs = "";
                                for (var sugg of data.suggestions) {
                                    suggs += `<a href="#" class="suggestions-item">${sugg}</a>`;
                                }
                                $suggestions.html(suggs);
                            }
                        }
                    })
                });

                $(document).on('click', '.suggestions-item', function(e){
                    e.preventDefault();
                    var $this = $(this);
                    var $target = $('[data-target-for="'+$this.closest('.suggestions').attr('id')+'"]');
                    $target.val($this.text());
                    $target.focus();
                });
            });
        </script>
    @endif
@endsection
