@extends('frontend.layouts.master', ['class_body' => 'categories'])@section('content')    <div class="breadcrumbs">        <a href="#">Inicio »</a>        <span>Legal</span>    </div>    <main class="main">        <div class="grid-categories">            <div class="grid-categories__header">                <h3 class="title">{!! ((isset($staticPages->title) ? $staticPages->title : ''))!!}</h3>            </div>        </div>        <div class="other-opinions">            <div class="grid">                <div class="grid__item">                    <div class="copy">                        <p class="description"> {!! ((isset($staticPages->body) ? $staticPages->body : ''))!!} </p>                    </div>                </div>            </div>        </div>    </main>@endsection