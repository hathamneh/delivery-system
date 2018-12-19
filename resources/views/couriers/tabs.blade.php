<nav class="nav inner-nav">
    <a href="{{ route('couriers.show', ['courier'=>$courier]) }}"
       class="{{ $tab != "statistics" ?: "active" }}"><i class="fa-chart-line"></i> @lang('courier.statistics')</a>

    <a href="{{ route('couriers.edit', ['courier'=>$courier]) }}"
       class="{{ $tab != "edit" ?: "active" }}"><i class="fa-cogs"></i> @lang('courier.edit')</a>
</nav>