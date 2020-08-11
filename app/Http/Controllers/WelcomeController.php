<?php

namespace App\Http\Controllers;

use App\Job;
use App\JobCategory;
use App\Landingpage;
use App\Libraries\Applib;
use App\Pendidikan;
use App\Province;
use App\Setting;
use App\Statistik;
use Harimayco\Menu\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index(){		
       	$setting                    = Setting::find(1);
       	$data['slider_top']			= Applib::get_slider_top();
		$data['slideTop']			= Applib::get_countsliderTop();
		
		$fitur						= Landingpage::find(1);
		$data['logo']				= $setting['logo'];
		$data['favicon']			= $setting['favicon'];
		$data['situs']				= $setting['nama'];
		$data['title']				= $setting['nama'];
		$data['slogan']				= $setting['slogan'];
		$data['deskripsi_web']		= $setting['deskripsi_situs'];
		$data['meta_deskripsi']		= $setting['meta_deskripsi'];
		$data['meta_keyword']		= $setting['meta_keyword'];
		$data['telp']				= $setting['telepon'];
		$data['email']				= $setting['email_website'];
		$data['alamat']				= $setting['alamat'];
		$data['author']				= $setting['pemilik'];
		$data['website']			= $setting['website'];
		$data['tema']				= $setting['tema'];
		$data['facebook']			= $setting['facebook'];
		$data['instagram']			= $setting['instagram'];
		$data['twitter']			= $setting['twitter'];
		$data['youtube']			= $setting['youtube'];
		$data['linkedin']			= $setting['linkedin'];
		
		$data['fitur1']				= $fitur['judulfitur1'];
		$data['fitur2']				= $fitur['judulfitur2'];
		$data['fitur3']				= $fitur['judulfitur3'];
		$data['desk1']				= $fitur['konten1'];
		$data['desk2']				= $fitur['konten2'];
		$data['desk3']				= $fitur['konten3'];
		
		$data['dd_provinsi']		= $this->dd_provinsi();
		$data['dd_levelpend']		= $this->get_levelpendidikan();
		$data['dd_kategorijob']		= $this->get_kategoripekerjaan();
		$data['dd_tipepekerjaan']	= $this->get_tipepekerjaan();
		$data['jobs']				= Job::where('status',1)->orderBy('id','DESC')->take(8)->get();
		
		$data['totalpekerjaan']		= $this->totalpekerjaan();
        $data['totaluser']			= $this->visitor();
  
		return view('web.index')->with($data);
	}
	public function loker(){		
		/*---------------CONFIG---------------*/
		$setting					= Setting::find(1); 
		$data['situs']				= $setting['nama'];
		$data['title']				= $setting['nama'];
		$data['logo']				= $setting['logo'];
		$data['favicon']			= $setting['favicon'];
		$data['telp']				= $setting['telepon'];
		$data['email']				= $setting['email_website'];
		$data['alamat']				= $setting['alamat'];
		$data['author'	]			= $setting['pemilik'];
		$data['deskripsi_web']		= $setting['deskripsi_situs'];
		$data['website']			= $setting['website'];
		$data['facebook']			= $setting['facebook'];
		$data['instagram']			= $setting['instagram'];
		$data['twitter'	]			= $setting['twitter'];
		$data['youtube']			= $setting['youtube'];
		$data['linkedin']			= $setting['linkedin'];
		$data['meta_deskripsi']		= $setting['meta_deskripsi'];
		$data['meta_keyword']		= $setting['meta_keyword'];

		$fitur						= Landingpage::find(1);
		$data['fitur1']				= $fitur['judulfitur1'];
		$data['fitur2']				= $fitur['judulfitur2'];
		$data['fitur3']				= $fitur['judulfitur3'];
		$data['desk1']				= $fitur['konten1'];
		$data['desk2']				= $fitur['konten2'];
		$data['desk3']				= $fitur['konten3'];
		
		$data['dd_provinsi']		= $this->dd_provinsi();
		$data['dd_levelpend']		= $this->get_levelpendidikan();
		$data['dd_kategorijob']		= $this->get_kategoripekerjaan();
		$data['dd_tipepekerjaan']	= $this->get_tipepekerjaan();
		$data['jobs']				= Job::where('status',1)->orderBy('id','DESC')->paginate(8);
		
		$data['totalpekerjaan']		= $this->totalpekerjaan();
		return view('web.lowongan')->with($data);
	}
	public function kategori(Request $request){
		$setting					= Setting::find(1);
		
		$data['situs']				= $setting['nama'];
		$data['logo']				= $setting['logo'];
		$data['favicon']			= $setting['favicon'];
		$data['telp']				= $setting['telepon'];
		$data['email']				= $setting['email_website'];
		$data['alamat']				= $setting['alamat'];
		$data['author'	]			= $setting['pemilik'];
		$data['deskripsi_web']		= $setting['deskripsi_situs'];
		$data['meta_deskripsi']		= $setting['meta_deskripsi'];
		$data['meta_keyword']		= $setting['meta_keyword'];
		$data['website']			= $setting['website'];
		$data['facebook']			= $setting['facebook'];
		$data['instagram']			= $setting['instagram'];
		$data['twitter'	]			= $setting['twitter'];
		$data['youtube']			= $setting['youtube'];
        $data['linkedin']			= $setting['linkedin'];
        
		$fitur						= Landingpage::find(1);
		$data['fitur1']				= $fitur['judulfitur1'];
		$data['fitur2']				= $fitur['judulfitur2'];
		$data['fitur3']				= $fitur['judulfitur3'];
		$data['desk1']				= $fitur['konten1'];
		$data['desk2']				= $fitur['konten2'];
		$data['desk3']				= $fitur['konten3'];
		
		$slug						= $request->segment(2);
		$slugid						= Applib::CariKodeKategori($slug);
		$namakategori				= Applib::CariNamaKategori($slugid);
		$uri						= Job::where('id_kategori',$slugid)->take(1)->get();
		if($uri->count() > 0 ){
			$data['title']				= $namakategori;
			$data['jobs']				= Job::where('status',1)->where('id_kategori','=',$slugid)->orderBy('id','DESC')->paginate(8);
        	$data['totalpekerjaan']		= Job::where('status',1)->where('id_kategori','=',$slugid)->get()->count();
        
			return view('web.kategori-loker')->with($data);
		}else{
			return redirect('loker');
		}
	}
	public function kota(Request $request){
		$setting					= Setting::find(1);
		
		$data['situs']				= $setting['nama'];
		$data['logo']				= $setting['logo'];
		$data['favicon']			= $setting['favicon'];
		$data['telp']				= $setting['telepon'];
		$data['email']				= $setting['email_website'];
		$data['alamat']				= $setting['alamat'];
		$data['author'	]			= $setting['pemilik'];
		$data['deskripsi_web']		= $setting['deskripsi_situs'];
		$data['meta_deskripsi']		= $setting['meta_deskripsi'];
		$data['meta_keyword']		= $setting['meta_keyword'];
		$data['website']			= $setting['website'];
		$data['facebook']			= $setting['facebook'];
		$data['instagram']			= $setting['instagram'];
		$data['twitter'	]			= $setting['twitter'];
		$data['youtube']			= $setting['youtube'];
        $data['linkedin']			= $setting['linkedin'];
        
		$fitur						= Landingpage::find(1);
		$data['fitur1']				= $fitur['judulfitur1'];
		$data['fitur2']				= $fitur['judulfitur2'];
		$data['fitur3']				= $fitur['judulfitur3'];
		$data['desk1']				= $fitur['konten1'];
		$data['desk2']				= $fitur['konten2'];
		$data['desk3']				= $fitur['konten3'];
		
		$slug						= $request->segment(2);
		$data['title']				= "Lowongan Kerja di Kota $slug";
		$data['jobs']				= Job::where('status',1)->where('slugid','=',$slug)->orderBy('id','DESC')->paginate(8);
		$data['totalpekerjaan']		= Job::where('status',1)->where('slugid','=',$slug)->get()->count();
	
		return view('web.kategori-loker')->with($data);
		
	}
	
	public function detail(Request $request){		
		$id							= $request->segment(3);
		$url						= Job::find($id);
		if($url->count() > 0){
			$setting					= Setting::find(1); 		
			
			/*---------------job---------------*/
			$data['titlejob']			= $url['pekerjaan'];
			$data['detail']				= $url;
			$data['lokerterkait']		= Job::where('status',1)->where('id_kategori',$url['id_kategori'])->where('id','!=',$id)->orderBy('id','DESC')->take(4)->get();
			$data['title']				= ucwords($data['detail']['pekerjaan']);
			$data['meta_deskripsi']		= $data['detail']['meta_deskripsi'];
			$data['meta_keyword']		= $data['detail']['meta_keyword'];
			
			$data['logo']				= $setting['logo'];
			$data['favicon']			= $setting['favicon'];
			$data['situs']				= $setting['nama'];
			$data['deskripsi_web']		= $setting['deskripsi_situs'];
			$data['telp']				= $setting['telepon'];
			$data['email']				= $setting['email_wesite'];
			$data['alamat']				= $setting['alamat'];
			$data['author'	]			= $setting['pemilik'];
			$data['website']			= $setting['website'];
			$data['tema']				= $setting['tema'];
			$data['facebook']			= $setting['facebook'];
			$data['instagram']			= $setting['instagram'];
			$data['twitter'	]			= $setting['twitter'];
			$data['youtube']			= $setting['youtube'];
			$data['linkedin']			= $setting['linkedin'];
			$data['jobdetailcss']		= true;
			$data['jobdetailjs']		= true;
			return view('web.lowongan-detail')->with($data);			
		}
		else{
			abort(404);
		}
    }
    function dd_provinsi(){
		$query= Province::orderBy('id_propinsi')->get();
        return $query;
    }
    function get_levelpendidikan(){
        $query= Pendidikan::orderBy('id','ASC')->get();
        return $query;
    }
	function get_kategoripekerjaan(){
        $query= JobCategory::orderBy('kategori','ASC')->get();
        return $query;
    }
    function get_tipepekerjaan(){
		$dd['']='Tipe Pekerjaan';
		$dd['0']= 'Freelance';
		$dd['1']= 'Full Time';
		$dd['2']= 'Part Time';
		return $dd;
    }
    function  totalpekerjaan() {
        $query= Job::get()->count();
        return $query;
    }
    public function visitor(){
		return 	Statistik::get()->count();
	}
	
}
