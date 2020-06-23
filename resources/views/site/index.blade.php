@extends('layouts.app')

@section('title') サイト一覧 @endsection


@section('content')

        <table class="table">
        @foreach($data as $i => $site)
            <tr>
            <td>{{$i+1 }}</td>
                <td>{{$site->title}}</td>
                <td>{{$site->site_url}}</td>
                <td>
                <button class="btn btn-info"><a href="{{ route('sites.show',$site->id) }}">詳細</a></button></td>
            </tr>
        @endforeach
        </table>

@endsection
