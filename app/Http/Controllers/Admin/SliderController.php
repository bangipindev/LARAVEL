<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Setting;
use App\Slider;
use Illuminate\Support\Facades\File;
class SliderController extends Controller
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
        $data['title']				= 'List Slider';

        $data['css']                = view('admin.slider.css');            
        $data['js']                 = view('admin.slider.js');             
        $data['script']             = view('admin.slider.scripts');
        return view('admin.slider.list')->with($data);
    }
    public function create()
    {
        
         $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['id']                 = '';
        $data['name']			    = '';
        $data['deskripsi']		    = '';
        $data['image']			    = '';
        $data['link']			    = '';
        $data['textlink']		    = '';
        $data['status']		        = '';
        $data['type']			    = '';
        $data['posisi']		        = '';
        
        $data['title']              = 'Tambah Slide';
        $data['dd_type']		    = $this->dd_type();
        $data['dd_status']		    = $this->dd_status();
        $data['css']                = view('admin.slider.cssform')->with($data);
        $data['js']                 = view('admin.slider.jsform')->with($data);
        $data['script']             = view('admin.slider.scriptsform')->with($data);
        return view('admin.slider.form')->with($data);
    }

    public function edit($id)
    {
        $query 	                    = Slider::where('id','=',$id)->get();
        
        if($query->count() > 0){
            
            foreach($query as $db){
                $data['id']			= $id;
                $data['name']		= $db->judul;
                $data['deskripsi']	= $db->deskripsi;
                $data['link']		= $db->link;
                $data['textlink']	= $db->textlink;
                $data['status']	    = $db->status;
                $data['posisi']		= $db->posisi;
                $data['type']		= $db->tipe;
                $data['image']	    = $db->gambar;
                
            }
        }
        else{
                $data['id']			= $id;
                $data['name']		= '';
                $data['deskripsi']	= '';
                $data['link']		= '';
                $data['textlink']	= '';
                $data['status']	    = '';
                $data['posisi']		= '';
                $data['type']		= '';
                $data['image']	    = '';
            
        }
        
         $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title'] 				= 'Edit Slider';

        $data['dd_type']		    = $this->dd_type();
        $data['dd_status']		    = $this->dd_status();
        $data['css']                = view('admin.slider.cssform')->with($data);
        $data['js']                 = view('admin.slider.jsform')->with($data);
        $data['script']             = view('admin.slider.scriptsform')->with($data);
        return view('admin.slider.form')->with($data);
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
                'judul'	            => $request['name'],
                'deskripsi'			=> $request['deskripsi'],
                'gambar'            => $filename,
                'link'	            => $request['link'],
                'textlink'	        => $request['textbutton'],
                'status'            => $request['status'],
                'tipe'  	        => $request['type'],
                'posisi'  	        => $request['posisi']
            ];
            File::delete(public_path('img/'.$imglama));
            
            $id						= $request->id;
            $d						= Slider::where('id','=',$id);
        }
        else {
            $data = [
                'judul'	            => $request['name'],
                'deskripsi'			=> $request['deskripsi'],
                'link'	            => $request['link'],
                'textlink'	        => $request['textbutton'],
                'status'            => $request['status'],
                'tipe'  	        => $request['type'],
                'posisi'  	        => $request['posisi'],
                'gambar'            => $imglama
            ];
            $id						= $request['id'];
            $d						= Slider::where('id','=',$id);
        }
        
        if ($d->count() > 0){
            Slider::where('id','=',$id)->update($data);
            return redirect('/appmaster/sliders')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Slider::create($data);
            return redirect('/appmaster/sliders')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }

    public function destroy(Request $request)
    {
        $id                         = $request['id'];
        $slide                      = Slider::find($id);
        File::delete(public_path('img/'.$slide->gambar.''));
        $slide->delete();
        return redirect('/appmaster/sliders')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }
   
    public function show()
	{
		$total                      = Slider::get()->count();
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = Slider::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = Slider::orWhere('nama','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $slide) {
            if(!empty($slide['gambar'])){
				$gambar = "<a href=".url(asset('img/'.$slide->gambar.''))." class='fancy-view'>
						   <img src=".url(asset('img/'.$slide->gambar.''))." alt='' border='0' class='img-responsive'>";
			}else{
				$gambar = "<a href=".url(asset('img/no-image.png'))." class='fancy-view'>
						  <img src=".url(asset('img/no-image.png'))." class='img-responsive' alt='' border='0'>";
            }
            
			$output['data'][]=
					array(
						$no,
						$slide->judul,
                        $slide->deskripsi,
                        $slide->tipe =='1'?'<span class="label label-success">Top</span>':'<span class="label label-info">Bottom</span>',
						$slide->status =='1'?'<span class="label label-danger">Not Publish</span>':'<span class="label label-info">Publish</span>',
                        $gambar,
                        "<a class='btn btn-warning btn-sm' type='button' data-toggle='tooltip'  title='Edit'  href=".url('appmaster/sliders/'.$slide->id.'/edit')."><i class='fa fa-pencil'></i></a>
                         <a href='javascript:void(0);' onclick='hapusid($slide->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>
                         "
                    );
		$no++;
		}
		
		$output['draw']             = $draw;
		$output['recordsTotal']     = $total;
		$output['recordsFiltered']  = $total;
		
		echo json_encode($output);

    }
    function dd_type(){
		$dd['']='---Type---';
		$dd['1']= 'Top';
		return $dd;
    }
    function dd_status(){
		$dd['']='---Status---';
        $dd['1']= 'Not Publish';
        $dd['2']= 'Publish';
		
		return $dd;
	}
}
