<?php

namespace App\Http\Controllers\Admin;

use App\About;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data['title']              = 'Tentang Kami'; 

        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $about                      = About::find(1);
     
        if(empty($about['id'])){
            $data['id']				= $this->kode_otomatis();
        }
        else{
            $data['id']				= 1;
        }
        $data['deskripsi1']		    = $about['konten1'];
        $data['deskripsi2']			= $about['konten2'];
        $data['judul1']				= $about['judul1'];
        $data['judul2']				= $about['judul2'];
        $data['judul3']			    = $about['judul3'];
        $data['text1']		        = $about['teks1'];
        $data['text2']		        = $about['teks2'];
        $data['text3']		        = $about['teks3'];
        $data['meta_keyword']		= $about['meta_keyword'];
        $data['meta_deskripsi']		= $about['meta_deskripsi'];
        $data['image']		        = $about['gambar'];
       
        $data['css']                = view('admin.about.css');            
        $data['js']                 = view('admin.about.js');             
        $data['script']             = view('admin.about.scripts');             
        return view('admin.about.form')->with($data);
    }

    public function store (Request $request){
    
        date_default_timezone_set('Asia/Jakarta');
        $request->validate([
            'image'                 => 'mimes:png,jpg|max:2048',
        ]);
        $file                       = $request->file('image');
        $imglama	                = $request->imagelama;
        if ($file) {
            $filename               = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $path                   = public_path('img');
            $file->move($path, $filename);
            $data['konten1']		=  $request->deskripsi1;
            $data['konten2']		=  $request->deskripsi2;
            $data['judul1']			=  $request->judul1;
            $data['judul2']			=  $request->judul2;
            $data['judul3']			=  $request->judul3;
            $data['teks1']		    =  $request->text1;
            $data['teks2']		    =  $request->text2;
            $data['teks3']		    =  $request->text3;
            $data['meta_keyword']	=  $request->meta_keyword;
            $data['meta_deskripsi'] =  $request->meta_deskripsi;
            $data['gambar']		    =  $filename;
        
            File::delete(public_path('img/'.$imglama));
           
            $id                     = $request->id;
            $d                      = About::where('id','=',$id);
        }
        else{
            $data['konten1']		=  $request->deskripsi1;
            $data['konten2']		=  $request->deskripsi1;
            $data['judul1']			=  $request->judul1;
            $data['judul2']			=  $request->judul2;
            $data['judul3']			=  $request->judul3;
            $data['teks1']		    =  $request->text1;
            $data['teks2']		    =  $request->text2;
            $data['teks3']		    =  $request->text3;
            $data['meta_keyword']	=  $request->meta_keyword;
            $data['meta_deskripsi']	=  $request->meta_deskripsi;
            $data['gambar']		    =  $imglama;
            
            $id                         = $request->id;
            $d                          = About::where('id','=',$id);
        }
        if ($d->count() > 0){
            About::where('id','=',$id)->update($data);
            return redirect('/appmaster/abouts')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            About::create($data);
            return redirect('/appmaster/abouts')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
      
    }
    function dd_status(){
		$dd['1']= 'Not Publish';
        $dd['2']= 'Publish';
		
		return $dd;
	}
    function kode_otomatis()
    {
        $query          = About::select(Max('id','1'))->get();
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
