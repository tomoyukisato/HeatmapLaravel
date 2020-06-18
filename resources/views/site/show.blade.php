@extends('layout.app')

@section('title') サイト詳細 @endsection

@section("script")
        <script type="text/javascript" src="{{asset('js/heatmap.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/viewheatmap.js')}}"></script>
@endsection

@section("style")
        <style>
            #heatmapContainerWrapper { width:100vw;height:100%;position:absolute; }
            #heatmapContainer { width:100%; height:100%;}
        </style>
@endsection

@section("content")
    <div class="card">
        <div class="card-header">サイト名：{{ $site->title }}</div>
        <div class="card-body">
        
            <table class="table table-borderless">
                        <tr><td>URL</td><td>{{$site->site_url}}</td></tr>
                        <form method="get" action="{{route('sites.show',$site->id) }}">
                            <tr> 
                                <td>
                                <label for="select">Page URL:</label>
                                </td>
                                <td>

                                    <select id="select" name="page" class="form-control">
                                        <option></option>
                                        @foreach($site->page as $i => $page)
                                            @if(request()->input("page") == $page->id)    
                                            <option value="{{$page->id}}" selected>{{ $page->page_url }}</option>
                                            @else
                                            <option value="{{$page->id}}">{{ $page->page_url }}</option>
                                            @endif                                    
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr> 
                                <td>デバイス</td>
                                <td>
                                    <div class="form-check">
                                        
                                        <input type="radio" name="device" value="1" class="form-check-input" id="pc" {{ (request()->input("device") == 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pc" >PC</label>
                                    
                                    </div>
                                    <div class="form-check">
                                    
                                        <input type="radio" name="device" value="2" class="form-check-input" id="tab" {{ (request()->input("device") == 2) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tab">TAB</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="device"  value="3" class="form-check-input" id="sp" {{ (request()->input("device") == 3) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sp">SP</label>
                                    </div>
                                </td>
                            </tr>
                            <tr> 
                                <td>表示タイプ</td>
                                <td>
                                    <div class="form-check">
                                        
                                        <input type="radio" name="type" value="1" class="form-check-input" id="click" {{ (request()->input("type") == 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="click" >Click Data</label>
                                    
                                    </div>
                                    <div class="form-check">
                                    
                                        <input type="radio" name="type" value="2" class="form-check-input" id="screentime" {{ (request()->input("type") == 2) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="screentime">ScreenTime</label>
                                    </div>
                                    
                                </td>
                            </tr>
                            <tr>
                            <td>
                                <button type="submit" class="btn btn-info">更新</button>
                            </td>
                            </tr>
                        </form>
            </table>
        </div>
    </div>
    @if(request()->input("type") == 1)
    <div class="card mt-5">
        <div class="card-header">｜リンククリック一覧</div>
        <div class="card-body">
            <div class="row">   
                <table class="table">
                <thead>
                    <tr><th>URL</th><th>クリック数</th></tr>
                </thead>
                <tbody>
                        @foreach($list as $link)
                        <tr><td>{{$link["url"]}}</td><td>{{$link["count"]}}</td></tr>
                        @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    <div class="row mt-5 px-5">
            @if(asset($site->img))

                <div id="heatmapContainerWrapper" style="z-index:1;">
                    <div id="heatmapContainer">
                    </div>
                </div> 
                <div id="target">
                
                    <img src="{{asset($site->img)}}" style="width:800px" alt="" class="img-fluid" id="show_img" style="display:none">
                    
                </div>
                <canvas id="target1"> </canvas>
        @endif
    </div>
@endsection

@section("body_script")
<script src="{{asset('js/index.js')}}"></script>
@endsection

