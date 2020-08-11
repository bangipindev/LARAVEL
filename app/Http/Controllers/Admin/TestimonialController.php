<?php

namespace App\Http\Controllers\Admin;
use App\Setting;
use App\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TestimonialController extends Controller
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
        $data['title']				= 'List Testimoni Klien';

        $data['css']                = view('admin.testimoni.css');            
        $data['js']                 = view('admin.testimoni.js');             
        $data['script']             = view('admin.testimoni.scripts');
        return view('admin.testimoni.list')->with($data);
    }
    public function create()
    {
        
         $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['id']                 = '';
        $data['namaclient']			= '';
        $data['perusahaan']		    = '';
        $data['image']			    = '';
        $data['testimoni']			= '';
        
        
        $data['title']              = 'Tambah Testimoni';
       
        $data['css']                = view('admin.testimoni.cssform')->with($data);
        $data['js']                 = view('admin.testimoni.jsform')->with($data);
        $data['script']             = view('admin.testimoni.scriptsform')->with($data);
        return view('admin.testimoni.form')->with($data);
    }

    public function edit($id)
    {
        $query 	                    = Testimonial::where('id','=',$id)->get();
        
        if($query->count() > 0){
            
            foreach($query as $db){
                $data['id']			= $id;
                $data['namaclient'] = $db->klien;
                $data['perusahaan']	= $db->perusahaan;
                $data['testimoni']  = $db->testimoni;
                $data['image']	    = $db->gambar;
                
            }
        }
        else{
                $data['id']			= $id;
                $data['namaclient'] = '';
                $data['perusahaan']	= '';
                $data['testimoni']  = '';
                $data['image']	    = '';
            
        }
        
         $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title'] 				= 'Edit Testimoni';

        $data['css']                = view('admin.testimoni.cssform')->with($data);
        $data['js']                 = view('admin.testimoni.jsform')->with($data);
        $data['script']             = view('admin.testimoni.scriptsform')->with($data);
        return view('admin.testimoni.form')->with($data);
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
                'klien'	            => $request->namaclient,
                'perusahaan'		=> $request->perusahaan,
                'testimoni'         => $request->testimoni,
                'gambar'  	        => $filename
            ];
            File::delete(public_path('img/'.$imglama));
            
            $id						= $request->id;
            $d						= Testimonial::where('id','=',$id);
        }
        else {
            $data = [
                'klien'	            => $request->namaclient,
                'perusahaan'		=> $request->perusahaan,
                'testimoni'         => $request->testimoni,
                'gambar'  	        => $imglama
            ];
            $id						= $request['id'];
            $d						= Testimonial::where('id','=',$id);
        }
        
        if ($d->count() > 0){
            Testimonial::where('id','=',$id)->update($data);
            return redirect('/appmaster/testimoni')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Testimonial::create($data);
            return redirect('/appmaster/testimoni')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }

    public function destroy(Request $request)
    {
        $id                         = $request['id'];
        $testimoni                      = Testimonial::find($id);
        File::delete(public_path('img/'.$testimoni->gambar.''));
        $testimoni->delete();
        return redirect('/appmaster/testimoni')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }
   
    public function show()
	{
		$total                      = Testimonial::get()->count();
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = Testimonial::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = Testimonial::orWhere('klien','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $testimoni) {
            if(!empty($testimoni['gambar'])){
				$gambar = "<a href=".url(asset('img/'.$testimoni->gambar.''))." class='fancy-view'>
						   <img src=".url(asset('img/'.$testimoni->gambar.''))." alt='' border='0' class='img-responsive'>";
			}else{
				$gambar = "<a href=".url(asset('img/no-image.png'))." class='fancy-view'>
						  <img src=".url(asset('img/no-image.png'))." class='img-responsive' alt='' border='0'>";
			}
			$output['data'][]=
					array(
						$no,
						$testimoni->klien,
                        $testimoni->perusahaan,
                        Str::limit($testimoni->testimoni,50),
                        $gambar,
                        "<a class='btn btn-warning btn-sm' type='button' data-toggle='tooltip'  title='Edit'  href=".url('appmaster/testimoni/'.$testimoni->id.'/edit')."><i class='fa fa-pencil'></i></a>
                         <a href='javascript:void(0);' onclick='hapusid($testimoni->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>
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
