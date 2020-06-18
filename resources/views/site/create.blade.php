@extends('layout.app')

@section('title') サイト一覧 @endsection


@section('content')

    <h2>新規登録</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('sites.store') }}" method="post">
            @csrf
                <label for="title">タイトル</label>
                <input type="text" class="form-control" name="title">
                <label for="page_url">URL</label>
                <input type="text" class="form-control" name="page_url">
                <label for="page">ページ</label>
                <input type="text" name="pages[]" class="form-control">
                <input type="text" name="pages[]" class="form-control">
                <input type="text" name="pages[]" class="form-control">
                <input type="text" name="pages[]" class="form-control">
            <button class="btn btn-info">OK</button>
            </form>
        </div>
    </div>
@endsection
