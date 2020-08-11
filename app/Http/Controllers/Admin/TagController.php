<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Setting;
use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
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
        $data['title']				= 'List Tag';

        $data['css']                = view('admin.tag.css');            
        $data['js']                 = view('admin.tag.js');             
        $data['script']             = view('admin.tag.scripts');
        return view('admin.tag.list')->with($data);
    }
    public function create()
    {
        
         $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['id']                 = '';
        $data['tags']			    = '';
        
        $data['title']              = 'Tambah Tag';
        
        $data['css']                = view('admin.tag.cssform')->with($data);
        $data['js']                 = view('admin.tag.jsform')->with($data);
        $data['script']             = view('admin.tag.scriptsform')->with($data);
        return view('admin.tag.form')->with($data);
    }

    public function edit($id)
    {
        $query 	                    = Tag::where('id','=',$id)->get();
        
        if($query->count() > 0){
            
        foreach($query as $db){
            $data['id']			    = $id;
            $data['tags']		    = $db->tag;
                
            }
        }
        else{
            $data['id']			    = $id;
            $data['tags']		    = '';
            
        }
        
         $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title'] 				= 'Edit Tag';

        $data['css']                = view('admin.tag.cssform')->with($data);
        $data['js']                 = view('admin.tag.jsform')->with($data);
        $data['script']             = view('admin.tag.scriptsform')->with($data);
        return view('admin.tag.form')->with($data);
    }

    public function store(Request $request)
    {
        $data = [
            'tag'	                => $request->tags,
            'tag_slug'              => Str::slug($request->tags,'-')
            ];
        $id						    = $request->id;
        $d						    = Tag::where('id','=',$id);
        
        if ($d->count() > 0){
            Tag::where('id','=',$id)->update($data);
            return redirect('/appmaster/tags')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Tag::create($data);
            return redirect('/appmaster/tags')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }

    public function destroy(Request $request)
    {
        $id                         = $request['id'];
        $tags                       = Tag::find($id);
        $tags->delete();
        return redirect('/appmaster/tags')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }
   
    public function show()
	{
		$total                      = Tag::get()->count();
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = Tag::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = Tag::orWhere('tag','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $tag) {
           $output['data'][]=
					array(
						$no,
						$tag->tag,
						$tag->tag_slug,
			            "<a class='btn btn-warning btn-sm' type='button' data-toggle='tooltip'  title='Edit'  href=".url('appmaster/tags/'.$tag->id.'/edit')."><i class='fa fa-pencil'></i></a>
                        <a href='javascript:void(0);' onclick='hapusid($tag->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>
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
