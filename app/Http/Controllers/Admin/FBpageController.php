<?php

namespace App\Http\Controllers\Admin;

use App\FBpage;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FBpageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data['title']              = 'Fanpage Facebook'; 

        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $fb                        = FBpage::find(1);
        if(empty($fb['id'])){
            $data['id']				= $this->kode_otomatis();
        }
        else{
            $data['id']				= 1;
        }
        $data['applicationid']		= $fb['applicationid'];
        $data['url']			    = $fb['url'];
        $data['width']				= $fb['width'];
        $data['height']				= $fb['height'];
        $data['show_face']			= $fb['show_face'];
        $data['show_status']		= $fb['show_status'];
        $data['show_header_fb']		= $fb['show_header_fb'];
        $data['dd_show_face']		= $this->dd_status();
        $data['dd_show_status']		= $this->dd_status();
        $data['dd_show_header_fb']	= $this->dd_status();
        
        $data['css']                = view('admin.fb.css');            
        $data['js']                 = view('admin.fb.js');             
        $data['script']             = view('admin.fb.scripts');             
        return view('admin.fb.list')->with($data);
    }

    public function store (Request $request){
       
        $data = [
            'applicationid'         => $request['applicationid'],
            'url'                   => $request['url'],
            'width'                 => $request['width'],
            'height'                => $request['height'],
            'show_face'             => $request['show_face'],
            'show_status'           => $request['show_status'],
            'show_header_fb'        => $request['show_header_fb'],
        ];
        
        $id                         = $request['id'];
        $d                          = FBpage::where('id','=',$id);
    
        if ($d->count() > 0){
            FBpage::where('id','=',$id)->update($data);
            return redirect('/appmaster/fanpage')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            FBpage::create($data);
            return redirect('/appmaster/fanpage')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
      
    }
    function dd_status(){
		$dd['1']= 'Not Publish';
        $dd['2']= 'Publish';
		
		return $dd;
	}
    function kode_otomatis()
    {
        $query          = FBpage::select(Max('id','1'))->get();
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
