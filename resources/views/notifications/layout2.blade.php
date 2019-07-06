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
            Sincerely Yours<br>
            Accounting department
            <br>
            <br>
            <small style="color: #909090;">
                Disclaimer:
                The information contained in this e-mail and its attachments is confidential and may be privileged.
                If you have received this email by mistake or are not the intended recipient please delete it and inform
                us immediately.
            </small>
            @endcomponent
            @endslot

            {{-- Footer --}}
            @slot('footer')
            @component('mail::footer')
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent