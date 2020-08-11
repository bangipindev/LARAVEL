<?php

namespace App\Http\Controllers\Admin;

use App\JobCategory;
use App\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class JobCategoryController extends Controller
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
        $data['title']				= 'List Kategori Pekerjaan';

        $data['css']                = view('admin.jobskategori.css');            
        $data['js']                 = view('admin.jobskategori.js');             
        $data['script']             = view('admin.jobskategori.scripts');
        return view('admin.jobskategori.list')->with($data);
    }
    public function create()
    {
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['id']				    ='';
        $data['nama']			    ='';
        $data['status']             ='';
        $data['title']              = 'Tambah Kategori Pekerjaan';

        $data['dd_status']		    = $this->dd_status();
        $data['css']                = view('admin.jobskategori.cssform')->with($data);
        $data['js']                 = view('admin.jobskategori.jsform')->with($data);
        $data['script']             = view('admin.jobskategori.scriptsform')->with($data);
        return view('admin.jobskategori.form')->with($data);
    }

    
    public function store(Request $request)
    {
        $data['kategori']			= $request->nama;
        $data['slug']			    = Str::slug($request->nama,'-');
        $data['status']			    = $request->status;
        
        $id						    = $request->id;
        $d						    = JobCategory::where('id','=',$id);

        if ($d->count() > 0){
            JobCategory::where('id','=',$id)->update($data);
            return redirect('/appmaster/jobskategori')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            JobCategory::create($data);
            return redirect('/appmaster/jobskategori')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }

    
    public function edit($id)
    {
        $query 	                    = JobCategory::where('id','=',$id)->get();
        
        if($query->count() > 0){
            
            foreach($query as $db){
                $data['id']			= $id;
                $data['nama']		= $db->kategori;
                $data['status']	    = $db->status;
                
            }
        }
        else{
            $data['id']				= $id;
            $data['nama']		    = '';
            $data['status']	        = '';
            
        }
        
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title'] 				= 'Edit Kategori Pekerjaan';
       
        $data['dd_status']		    = $this->dd_status();
        $data['css']                = view('admin.jobskategori.cssform')->with($data);
        $data['js']                 = view('admin.jobskategori.jsform')->with($data);
        $data['script']             = view('admin.jobskategori.scriptsform')->with($data);
        return view('admin.jobskategori.form')->with($data);
    }
   
    public function destroy(Request $request)
    {
        $id                         = $request['id'];
        $categories                 = JobCategory::find($id);
        $categories->delete();
        return redirect('/appmaster/jobskategori')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }

    public function show()
	{
		$total                      = JobCategory::get()->count();
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = JobCategory::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = JobCategory::orWhere('kategori','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $jobcat) {
			$output['data'][]=
					array(
						$no,
						$jobcat->kategori,
						$jobcat->status =='1'?'<span class="label label-danger">Tidak Aktif</span>':'<span class="label label-success">Aktif</span>',
						"<a class='btn btn-warning btn-sm' type='button' data-toggle='tooltip'  title='Edit'  href=".url('appmaster/jobskategori/'.$jobcat->id.'/edit')."><i class='fa fa-pencil'></i></a>
                         <a href='javascript:void(0);' onclick='hapusid($jobcat->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>
                         "
                    );
		$no++;
		}
		
		$output['draw']             = $draw;
		$output['recordsTotal']     = $total;
		$output['recordsFiltered']  = $total;
		
		echo json_encode($output);

    }
    function dd_status(){
		$dd['1']= 'Not Publish';
        $dd['2']= 'Publish';
		
		return $dd;
	}
}
