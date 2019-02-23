<div class="d-flex align-items-center mb-4">
    <h3 class="m-0 font-weight-bold mr-3"><i
                class="icon-graph mr-2"></i>@lang("dashboard.stats.label")</h3>
    <ul class="nav nav-pills statistics-nav">
        <li class="nav-item">
            <a href="#" class="nav-link active" data-value="today">@lang('common.today')</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" data-value="lifetime">@lang('common.lifetime')</a>
        </li>
    </ul>
</div>

<div class="widget-infobox" data-show="today">
    @isset($statistics['normal'])
        <a href="{{ route('shipments.index', ['filters[types]' => 'normal']) }}" class="infobox">
            <div class="left">
                <i class="fa fa-shipment bg-blue"></i>
            </div>
            <div class="right">
                <div class="stat-value">
                    <span class="today pull-left">{{ $statistics['normal']['today'] }}</span>
                    <span class="lifetime pull-left">{{ $statistics['normal']['lifetime'] }}</span>
                </div>
                <div class="txt">@lang('shipment.label')</div>
            </div>
        </a>
    @endisset
    @isset($statistics['returned'])
        <a href="{{ route('shipments.index', ['filters[types]' => 'returned']) }}" class="infobox">
            <div class="left">
                <i class="fa fa-shipment bg-red"></i>
            </div>
            <div class="right">
                <div class="stat-value">
                    <span class="c-pink today pull-left">{{ $statistics['returned']['today'] }}</span>
                    <span class="lifetime pull-left">{{ $statistics['returned']['lifetime'] }}</span>
                </div>
                <div class="txt">@lang('shipment.returned')</div>
            </div>
        </a>
    @endisset
    @isset($statistics['pickups'])
        <a href="{{ route('pickups.index') }}" class="infobox">
            <div class="left">
                <i class="fa-shopping-bag bg-orange"></i>
            </div>
            <div class="right">
                <div class="clearfix">
                    <div class="stat-value">
                        <span class="c-red today pull-left">{{ $statistics['pickups']['today'] }}</span>
                        <span class="c-red lifetime pull-left">{{ $statistics['pickups']['lifetime'] }}</span>
                    </div>
                    <div class="txt">Pickups</div>
                </div>
            </div>
        </a>
    @endisset
    @isset($statistics['clients'])
        <a href="{{ route('clients.index') }}" class="infobox">
            <div class="left">
                <i class="fa-user-tie bg-purple"></i>
            </div>
            <div class="right">
                <div class="clearfix">
                    <div class="stat-value">
                        <span class="c-green today pull-left">{{ $statistics['clients']['today'] }}</span>
                        <span class="c-green lifetime pull-left">{{ $statistics['clients']['lifetime'] }}</span>
                    </div>
                    <div class="txt">Clients</div>
                </div>
            </div>
        </a>
    @endisset
    @isset($statistics['couriers'])
        <a href="{{ route('couriers.index') }}" class="infobox">
            <div class="left">
                <i class="fa-truck bg-blue"></i>
            </div>
            <div class="right">
                <div class="clearfix">
                    <div class="stat-value">
                        <span class="c-green today pull-left">{{ $statistics['couriers']['today'] }}</span>
                        <span class="c-green lifetime pull-left">{{ $statistics['couriers']['lifetime'] }}</span>
                    </div>
                    <div class="txt">Couriers</div>
                </div>
            </div>
        </a>
    @endisset

</div>