<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data['title']              = 'Konfigurasi Website'; 

        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        if(empty($setting['id'])){
            $data['id']				= $this->kode_otomatis();
        }
        else{
            $data['id']				= 1;
        }
        
        $data['nama']				= $setting['nama'];
        $data['slog']				= $setting['slogan'];
        $data['deskripsi']          = $setting['deskripsi_situs'];
        $data['telp']		    	= $setting['telepon'];
        $data['almt']				= $setting['alamat'];
        $data['email']		        = $setting['email_website'];
        $data['owner']			    = $setting['pemilik'];
        $data['web']			    = $setting['website'];
        $data['mekeyword']		    = $setting['meta_keyword'];
        $data['medeskripsi']		= $setting['meta_deskripsi'];
        $data['fvc']				= $setting['favicon'];
        $data['facebook']			= $setting['facebook'];
        $data['twitter']			= $setting['twitter'];
        $data['instagram']			= $setting['instagram'];
        $data['linkedin']			= $setting['linkedin'];
        $data['youtube']			= $setting['youtube'];
        $data['css']                = view('admin.setting.cssform');            
        $data['js']                 = view('admin.setting.jsform');             
        $data['script']             = view('admin.setting.scripts');             
        return view('admin.setting.list')->with($data);
    }

    public function store (Request $request){
        $request->validate([
            'favicon' => 'mimes:png|max:1024',
        ]);

        $file                       = $request->file('favicon');
        $imglama	                = $request->faviconlama;

        if($file){
            $filename               = $file->getClientOriginalName();
            $path                   = public_path('img');
            $file->move($path,$filename);
            $data = [
                'nama'              => $request['nama'],
                'slogan'            => $request['slogan'],
                'deskripsi_situs'   => $request['deskripsi_situs'],
                'telepon'           => $request['telepon'],
                'alamat'            => $request['alamat'],
                'email_website'     => $request['email_website'],
                'pemilik'           => $request['pemilik'],
                'website'           => $request['website'],
                'meta_keyword'      => $request['meta_keyword'],
                'meta_deskripsi'    => $request['meta_deskripsi'],
                'facebook'          => $request['facebook'],
                'twitter'           => $request['twitter'],
                'instagram'         => $request['instagram'],
                'linkedin'          => $request['linkedin'],
                'youtube'           => $request['youtube'],
                'favicon'           => $filename
            ];
            $id                     = $request['id'];
            $d                      = Setting::where('id_config','=',$id);

        }
        else {
            $data = [
                'nama'              => $request['nama'],
                'slogan'            => $request['slogan'],
                'deskripsi_situs'   => $request['deskripsi_situs'],
                'telepon'           => $request['telepon'],
                'alamat'            => $request['alamat'],
                'email_website'     => $request['email_website'],
                'pemilik'           => $request['pemilik'],
                'website'           => $request['website'],
                'meta_keyword'      => $request['meta_keyword'],
                'meta_deskripsi'    => $request['meta_deskripsi'],
                'facebook'          => $request['facebook'],
                'twitter'           => $request['twitter'],
                'instagram'         => $request['instagram'],
                'linkedin'          => $request['linkedin'],
                'youtube'           => $request['youtube'],
                'favicon'           => $imglama
            ];
            $id                     = $request['id'];
            $d                      = Setting::where('id_config','=',$id);
        }
     
        if ($d->count() > 0){
            Setting::where('id_config','=',$id)->update($data);
            return redirect('/appmaster/config')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Setting::create($data);
            return redirect('/appmaster/config')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
      
    }

    public function logo() 
	{
        $data['title']				= 'Logo';
        
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];

        $data['id'] 				= 1;
        $data['lg']					= $setting['logo'];
        
        $data['css']                = view('admin.setting.cssform');            
        $data['js']                 = view('admin.setting.jsform');             
        $data['script']             = view('admin.setting.scripts');  
        return view('admin.setting.logo')->with($data);
        
    }
    
    public function update(Request $request){
        $request->validate([
            'logo' => 'mimes:png|max:1024',
        ]);
        $id                         = $request->id;
        $file                       = $request->file('logo');
        $imglama	                = $request->logolama;

        if($file){
            $filename               = $file->getClientOriginalName();
            $path                   = public_path('img');
            $file->move($path,$filename);
            $data = [
                'logo'              => $filename
            ];
           
        }
        else {
            $data = [
                'logo'              => $imglama
            ];
           
        }
        Setting::where('id_config','=',$id)->update($data);
        return redirect('/appmaster/config/logo')->with('SUCCESSMSG','Data Berhasil di Update');
    }
    function kode_otomatis()
    {
        $query          = Setting::select(Max('id_config','1'))->get();
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
