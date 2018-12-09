@extends('notifications.layout')

@section('body')
@includeIf("notifications.markdown." . $tmpl)
@endsection