<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Setting;
use App\Page;
class PageController extends Controller
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
        $data['title']				= 'List Halaman';

        $data['css']                = view('admin.pages.css');            
        $data['js']                 = view('admin.pages.js');             
        $data['script']             = view('admin.pages.scripts');
        return view('admin.pages.list')->with($data);
    }
    public function create()
    {
        
         $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['id']                 = '';
        $data['pages']			    = '';
        $data['konten']		        = '';
        $data['posisi']			    = '';
        $data['status']			    = '';
        $data['layout']			    = '';
        $data['metakeyword']		= '';
        $data['metadeskripsi']		= '';
       
        
        $data['title']              = 'Tambah Halaman';
        $data['dd_layout']		    = $this->dd_layout();
        $data['dd_status']		    = $this->dd_status();
        $data['css']                = view('admin.pages.cssform')->with($data);
        $data['js']                 = view('admin.pages.jsform')->with($data);
        $data['script']             = view('admin.pages.scriptsform')->with($data);
        return view('admin.pages.form')->with($data);
    }

    public function edit($id)
    {
        $query 	                    = Page::where('id','=',$id)->get();
        
        if($query->count() > 0){
            
        foreach($query as $db){
            $data['id']			    = $id;
            $data['pages']		    = $db->nama_laman;
            $data['konten']	        = $db->konten;
            $data['status']		    = $db->status;
            $data['posisi']	        = $db->posisi;
            $data['layout']	        = $db->layout;
            $data['metakeyword']    = $db->meta_keyword;
            $data['metadeskripsi']	= $db->meta_deskripsi;
                
            }
        }
        else{
            $data['id']			    = $id;
            $data['pages']		    = '';
            $data['konten']	        = '';
            $data['status']		    = '';
            $data['posisi']	        = '';
            $data['layout']	        = '';
            $data['metakeyword']    = '';
            $data['metadeskripsi']	= '';
            
        }
        
         $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title'] 				= 'Edit Halaman';

        $data['dd_layout']		    = $this->dd_layout();
        $data['dd_status']		    = $this->dd_status();
        $data['css']                = view('admin.pages.cssform')->with($data);
        $data['js']                 = view('admin.pages.jsform')->with($data);
        $data['script']             = view('admin.pages.scriptsform')->with($data);
        return view('admin.pages.form')->with($data);
    }

    public function store(Request $request)
    {
        $data['nama_laman']	        = $request['pages'];
        $data['pages_seo']	        = Str::slug($request['pages'],'-');
        $data['konten']	            = $request['konten'];
        $data['status']	            = $request['status'];
        $data['layout']             = $request['layout'];
        $data['meta_keyword']  	    = $request['meta_keyword'];
        $data['meta_deskripsi']  	= $request['meta_deskripsi'];
        $data['posisi']  	        = $request['posisi'];
            
        $id						    = $request->id;
        $d						    = Page::where('id','=',$id);
        
        if ($d->count() > 0){
            Page::where('id','=',$id)->update($data);
            return redirect('/appmaster/pages')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Page::create($data);
            return redirect('/appmaster/pages')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }

    public function destroy(Request $request)
    {
        $id                         = $request['id'];
        $pages                      = Page::find($id);
        $pages->delete();
        return redirect('/appmaster/sliders')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }
   
    public function show()
	{
        $total                      = Page::get()->count();
        
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = Page::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = Page::orWhere('nama_laman','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $pages) {
            $output['data'][]=
					array(
						$no,
						$pages->nama_laman,
						$pages->pages_seo,
						$pages->status =='1'?'<span class="label label-danger">Tidak Aktif</span>':'<span class="label label-success">Aktif</span>',
						$pages->posisi,
						$pages->layout,
						"<a href=".url('appmaster/pages/'.$pages->id.'/edit')." class='btn btn-sm btn-primary btn-editable'><i class='fa fa-pencil'></i> </a>
						<a href='javascript:void(0);' onclick='hapusid($pages->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>",
                    );
		$no++;
		}
		
		$output['draw']             = $draw;
		$output['recordsTotal']     = $total;
		$output['recordsFiltered']  = $total;
		
		echo json_encode($output);

    }
    
    function dd_layout(){
        // $dd['page_with_sidebar']	= 'Page With Sidebar';
        $dd['fullwidth']			= 'Full Width';
        return $dd;
    }
    
    function dd_status(){
		$dd['']='---Status---';
        $dd['1']= 'Not Publish';
        $dd['2']= 'Publish';
		
		return $dd;
	}
}
