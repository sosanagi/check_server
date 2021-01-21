@extends('ServerLayout')

@section('table_contents')

    <div class="box-body">
        <table class="table table-bordered">
        <tr>
            @foreach($table_columns as $columns)
                <th max-width="20">{{$columns}}</th>
            @endforeach
        </tr>
            @foreach($tlab_server_data as $datas)
            <tr>
                @foreach($datas as $key => $data)
                    @if(strpos($key,'id') === false)
                        <td>{{$data}}</td>
                    @endif
                @endforeach
            </tr>
            @endforeach
        <!-- <p>{{$tlab_server_data}}</p> -->
        </table>
    </div>

@stop

