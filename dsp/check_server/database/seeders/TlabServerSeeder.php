<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TlabServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('tlabServer')->truncate();
        DB::table('tlab_servers')->insert([
            ['a' => 'a','b' => 'b','c' => 'c']
        ]);

        $id_infos = ['id(仮)','cpu_id(仮)','memory_id(仮)','net_id(仮)'];
        $disk_infos = ['/private/var/vm','/dev/disk1s4','129.8G','apfs',2,'187.2G','3.0G'];

        foreach ($id_infos as $id_info) {
            DB::table('server_info_ids')->insert([
                ['info' => $id_info]
            ]);
        }

        DB::table('server_disks')->insert([
            [
                'mount' => $disk_infos[0],
                'device' => $disk_infos[1],
                'free' => $disk_infos[2],
                'fstype' => $disk_infos[3],
                'percent' => $disk_infos[4],
                'total' => $disk_infos[5],
                'used' => $disk_infos[6],
            ]
        ]);
    }
}
