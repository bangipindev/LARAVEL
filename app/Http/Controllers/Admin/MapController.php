<?php

namespace App\Http\Controllers\Admin;

use App\Map;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data['title']              = 'Map'; 

        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $Map                        = Map::find(1);
        if(empty($Map['id'])){
            $data['id']				= $this->kode_otomatis();
        }
        else{
            $data['id']				= 1;
        }
        $data['nama']				= $Map['nama'];
        $data['caption']			= $Map['caption'];
        $data['embed']				= $Map['embed'];
        $data['status']				= $Map['status'];
        $data['dd_status']			= $this->dd_status();
        
        $data['css']                = view('admin.map.css');            
        $data['js']                 = view('admin.map.js');             
        $data['script']             = view('admin.map.scripts');             
        return view('admin.map.list')->with($data);
    }

    public function store (Request $request){
       
        $data = [
            'nama'                  => $request['nama'],
            'caption'               => $request['caption'],
            'status'                => $request['status'],
            'embed'                 => $request['embed'],
        ];
        
        $id                         = $request['id'];
        $d                          = Map::where('id','=',$id);
    
        if ($d->count() > 0){
            Map::where('id','=',$id)->update($data);
            return redirect('/appmaster/maps')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Map::create($data);
            return redirect('/appmaster/maps')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
      
    }
    function dd_status(){
		$dd['']='---Status---';
        $dd['1']= 'Not Publish';
        $dd['2']= 'Publish';
		
		return $dd;
	}
    function kode_otomatis()
    {
        $query          = Map::select(Max('id','1'))->get();
        $kd             = "";
        if ($query->count() > 0){
            foreach ($query as $k){
                $tmp = ((int)$k->kode_max)+1;
                $kd = sprintf("%01s", $tmp);
            }
        }
        else
        {
            $kd = "1";
        }
        return $kd;
		
    }
}
