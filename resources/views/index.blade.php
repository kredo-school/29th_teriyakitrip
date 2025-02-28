@extends('layouts.tab_layout')

@section('content')
<div class="container">
    <!-- タブナビゲーション -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link @if(request()->route('tab') == 'overview' || request()->route('tab') == null) active @endif" 
               href="{{ route('mypage.show', ['tab' => 'overview']) }}">
                Overview
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request()->route('tab') == 'itineraries') active @endif" 
               href="{{ route('mypage.show', ['tab' => 'itineraries']) }}">
                Itineraries
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request()->route('tab') == 'restaurant_reviews') active @endif" 
               href="{{ route('mypage.show', ['tab' => 'restaurant_reviews']) }}">
                Restaurant Reviews
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request()->route('tab') == 'followers') active @endif" 
               href="{{ route('mypage.show', ['tab' => 'followers']) }}">
                Followers
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request()->route('tab') == 'following') active @endif" 
               href="{{ route('mypage.show', ['tab' => 'following']) }}">
                Following
            </a>
        </li>
    </ul>

    <!-- タブのコンテンツ (各ビューを直接表示) -->
    <div class="tab-content mt-4">
        @include($tabContent, $data)
    </div>
</div>
@endsection