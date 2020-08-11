<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
	{
        $data['title']			    = "Kotak Komentar";
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];

        $data['css']                = view('admin.comments.css');            
        $data['js']                 = view('admin.comments.js');             
        $data['script']             = view('admin.comments.script');
        
        return view('admin.comments.list')->with($data);
        
    }
    public function showsent()
	{	
			
        $data['datakomentar'] 		= Comment::where('status','=','1')->orderBy('created_at','DESC')->get();
        return view('admin.comments.sent')->with($data);
			
	}
    public function showKomentar(){	
        
        $data['datakomentar'] 		= Comment::where('status','=','0')->orderBy('id','DESC')->get();
        return view('admin.comments.komentar')->with($data);
			
    }
    public function showtrash()
	{	
			
		$data['datakomentar'] 		= Comment::where('status','=','3')->orderBy('id','DESC')->get();
        return view('admin.comments.trash')->with($data);
	}
    public function viewkomentar(Request $request)
	{	
		$id                         = $request->message_id;
		$data['viewkomentar'] 		= Comment::where('id','=',$id)->get();
		$this->updateKomentar($id);
        return view('admin.comments.viewkomentar')->with($data);
    }
    public function balas(Request $request)
	{	
		$id                         = $request->messageid;
		$data['viewkomentar'] 		= Comment::where('id','=',$id)->get();
		return view('admin.comments.reply')->with($data);
    }
    public function send(Request $request){
		
        $nama					= "Admin";
        $email					= Auth::user()->email;
        $blogid					= $request->blogid;
        $commentid				= $request->commentid; 
        $indukid				= $request->indukid; 
        $review					= $request->review; 
        
        $d['username']			= strip_tags($nama);
        $d['email']				= strip_tags($email);
        $d['komentar']			= htmlentities(strip_tags($review));
        $d['blogid']			= htmlentities(strip_tags($blogid));
        $d['komentarid']		= htmlentities(strip_tags($commentid));
        $d['status']			= 1;
        $d['disetujui']			= 1;
        $d['dibaca']			= 1;
        
        $r['username']			= strip_tags($nama);
        $r['email']				= strip_tags($email);
        $r['komentar']			= htmlentities(strip_tags($review));
        $r['blogid']			= htmlentities(strip_tags($blogid));
        $r['komentarid']		= htmlentities(strip_tags($indukid));
        $r['status']			= 1;
        $d['disetujui']			= 1;
        $d['dibaca']			= 1;
        
        $cek                    = Comment::where('id','=',$commentid)->count();
        if($cek == TRUE ) {
            Comment::create($d);
        }
        else {
            Comment::create($r);
        }
        return redirect('/appmaster/comments')->with('SUCCESSMSG','berhasil membalas komentar');
    
	}
    public function updateKomentar($id){
        $query          = "UPDATE comments";
        $query_parent   = " SET dibaca = 1";
        $query_ids      = " WHERE id =$id";
        DB::update($query.$query_parent.$query_ids);
        
    }
    public function approve($id) 
	{
        $query          = "UPDATE comments";
        $query_parent   = " SET disetujui = 1";
        $query_ids      = " WHERE id =$id";
        DB::update($query.$query_parent.$query_ids);
        return redirect ('appmaster/comments')->with('SUCCESSMSG','Komentar Di setujui');
    
	}
    public function trash($id) 
	{
        $query          = "UPDATE comments";
        $query_parent   = " SET status = 3";
        $query_ids      = " WHERE id =$id";
        DB::update($query.$query_parent.$query_ids);
        return redirect ('appmaster/comments')->with('SUCCESSMSG','Komentar Di Buang');
    
	}
    public function primary($id) 
	{
        $query          = "UPDATE comments";
        $query_parent   = " SET status = 0";
        $query_ids      = " WHERE id =$id";
        DB::update($query.$query_parent.$query_ids);
        return redirect ('appmaster/comments')->with('SUCCESSMSG','Komentar Di Tampilkan');
    
	}

    public function destroy($id){
        $komentar       = Comment::find($id);
        $komentar->delete();
        $komentarid     =Comment::where('komentarid','=',$id);
        $komentarid->delete();
        return redirect ('appmaster/comments')->with('SUCCESSMSG','Komentar Di Hapus');
    
	}
}
