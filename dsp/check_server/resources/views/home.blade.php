
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <!-- コンテンツヘッダ -->
    <section class="content-header">
        <h1>T-lab_Server管理ページ</h1>
    </section>

    <!-- メインコンテンツ -->
    <section class="content">

        <!-- コンテンツ1 -->
        <div class="box">
            <div class="box-header with-border">
                {{-- <h3 class="box-title">T-lab_Server一覧</h3> --}}

                <!-- <form class="form-inline" style="margin:15px;">
                    <div class="form-group">
                        <label>検索：</label>
                        <input type="text" name="keyword" class="form-control" style="width:200px;">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="検索" class="btn btn-primary">
                    </div>
                </form> -->

            </div>
            <div class="box-body">
                <table class="table table-bordered">
                <tr>
                    <th>pc名</th>
                    <th>生存</th>
                    <th>ハードウェア情報</th>
                    <th>ソフトウェア情報</th>
                    <th>ディスク</th>
                    <th>IP_address</th>
                    <th>cpu使用率</th>
                </tr>
                @foreach($tlab_server_data as $user)
                    <tr>
                        <td>{{$user->info}}</td>
                        @if( \Carbon\Carbon::parse($user->created_at)->gt(\Carbon\Carbon::yesterday()) )
                            <td>
                                <font><span onmouseover="this.innerHTML=' {{$user->created_at}} '"
                                 onmouseout="this.innerHTML='正常'">正常</span></font>
                                <div class="G_circle"></div>
                            </td>
                        @else
                            <td>
                                <font><span onmouseover="this.innerHTML=' {{$user->created_at}} '"
                                        onmouseout="this.innerHTML='異常'">異常</span></font>
                                <div class="R_circle"></div>
                            </td>
                        @endif
                        <td><a href="/tlabServer/hard/{{$user->info}}">hard</a></td>
                        <td><a href="/tlabServer/soft/{{$user->info}}">soft</a></td>
                        <td><a href="/tlabServer/disk/{{$user->info}}">disk</a></td>
                        <td><a href="/tlabServer/net/{{$user->info}}">{{$user->ip}}</a></td>
                        <td><a href="/tlabServer/cpu/{{$user->info}}">cpu</a></td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
    </section>
@stop

@section('css')
    <style>
        .G_circle{
            border: 2px solid gray;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #66FF33;/*背景色*/
        }
        .R_circle{
            border: 2px solid gray;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: red;/*背景色*/
        }
    </style>
@stop
@section('js')
    <script> console.log('Hi!'); </script>
@stop
