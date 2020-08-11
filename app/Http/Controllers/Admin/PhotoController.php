<?php

namespace App\Http\Controllers\Admin;

use App\Photo;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
         $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        $data['title']				= 'List Galeri';

        $data['css']                = view('admin.galeri.css');            
        $data['js']                 = view('admin.galeri.js');             
        $data['script']             = view('admin.galeri.scripts');
        return view('admin.galeri.list')->with($data);
    }
    public function create()
    {
        
         $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['id']                 = '';
        $data['judul']			    = '';
        $data['image']			    = '';
        
        $data['title']              = 'Tambah Koleksi';
        $data['css']                = view('admin.galeri.cssform')->with($data);
        $data['js']                 = view('admin.galeri.jsform')->with($data);
        $data['script']             = view('admin.galeri.scriptsform')->with($data);
        return view('admin.galeri.form')->with($data);
    }

    public function edit($id)
    {
        $query 	                    = Photo::where('id','=',$id)->get();
        
        if($query->count() > 0){
            
            foreach($query as $db){
                $data['id']			= $id;
                $data['judul']		= $db->judul;
                $data['image']	    = $db->gambar;
                
            }
        }
        else{
                $data['id']			= $id;
                $data['judul']		= '';
                $data['image']	    = '';
            
        }
        
         $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title'] 				= 'Edit Koleksi Photo';

        $data['css']                = view('admin.galeri.cssform')->with($data);
        $data['js']                 = view('admin.galeri.jsform')->with($data);
        $data['script']             = view('admin.galeri.scriptsform')->with($data);
        return view('admin.galeri.form')->with($data);
    }
    public function store(Request $request)
    {
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
            $data = [
                'judul'	            => $request->judul,
                'gambar'            => $filename,
            ];
            File::delete(public_path('img/'.$imglama));
            
            $id						= $request->id;
            $d						= Photo::where('id','=',$id);
        }
        else {
            $data = [
                'judul'	            => $request->judul,
                'gambar'            => $imglama
            ];
            $id						= $request['id'];
            $d						= Photo::where('id','=',$id);
        }
        
        if ($d->count() > 0){
            Photo::where('id','=',$id)->update($data);
            return redirect('/appmaster/gallery')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Photo::create($data);
            return redirect('/appmaster/gallery')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }

    public function destroy(Request $request)
    {
        $id                         = $request['id'];
        $slide                      = Photo::find($id);
        File::delete(public_path('img/'.$slide->gambar.''));
        $slide->delete();
        return redirect('/appmaster/gallery')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }
   
    public function show()
	{
		$total                      = Photo::get()->count();
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = Photo::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = Photo::orWhere('judul','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $photo) {
            if(!empty($photo['gambar'])){
				$gambar = "<a href=".url(asset('img/'.$photo->gambar.''))." class='fancy-view'>
						   <img src=".url(asset('img/'.$photo->gambar.''))." alt='' border='0' class='img-responsive'>";
			}else{
				$gambar = "<a href=".url(asset('img/no-image.png'))." class='fancy-view'>
						  <img src=".url(asset('img/no-image.png'))." class='img-responsive' alt='' border='0'>";
			}
			$output['data'][]=
					array(
						$no,
						$photo->judul,
                        $gambar,
                        "<a class='btn btn-warning btn-sm' type='button' data-toggle='tooltip'  title='Edit'  href=".url('appmaster/gallery/'.$photo->id.'/edit')."><i class='fa fa-pencil'></i></a>
                         <a href='javascript:void(0);' onclick='hapusid($photo->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>
                         "
                    );
		$no++;
		}
		
		$output['draw']             = $draw;
		$output['recordsTotal']     = $total;
		$output['recordsFiltered']  = $total;
		
		echo json_encode($output);

    }
    
}
