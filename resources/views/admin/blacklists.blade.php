@extends('layouts.admin')

@section('content')
    @livewire('admin.blacklists.index-table', ['blacklistType' => 'DOMAIN'])
@endsection
