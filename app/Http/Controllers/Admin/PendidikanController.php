<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Setting;

class PendidikanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        $data['title']				= 'List Level Pendidikan';
        
        $data['css']                = view('admin.pendidikan.css');            
        $data['js']                 = view('admin.pendidikan.js');             
        $data['script']             = view('admin.pendidikan.scripts');
        return view('admin.pendidikan.list')->with($data);
    }

    public function create()
    {
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['id']                 = '';
        $data['pendidikan']			= '';
        
        $data['title']              = 'Tambah Level Pendidikan';
        
        $data['css']                = view('admin.pendidikan.cssform')->with($data);
        $data['js']                 = view('admin.pendidikan.jsform')->with($data);
        $data['script']             = view('admin.pendidikan.scriptsform')->with($data);
        return view('admin.pendidikan.form')->with($data);
    }

    public function store(Request $request)
    {
        $data = [
            'pendidikan'	        => $request->pendidikan,
            'slug'                  => Str::slug($request->pendidikan,'-')
            ];
        $id						    = $request->id;
        $d						    = Pendidikan::where('id','=',$id);
        
        if ($d->count() > 0){
            Pendidikan::where('id','=',$id)->update($data);
            return redirect('/appmaster/pendidikan')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Pendidikan::create($data);
            return redirect('/appmaster/pendidikan')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }

    public function edit($id)
    {
        $query 	                    = Pendidikan::where('id','=',$id)->get();
        
        if($query->count() > 0){
            
        foreach($query as $db){
            $data['id']			    = $id;
            $data['pendidikan']		= $db->pendidikan;
                
            }
        }
        else{
            $data['id']			    = $id;
            $data['pendidikan']	    = '';
            
        }
        
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title'] 				= 'Edit Level Pendidikan';

        $data['css']                = view('admin.pendidikan.cssform')->with($data);
        $data['js']                 = view('admin.pendidikan.jsform')->with($data);
        $data['script']             = view('admin.pendidikan.scriptsform')->with($data);
        return view('admin.pendidikan.form')->with($data);
    }

    public function destroy(Request $request)
    {
        $id                         = $request['id'];
        $tags                       = Pendidikan::find($id);
        $tags->delete();
        return redirect('/appmaster/pendidikan')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }

    public function show()
	{
        $total                      = Pendidikan::get()->count();
        
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = Pendidikan::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = Pendidikan::orWhere('pendidikan','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $pdk) {
            $output['data'][]=
					array(
						$no,
						$pdk->pendidikan,
						"<a href=".url('appmaster/pendidikan/'.$pdk->id.'/edit')." class='btn btn-sm btn-primary btn-editable'><i class='fa fa-pencil'></i> </a>
						<a href='javascript:void(0);' onclick='hapusid($pdk->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>",
                    );
		$no++;
		}
		
		$output['draw']             = $draw;
		$output['recordsTotal']     = $total;
		$output['recordsFiltered']  = $total;
		
		echo json_encode($output);

    }
}
