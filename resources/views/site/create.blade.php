@extends('layouts.app')

@section('title') サイト一覧 @endsection
@section("script")
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
@endsection
@section('content')

    <h2>新規登録</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('sites.store') }}" method="post">
            @csrf
                <label for="title">タイトル</label>
                <input type="text" class="form-control" name="title">
                <label for="page_url">URL</label>
                <input type="text" class="form-control" name="site_url">
                <label for="page">ページ</label>
                <input type="text" name="page_urls[]" id="page_form" class="form-control">
                <button type="button" id="add_field" class="btn btn-info">追加</button>
            <button class="btn btn-info">OK</button>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </form>
        </div>
    </div>

@endsection
@section("body_script")
<script>
$("#add_field").click(function(){
    $('#page_form').after('<input type="text" name="pages[]" class="form-control">');
    console.log("Click");
})
</script>

@endsection
