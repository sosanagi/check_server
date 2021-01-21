<?php

namespace App\Http\Controllers;

use App\Models\TlabServer;

use App\Http\Controllers\TlabServerSplit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TlabServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        //id=1の部署を取得
        $data = DB::table('id_sets')
                    ->join('server_nets', 'id_sets.net_id', '=', 'server_nets.server_id')
                    ->join('server_info_ids','id_sets.id', '=', 'server_info_ids.id')
                    ->select('server_info_ids.info','id_sets.id','server_nets.ip','server_nets.created_at')
                    ->get();

        //所属メンバーを取得
        Log::info($data);
        // $disks = $idset->disk;

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request, TlabServerSplit $split)
    {
        $timestamps = false;
        $data = $request->all();
        
        $split -> server_data_input($data);
        
        // return TlabServer::all();
    }

    /**
     * Display a listing of the resource.
     * /tlabServer/hard/{{server_name}}
     *
     * @return \Illuminate\Http\Response
     */
    public static function show_hard($name)
    {
        $cpu_data = DB::table('id_sets')
            ->join('server_info_ids as name','id_sets.id', '=', 'name.id')
            ->join('server_info_ids as cpu','id_sets.cpu_id','=','cpu.id')
            ->join('server_info_ids as memory','id_sets.memory_id', '=', 'memory.id')
            ->where('name.info' , '=' , $name)
            ->select('name.info as pc_name',"cpu.info as cpu_name","memory.info as memory_name")
            ->get();
    
        return $cpu_data;
    }

    public static function show_soft($name)
    {
        $id = DB::table('id_sets')
            ->join('server_info_ids as name','id_sets.id', '=', 'name.id')
            ->where('name.info' , '=' , $name)
            ->orderby("id","desc")
            ->first();
        

        $data = DB::table('server_softs')
            ->where('server_softs.server_id' , '=' , $id->os_id)
            ->orderby("id","desc")
            ->select("os_name","release","hardwaretype","created_at")
            ->get();
        
        return $data;
    }

    public static function show_disk($name)
    {
        $id = DB::table('id_sets')
            ->join('server_info_ids as name','id_sets.id', '=', 'name.id')
            ->where('name.info' , '=' , $name)
            ->orderby("id","desc")
            ->first();

        $data = DB::table('server_disks')
            ->where('server_disks.server_id' , '=' , $id->disk_id)
            ->orderby("id","desc")
            ->select("device","fstype","total","used","free","percent","mount","updated_at")
            ->get();

        $discount = array();
        foreach($data as $val) {
            if(!isset($discount[$val->mount])) {
            $results[] = $val;
            $discount[$val->mount] = $val->mount;
            }
        }

        $disk_res = collect(array_reverse($results));
        
        return $disk_res;
    }

    public static function show_net($name)
    {
        $id = DB::table('id_sets')
            ->join('server_info_ids as name','id_sets.id', '=', 'name.id')
            ->where('name.info' , '=' , $name)
            ->orderby("id","desc")
            ->first();

        $data = DB::table('server_nets')
            ->where('server_nets.server_id' , '=' , $id->net_id)
            ->orderby("id","desc")
            ->get();

        $discount = array();
        foreach($data as $val) {
            if(!isset($discount[$val->MAC])) {
            $results[] = $val;
            $discount[$val->MAC] = $val->MAC;
            }
        }

        $res = collect(array_reverse($results));
    
        return $res;
    }

    public static function show_cpuused($name)
    {
        $id = DB::table('id_sets')
            ->join('server_info_ids as name','id_sets.id', '=', 'name.id')
            ->where('name.info' , '=' , $name)
            ->orderby("id","desc")
            ->first();

        $data = DB::table('cpu_useds')
            ->where('cpu_useds.server_id' , '=' , $id->cpu_id)
            ->where('cpu_useds.created_at' , '>=' , Carbon::now()->subDay())
            ->orderby("id","desc")
            ->get();

        

        $data_cpu= $data->pluck('cpu_percent');
        $data_date= $data->pluck('created_at');

        Log::info([$data_cpu,$data_date]);
    
        return [$data_cpu,$data_date];
    }

    public static function table_columns($name)
    {
        if($name=="hard"){
            $data = ["pc_name","cpu","memory"];
        }elseif ($name=="soft") {
            $data = ["os","os_release","hardware","更新時間"];
        }elseif ($name=="disk") {
            $data = ["ファイルシステム","型","サイズ","使用","残り","使用%","マウント位置","更新時間"];
        }elseif ($name=="net") {
            $data = ["ip_address","MAC_address","更新時間"];
        }
        
        return $data;
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TlabServer  $tlabServer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TlabServer $tlabServer)
    {
        $tlabServer->a = $request->a;
        $tlabServer->b = $request->b;
        $tlabServer->c = $request->c;
        return $tlabServer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TlabServer  $tlabServer
     * @return \Illuminate\Http\Response
     */
    public function destroy(TlabServer $tlabServer)
    {
        $tlabServer->delete();
    }
}
