@extends('notifications.layout' . (isset($layout) ? $layout : ''))

@section('body')
@includeIf("notifications.markdown." . $tmpl)
@endsection