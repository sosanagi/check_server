<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\ServerInfoId;
use App\Models\ServerDisk;
use App\Models\ServerNet;
use App\Models\ServerSoft;
use App\Models\CpuUsed;
use App\Models\IdSet;
use Carbon\Carbon;

class TlabServerSplit extends TlabServerController
{
    private function id_info($data,$check_id)
    {
        $id_info = ServerInfoId::firstOrNew(['id' => $check_id]);
        $id_info -> info = $data;
        $id_info -> save();
    }

    private function pc_name_info($data)
    {
        // Log::debug("new pc_name_info: " . $data);
        $id_info = ServerInfoId::firstOrNew(['info' => $data]);
        $id_info -> info = $data;
        $id_info -> save();

        $last_insert_id = $id_info->id;

        return $last_insert_id;
    }

    private function net_info($data,$check_id)
    {
        $collection = collect($data);
        $net_data = $collection->values();
        $net_data_count = $net_data -> count();
        
        foreach($net_data as $value){
            $id_info = ServerNet::firstOrNew(['server_id' => $check_id,'MAC' => $value["MAC_address"]]);
            $id_info -> ip = $value["IP_address"];
            $id_info -> MAC = $value["MAC_address"];
            $id_info -> created_at = Carbon::now();
            $id_info -> save();
        }
    }

    private function disk_info($data,$check_id)
    {
        $collection = collect($data);
        $disk_mounts = $collection->keys();

        foreach($disk_mounts as $disk_mount){
            $disk_mount_data = $collection->get($disk_mount);
            $disk_datas = collect($disk_mount_data);

            $server_disk = ServerDisk::firstOrNew(['server_id' => $check_id,'mount' => $disk_mount]);
            $server_disk -> server_id = $check_id;
            $server_disk -> mount = $disk_mount;
            $server_disk -> device = $disk_datas->get("device");
            $server_disk -> free = $disk_datas->get("free");
            $server_disk -> fstype = $disk_datas->get("fstype");
            $server_disk -> percent = $disk_datas->get("percent");
            $server_disk -> total = $disk_datas->get("total");
            $server_disk -> used = $disk_datas->get("used");
            $server_disk -> updated_at = Carbon::now();
            $server_disk -> save();
        }
    }

    private function os_info($data,$check_id)
    {
        $os_data = collect($data);
        // $os_data = $collection->values();
        
        $os_info = ServerSoft::firstOrNew(['server_id' => $check_id]);
        $os_info -> os_name = $os_data["os_name"];
        $os_info -> release = $os_data["release"];
        $os_info -> hardwaretype = $os_data["hardwaretype"];
        $os_info -> created_at = Carbon::now();
        $os_info -> save();
    }

    private function cpu_percent($data,$check_id)
    {
        $cpu_usage = new CpuUsed;
        $cpu_usage -> server_id = (string)$check_id;
        $cpu_usage -> cpu_percent = doubleval($data);
        $cpu_usage -> save();
    }

    public function server_data_input($data)
    {
        $collection = collect($data);
        $pc_name = $collection->keys()->first();
        $pc_data = $collection->get($pc_name);
        $data_value = json_decode(str_replace("'",'"',$pc_data),true);        

        $pc_name_id = $this->pc_name_info($pc_name);

        $id_sets = IdSet::where('id', $pc_name_id)->orderBy('id', 'desc')->take(1)->get()->first();
        if(!$id_sets){
            $id_sets = collect(['id' => ($pc_name_id), 'cpu_id' => (string)($pc_name_id+1),
                'memory_id' => (string)($pc_name_id+2),'net_id' => (string)($pc_name_id+3), 'disk_id' => (string)($pc_name_id+4),
                'os_id' => (string)($pc_name_id+5)]);
        }

        $id_info = IdSet::firstOrNew(['id' => $id_sets["id"]]);
        $id_info -> fill($id_sets->toArray());
        $id_info -> save();

        foreach($data_value as $key => $value){
            switch($key){
                case $key === "cpu_info":
                    $this -> id_info($value,$id_sets["cpu_id"]);
                    break;
                case $key === "memory_info":
                    $this -> id_info($value,$id_sets["memory_id"]);
                    break;
                case $key === "net_info":
                    $this -> net_info($value,$id_sets["net_id"]);
                    break;
                case $key === "disk_info":
                    $this -> disk_info($value,$id_sets["disk_id"]);
                    break;
                case $key === "platform":
                    $this -> os_info($value,$id_sets["os_id"]);
                    break;
                case $key === "cpu_percent":
                    $this -> cpu_percent($value,$id_sets["cpu_id"]);
                    break;
                default:
                    Log::debug($key . "not found");
            }
        }
    }
}
