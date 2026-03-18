@extends('layouts.admin')

@section('content')
@include('partials.notifications-list', ['notifications' => $notifications, 'markAllRoute' => route('admin.notifications.markAllAsRead')])
@endsection
