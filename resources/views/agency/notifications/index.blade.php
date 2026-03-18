@extends('layouts.agency')

@section('content')
@include('partials.notifications-list', ['notifications' => $notifications, 'markAllRoute' => route('agency.notifications.markAllAsRead')])
@endsection
