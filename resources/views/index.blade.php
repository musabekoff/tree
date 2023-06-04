@extends('layouts.app')
@section('content')
    <main id="app" data-hash="{{ Auth::id() }}">
        <transition name="fade" mode="out-in">
            <router-view :key="$route.path"></router-view>
        </transition>
    </main>
@endsection
