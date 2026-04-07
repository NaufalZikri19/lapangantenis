@extends('layouts.app')

@section('title', 'Gumbreg Tennis Court')

@section('content')

    @include('sections.hero')
    @include('sections.about')
    @include('sections.courts')
    @include('sections.pricing')
    @include('sections.work')

@endsection
