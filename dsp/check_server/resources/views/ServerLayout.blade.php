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
            @yield("table_contents")
        </div>
    </section>
@stop

@section('css')
    @yield("css")
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style type="text/css">
        .table {
            table-layout: fixed;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        .table tr th:nth-child(1) {
            width: 30%;
        }
    </style>
@stop

@section('js')
    @yield("js")
    <script> console.log('Hi!'); </script>
@stop
