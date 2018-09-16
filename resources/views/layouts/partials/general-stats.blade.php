<h3 class="m-0 mb-4 font-weight-bold"><i
            class="icon-graph mr-2"></i>@lang("dashboard.stats.label")</h3>
<div class="widget-infobox">
    <a href="{{ route('shipments.index', ['scope' => 'pending']) }}" class="infobox">
        <div class="left">
            <i class="fa fa-clock bg-blue"></i>
        </div>
        <div class="right">
            <div>
                <span class=" pull-left">{{ $statistics['pending'] }}</span>
            </div>
            <div class="txt">Pending</div>
        </div>
    </a>
    <a href="{{ route('shipments.index', ['scope' => 'received']) }}" class="infobox">
        <div class="left">
            <i class="fa fa-archive bg-red"></i>
        </div>
        <div class="right">
            <div class="clearfix">
                <div>
                    <span class="c-red pull-left">{{ $statistics['received'] }}</span>
                </div>
                <div class="txt">Received</div>
            </div>
        </div>
    </a>
    <a href="{{ route('shipments.index', ['scope' => 'delivered']) }}" class="infobox">
        <div class="left">
            <i class="fa fa-check bg-green"></i>
        </div>
        <div class="right">
            <div class="clearfix">
                <div>
                    <span class="c-green pull-left">{{ $statistics['delivered'] }}</span>
                </div>
                <div class="txt">Delivered</div>
            </div>
        </div>
    </a>
    <a class="infobox" href="{{ route('shipments.returned') }}">

        <div class="left">
            <i class="fa-reply bg-purple"></i>
        </div>
        <div class="right">
            <div class="clearfix">
                <div>
                    <span class=" pull-left">{{ $statistics['returned'] }}</span>
                </div>
                <div class="txt">Returned</div>
            </div>
        </div>
    </a>
    <a href="{{ route('pickups.index') }}" class="infobox">
        <div class="left">
            <i class="fa-shopping-bag bg-orange"></i>
        </div>
        <div class="right">
            <div class="clearfix">
                <div>
                    <span class="c-red pull-left">{{ $statistics['pickups'] }}</span>
                </div>
                <div class="txt">Pickups</div>
            </div>
        </div>
    </a>
    <a href="{{ route('clients.index') }}" class="infobox">
        <div class="left">
            <i class="fa-user-tie bg-purple"></i>
        </div>
        <div class="right">
            <div class="clearfix">
                <div>
                    <span class="c-green pull-left">{{ $statistics['clients'] }}</span>
                </div>
                <div class="txt">Clients</div>
            </div>
        </div>
    </a>
    <a href="{{ route('couriers.index') }}" class="infobox">
        <div class="left">
            <i class="fa-truck bg-blue"></i>
        </div>
        <div class="right">
            <div class="clearfix">
                <div>
                    <span class="c-green pull-left">{{ $statistics['couriers'] }}</span>
                </div>
                <div class="txt">Couriers</div>
            </div>
        </div>
    </a>
</div>