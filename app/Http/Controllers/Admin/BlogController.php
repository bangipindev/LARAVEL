<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Setting;
use App\Blog;
use App\Category;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
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

        $data['css']                = view('admin.blogs.css');            
        $data['js']                 = view('admin.blogs.js');             
        $data['script']             = view('admin.blogs.scripts');
        return view('admin.blogs.list')->with($data);
    }
    public function create()
    {
        
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['id']                 = '';
        $data['judul_blog']			= '';
        $data['kategori']			= '';
		$data['isi_blog']		    = '';
        $data['status']			    = '';
        $data['image']				= '';
        $data['tags']				= '';
        $data['meta_deskripsi']	    = '';
        $data['meta_keyword']		= '';
       
        
        $data['title']              = 'Tambah Artikel';
        $data['dd_status']		    = $this->dd_status();
        $data['dd_tag']			    = $this->dd_tag();
        $data['dd_kategori']        = $this->dd_kategori();
        $data['css']                = view('admin.blogs.cssform')->with($data);
        $data['js']                 = view('admin.blogs.jsform')->with($data);
        $data['script']             = view('admin.blogs.scriptsform')->with($data);
        return view('admin.blogs.form')->with($data);
    }

    public function edit($id)
    {
        $query 	                    = Blog::where('id','=',$id)->get();
        
        if($query->count() > 0){
            
        foreach($query as $db){
            $tagar 					= explode(',',$db->tag);
            $data['dd_tag']			= $this->dd_tag();
            $data['id']			    = $id;
            $data['judul_blog']		= $db->judul;
            $data['kategori']		= $db->kategori;
            $data['isi_blog']		= $db->konten;
            $data['status']	        = $db->status;
            $data['image']	        = $db->gambar;
            $data['tags']			= $tagar;
            $data['meta_keyword']   = $db->meta_keyword;
            $data['meta_deskripsi']	= $db->meta_deskripsi;
                
            }
        }
        else{
            $data['id']			    = $id;
            $data['judul_blog']		= '';
            $data['kategori']		= '';
            $data['isi_blog']		= '';
            $data['status']	        = '';
            $data['image']	        = '';
            $data['tags']			= '';
            $data['meta_keyword']   = '';
            $data['meta_deskripsi']	= '';
            
        }
        
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title'] 				= 'Edit Artikel';

        $data['dd_status']		    = $this->dd_status();
        $data['dd_tag']			    = $this->dd_tag();
        $data['dd_kategori']        = $this->dd_kategori();
        $data['css']                = view('admin.blogs.cssform')->with($data);
        $data['js']                 = view('admin.blogs.jsform')->with($data);
        $data['script']             = view('admin.blogs.scriptsform')->with($data);
        return view('admin.blogs.form')->with($data);
    }

    public function store(Request $request)
    {
        $tag 			            = $request['tags'];
        if(!empty($tag)){
            $tag_id                 = implode(",", $tag);
        }else{
            $tag_id                 = '';
        }
        
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
                'judul'	            => $request->judul_blog,
                'slug'              => Str::slug($request->judul_blog,'-'),
                'kategori'          => $request->kategori,
                'konten'			=> $request->isi_blog,
                'gambar'            => $filename,
                'penulis'           => Auth::user()->name,
                'status'	        => $request->status,
                'tag'	            => $tag_id,
                'meta_keyword'  	=> $request->meta_keyword,
                'meta_deskripsi'    => $request->meta_deskripsi
            ];
            File::delete(public_path('img/'.$imglama));
            $id						= $request->id;
            $d						= Blog::where('id','=',$id);
        }
        else{
            $data = [
                'judul'	            => $request->judul_blog,
                'slug'              => Str::slug($request->judul_blog,'-'),
                'kategori'          => $request->kategori,
                'konten'			=> $request->isi_blog,
                'gambar'            => $imglama,
                'penulis'           => Auth::user()->name,
                'status'	        => $request->status,
                'tag'	            => $tag_id,
                'meta_keyword'  	=> $request->meta_keyword,
                'meta_deskripsi'    => $request->meta_deskripsi
            ];
            $id						= $request->id;
            $d						= Blog::where('id','=',$id);
        }
        if ($d->count() > 0){
            Blog::where('id','=',$id)->update($data);
            return redirect('/appmaster/articles')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Blog::create($data);
            return redirect('/appmaster/articles')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }

    public function destroy(Request $request)
    {
        $id                         = $request['id'];
        $articles                   = Blog::find($id);
        File::delete(public_path('img/'.$articles->gambar.''));
        $articles->delete();
        return redirect('/appmaster/sliders')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }
   
    public function show()
	{
		$total                      = Blog::get()->count();
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = Blog::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = Blog::orWhere('judul','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $blog) {
            if(!empty($blog->gambar)){
				$gambar = "<a href=".url(asset('img/'.$blog->gambar.''))." class='fancy-view'>
						   <img src=".url(asset('img/'.$blog->gambar.''))." alt='' border='0' class='img-responsive'>";
			}else{
				$gambar = "<a href=".url(asset('img/no-image.png'))." class='fancy-view'>
						  <img src=".url(asset('img/no-image.png'))." class='img-responsive' alt='' border='0'>";
            }
            if($blog->status== 2){
				$status = "<span class='label label-primary'>Aktif</span>";
			}else{
				$status = "<span class='label label-warning'>Tidak Aktif</span>";
            }
            date_default_timezone_set('Asia/Jakarta');
			$date       = date('d-m-Y',strtotime($blog->created_at));
            $output['data'][]=
					array(
						$no,
						$blog->judul,
						$blog->penulis,
						$status,
						$date,
						$blog->hits,
						$gambar,
                        "<a class='btn btn-warning btn-sm' type='button' data-toggle='tooltip'  title='Edit'  href=".url('appmaster/articles/'.$blog->id.'/edit')."><i class='fa fa-pencil'></i></a>
                        <a href='javascript:void(0);' onclick='hapusid($blog->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>
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
    function dd_tag(){
		$query                      = Tag::orderBy('id','ASC')->get();
        $dd                         =array();
        if ($query->count() > 0){
            foreach($query as $row){
                $dd[$row->id] = $row->tag;
            }
        }
		return $dd;
	}
    function dd_kategori(){
		$query                      = Category::where('_parent','=','1')->orderBy('id','ASC')->get();
        $dd['']                     = '---Pilih---';
        if ($query->count() > 0){
            foreach($query as $row){
                $dd[$row->_slug] = $row->kategori;
            }
        }
		return $dd;
    }
    
}
