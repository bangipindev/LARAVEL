<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Setting;
use App\Blog;
use App\Photo;
use App\Page;
use App\Contact;
use App\Category;
use App\Comment;
use App\Job;
use App\Libraries\Applib;
use App\Tag;
use App\Statistik;
use App\Testimonial;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   
     public function __construct()
     {
         $this->middleware('auth');
     }
   
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['title']					    = 'Dashboard Administrator';
        $setting                            = Setting::find(1);
        $data['logo']				        = $setting['logo'];
        $data['situs']				        = $setting['nama'];
        $data['favicon']			        = $setting['favicon'];
        $data['author']				        = $setting['pemilik'];
        $data['totalartikel']               = Blog::get()->count();
        $data['totalpekerjaan']             = Job::get()->count();
        $data['totalgaleri']                = Photo::get()->count();
        $data['totalpage']                  = Page::get()->count();
        $data['inbox']                      = Contact::where('status','0')->get()->count();
        $data['kategori']                   = Category::where('status','1')->get()->count();
        $data['komentar']                   = Comment::where('status','0' AND 'dibaca','0')->get()->count();
        $data['tag']                        = Tag::get()->count();
        $data['testimoni']                  = Testimonial::get()->count();
        $data['lastpostblog']			    = Blog::orderBy('id','ASC')->take(5)->get();
        $data['lastpostjob']			    = Job::orderBy('id','ASC')->take(5)->get();
        $data['topviewjob']				    = Job::orderBy('hits','DESC')->take(5)->get();
        $data['topviewblog']			    = Blog::orderBy('hits','DESC')->take(5)->get();
        $data['komentarpending']		    = Comment::where('status','=','0')->where('disetujui','=','0')->orderBy('id','ASC')->take(5)->get();
        $data['komentarapprove']		    = Comment::where('status','=','0')->where('disetujui','=','1')->orderBy('id','ASC')->take(5)->get();
        $data['komentarrejected']		    = Comment::where('status','=','3')->orderBy('id','ASC')->take(5)->get();
       
        $data['css']					    =  view('admin.home.css');
        $data['js']						    =  view('admin.home.js');
        return view('admin.home.list')->with($data);
    }
    
}
