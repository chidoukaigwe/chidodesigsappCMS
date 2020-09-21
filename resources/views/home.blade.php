@extends('layouts.app')

@section('content')
    <!--pass entire user model into our app -->
    <App :user="{{auth()->user()}}"></App>
@endsection
