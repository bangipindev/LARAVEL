<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Setting;
use App\Category;


class CategoryController extends Controller
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
        $data['title']				= 'List Kategori';

        $data['css']                = view('admin.categories.css');            
        $data['js']                 = view('admin.categories.js');             
        $data['script']             = view('admin.categories.scripts');
        return view('admin.categories.list')->with($data);
    }

    public function create()
    {
        
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title']              = 'Tambah Kategori';
        $data['id']				    ='';
        $data['nama']			    ='';
        $data['status']		        ='';
        $data['parent']		        ='';
        $data['dd_parent']		    = $this->dd_parent();
        $data['dd_status']		    = $this->dd_status();
        $data['css']                = view('admin.categories.cssform')->with($data);
        $data['js']                 = view('admin.categories.jsform')->with($data);
        $data['script']             = view('admin.categories.scriptsform')->with($data);
        return view('admin.categories.form')->with($data);
    }

    
    public function edit($id)
    {
        $query 	                    = Category::where('id','=',$id)->get();
        
        if($query->count() > 0){
            
            foreach($query as $db){
                $data['id']			= $id;
                $data['nama']		= $db->kategori;
                $data['status']	    = $db->status;
                $data['parent']	    = $db->_parent;
                
            }
        }
        else{
            $data['id']				= $id;
            $data['nama']		    = '';
            $data['status']	        = '';
            $data['parent']	        = '';
            
        }
        
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title'] 				= 'Edit Kategori';
        $data['dd_parent']		    = $this->dd_parent();
        $data['dd_status']		    = $this->dd_status();
        $data['css']                = view('admin.categories.cssform')->with($data);
        $data['js']                 = view('admin.categories.jsform')->with($data);
        $data['script']             = view('admin.categories.scriptsform')->with($data);
        return view('admin.categories.form')->with($data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
		
        $data['kategori']			= $request->nama;
        $data['_parent'] 		    = $request->parent;
        $data['_slug'] 		        = Str::slug($request->nama,'-');
        $data['status'] 		    = $request->status;
        
        $id						    = $request->id;
        $d						    = Category::where('id','=',$id);

        if ($d->count() > 0){
            Category::where('id','=',$id)->update($data);
            return redirect('/appmaster/categories')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Category::create($data);
            return redirect('/appmaster/categories')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }

    public function destroy(Request $request)
    {
        $id                         = $request['id'];
        $categories                 = Category::find($id);
        $categories->delete();
        return redirect('/appmaster/categories')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }

    public function show()
	{
		$total                      = Category::get()->count();
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = Category::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = Category::orWhere('kategori','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $categories) {
            $date                   = date('d-m-Y',strtotime($categories->created_at));
            $output['data'][]=
					array(
						$no,
						$categories->kategori,
						$date,
						$categories->status =='1'?'<span class="label label-danger">Tidak Aktif</span>':'<span class="label label-success">Aktif</span>',
						"<a href=".url('appmaster/categories/'.$categories->id.'/edit')." class='btn btn-sm btn-primary btn-editable'><i class='fa fa-pencil'></i> </a>
						<a href='javascript:void(0);' onclick='hapusid($categories->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>",
                    );
		$no++;
		}
		
		$output['draw']             = $draw;
		$output['recordsTotal']     = $total;
		$output['recordsFiltered']  = $total;
		
		echo json_encode($output);

    }
    function dd_status(){
		$dd['']='---Status---';
        $dd['1']= 'Not Publish';
        $dd['2']= 'Publish';
		
		return $dd;
	}
    function dd_parent(){
		$dd['1']= 'Blog';
		return $dd;
	}
}
