@component('mail::layout')

    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('images/logo-fullxhdpi.png') }}" alt="{{ config('app.name') }}" height="75">
        @endcomponent
    @endslot

    @yield('body')

    {{-- Subcopy --}}
    @slot('subcopy')
        @component('mail::subcopy')
            Accounting Department,<br>
            Kangaroo Delivery
            @endcomponent
            @endslot

            {{-- Footer --}}
            @slot('footer')
            @component('mail::footer')
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent