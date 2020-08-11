<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use App\Modul;

class ModulController extends Controller
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
        $data['title']				= 'List Modul';

        $data['css']                = view('admin.modul.css');            
        $data['js']                 = view('admin.modul.js');             
        $data['script']             = view('admin.modul.scripts');
        return view('admin.modul.list')->with($data);
    }

    public function create()
    {
        
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title']              = 'Tambah Modul';
        $data['id']				    ='';
        $data['nama']			    ='';
        $data['url_modul']		    ='';
        $data['js']                 = view('admin.modul.jsform')->with($data);
        $data['script']             = view('admin.modul.scriptsform')->with($data);
        return view('admin.modul.form')->with($data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
		
        $data['nama']			    = $request->nama;
        $data['url_modul'] 		    = $request->url_modul;
        
        $id						    = $request->id;
        $d						    = Modul::where('id','=',$id);

        if ($d->count() > 0){
            Modul::where('id','=',$id)->update($data);
            return redirect('/appmaster/modul')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Modul::create($data);
            return redirect('/appmaster/modul')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }

    public function edit($id)
    {
        $query 	                    = Modul::where('id','=',$id)->get();
        
        if($query->count() > 0){
            
            foreach($query as $db){
                $data['id']			= $id;
                $data['nama']		= $db->nama;
                $data['url_modul']	= $db->url_modul;
                
            }
        }
        else{
            $data['id']				= $id;
            $data['nama']			= '';
            $data['url_modul']		= '';
            
        }
        
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title'] 				= 'Edit Modul';

        $data['js']                 = view('admin.modul.jsform')->with($data);
        $data['script']             = view('admin.modul.scriptsform')->with($data);
        return view('admin.modul.form')->with($data);
    }

    public function destroy(Request $request)
    {
        $id                         = $request['id'];
        $modul                      = Modul::find($id);
        $modul->delete();
        return redirect('/appmaster/modul')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }

    public function show()
	{
		$total                      = Modul::get()->count();
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = Modul::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = Modul::orWhere('nama','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $mod) {
			$output['data'][]=
					array(
						$no,
						$mod->nama,
						$mod->url_modul,
						"<a class='btn btn-warning btn-sm' type='button' data-toggle='tooltip'  title='Edit'  href=".url('appmaster/modul/'.$mod->id.'/edit')."><i class='fa fa-pencil'></i></a>
                         <a href='javascript:void(0);' onclick='hapusid($mod->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>
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
