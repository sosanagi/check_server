
import os
import re
import json 
import sys
import psutil
from psutil._common import bytes2human
from cpuinfo import get_cpu_info
import pprint
import platform
from socket import error as SocketError
import urllib.request
import urllib.parse
from datetime import datetime
import random
import time


def send_noaaServer(json_data):
    data = urllib.parse.urlencode(json_data).encode("utf-8")
    request = urllib.request.Request("http://127.0.0.1:8000/api/tlabServer/", data)
    try:
        response = urllib.request.urlopen(request)
        #print(response)
        print(response.getcode())
        html = response.read()
        res=html.decode("utf-8")

    except SocketError as e:
        print(e)
        print("Connection closed")
        pass


def disk():
    # templ = "%-17s %8s %8s %8s %5s%% %9s  %s"
    # print(templ % ("Device", "Total", "Used", "Free", "Use ", "Type",
    #                "Mount"))

    disk_dict={}

    for part in psutil.disk_partitions(all=False):
        if os.name == 'nt':
            if 'cdrom' in part.opts or part.fstype == '':
                # skip cd-rom drives with no disk in it; they may raise
                # ENOENT, pop-up a Windows GUI error for a non-ready
                # partition or just hang.
                continue
        usage = psutil.disk_usage(part.mountpoint)

        disk_dict[part.mountpoint]={
            "device":part.device,"total":bytes2human(usage.total),"used":bytes2human(usage.used),
            "free":bytes2human(usage.free),"percent":int(usage.percent),"fstype":part.fstype}
        # print(templ % (
        #     part.device,
        #     bytes2human(usage.total),
        #     bytes2human(usage.used),
        #     bytes2human(usage.free),
        #     int(usage.percent),
        #     part.fstype,
        #     part.mountpoint))

        #if part.mountpoint in disk_path_list:
        #    index_list = disk_path_list.index(part.mountpoint)
        #    disk_path_list.pop(index_list)
    #else:
    #    for disk_path in disk_path_list:
    #        print(disk_path + " is Not Found")
    # print(disk_dict)
    return {"disk_info":disk_dict}

def ipaddr():
    ip_dict={}
    recheck = "(\d{1,3}\.){3}\d{1,3}"

    stats = psutil.net_if_stats()
    io_counters = psutil.net_io_counters(pernic=True)
    for nic, addrs in psutil.net_if_addrs().items():
        if re.match(recheck, addrs[0].address) != None:
           if "127.0.0.1" != addrs[0].address :
            ip_dict[nic]={"IP_address":addrs[0].address, "MAC_address":addrs[1].address}

    return ip_dict

def cpu_memory_info():
    cpu_info = get_cpu_info()["brand_raw"] 
    memory_info = bytes2human(psutil.virtual_memory().total)
    ip_dict=ipaddr()

    json_data = {"cpu_info":cpu_info,"memory_info":memory_info}
    json_data["net_info"] = ip_dict
    
    return json_data

def cpu_percent():
    cpu_percent = psutil.cpu_percent(interval=1)

    return {"cpu_percent":cpu_percent}

def os_name():
    os_name = platform.system()
    release = platform.release()
    machine = platform.machine()
    
    return {"platform":{"os_name":os_name,"release":release,"hardwaretype":machine}}

def main():
    pc_name = "sosa_mac"
    json_dict = {}

    if not (pc_name):
        print("Error! set pc_name")
        sys.exit(0)

    if(datetime.now().hour==0 and datetime.now().minute==0):
        disk_dict = disk()
        os_dict = os_name()
        json_dict.update(disk_dict)
        json_dict.update(os_dict)
    
    cpu_dict = cpu_percent()
    json_dict.update(cpu_dict)
    
    # reboot once
    # info_dict = cpu_memory_info()
    # json_dict.update(info_dict)

    time.sleep(random.randint(0,20))

    json_dict = { pc_name : json_dict }

    # pprint.pprint(json_dict, width=4)
    # print(json_dict)
    send_noaaServer(json_dict)

if __name__ == "__main__":
    main()
