<?php

namespace App\Http\Controllers\Admin;

use App\Landingpage;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LandingpageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index() 
	{
			
			$data['title']				= 'Landingpage Home';
            $setting                    = Setting::find(1);
            $data['logo']				= $setting['logo'];
            $data['situs']				= $setting['nama'];
            $data['favicon']			= $setting['favicon'];
            $data['author']				= $setting['pemilik'];
            
            $landing					= Landingpage::find(1);
			
			if(empty($landing['id'])){
				$data['id']				= $this->kode_otomatis();
			}
			else{
				$data['id']				= 1;
			}
			$data['judul']				= $landing['judul'];
			$data['deskripsi']			= $landing['deskripsi'];
			$data['link']				= $landing['link'];
			$data['textlink']			= $landing['text_link'];
			
			$data['css']                = view('admin.landingpage.css');            
            $data['js']                 = view('admin.landingpage.js');             
  
			
			return view('admin.landingpage.home')->with($data);
			
	}
	public function fitur() 
	{
			
			$data['title']				= 'Landing Page Fitur';
			
			$setting                    = Setting::find(1);
            $data['logo']				= $setting['logo'];
            $data['situs']				= $setting['nama'];
            $data['favicon']			= $setting['favicon'];
            $data['author']				= $setting['pemilik']; 
            
            $landing					= Landingpage::find(1);
			
			if(empty($landing['id'])){
				$data['id']				= $this->kode_otomatis();
			}
			else{
				$data['id']				= 1;
			}
			
			$data['judulfitur1']		= $landing['judulfitur1'];
			$data['judulfitur2']		= $landing['judulfitur2'];
			$data['judulfitur3']		= $landing['judulfitur3'];
			$data['konten1']			= $landing['konten1'];
			$data['konten2']			= $landing['konten2'];
			$data['konten3']			= $landing['konten3'];
			
			$data['css']                = view('admin.landingpage.css');            
            $data['js']                 = view('admin.landingpage.js');             
			
			return view('admin.landingpage.features')->with($data);
			
    }
    public function home(Request $request){
        
        $data['judul'] 			= $request->judul;
        $data['deskripsi'] 		= $request->deskripsi;
        $data['link'] 			= $request->link;
        $data['text_link'] 		= $request->textlink;
            
        $id						= $request->id;
        $d						= Landingpage::where('id','=',$id);

        if ($d->count() > 0){
            Landingpage::where('id','=',$id)->update($data);
            return redirect('/appmaster/linkhome')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Landingpage::create($data);
            return redirect('/appmaster/linkhome')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }
    public function update(Request $request){
        
        $data['judulfitur1']    = $request->judulfitur1;
        $data['konten1'] 	    = $request->konten1;
       
        $data['judulfitur2']    = $request->judulfitur2;
        $data['konten2'] 	    = $request->konten2;
       
        $data['judulfitur3']    = $request->judulfitur3;
        $data['konten3'] 	    = $request->konten3;
            
        $id						= $request->id;
        $d						= Landingpage::where('id','=',$id);

        if ($d->count() > 0){
            Landingpage::where('id','=',$id)->update($data);
            return redirect('/appmaster/linkfeatures')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Landingpage::create($data);
            return redirect('/appmaster/linkfeatures')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }

    function kode_otomatis()
    {
        $query          = Landingpage::select(Max('id','1'))->get();
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
