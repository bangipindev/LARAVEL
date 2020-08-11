<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Helpers\Sistem;
use App\Http\Controllers\Controller;
use App\Job;
use App\JobCategory;
use App\Pendidikan;
use App\Province;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class JobController extends Controller
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
        $data['title']				= 'List Pekerjaan';

        $data['css']                = view('admin.pekerjaan.css');            
        $data['js']                 = view('admin.pekerjaan.js');             
        $data['script']             = view('admin.pekerjaan.scripts');
        return view('admin.pekerjaan.list')->with($data);
   }

   public function create()
    {
        
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['id']                 = '';
        $data['nama_pekerjaan']	    = '';
        $data['deskripsi']		    = '';
        $data['short_deskripsi']	= '';
        $data['kategori']			= '';
        $data['lokerkota']			= '';
        $data['provinsi']			= '';
        $data['kota']		        = '';
        $data['gaji']		        = '';
        $data['pendidikan']		    = '';
        $data['status']		        = '';
        $data['email']			    = '';
        $data['label']			    = '';
        $data['bataswaktu']		    = '';
        $data['perusahaan']		    = '';
        $data['meta_deskripsi']	    = '';
        $data['meta_keyword']	    = '';
        $data['image']		        = '';
       
        $data['title']              = 'Tambah Pekerjaan';
        $data['dd_kategori']		= $this->dd_kategori_pekerjaan();
        $data['dd_lokerkota']		= $this->dd_lokerkota();
		$data['levelpendidikan']	= $this->dd_level_pendidikan();
		$data['dd_provinsi']	    = $this->dd_provinsi();
        $data['dd_status']		    = $this->dd_status();
        $data['dd_label']		    = $this->dd_label();
        $data['dd_kotakab']		    = $this->dd_kabupaten();
        $data['css']                = view('admin.pekerjaan.cssform')->with($data);
        $data['js']                 = view('admin.pekerjaan.jsform')->with($data);
        $data['script']             = view('admin.pekerjaan.scriptsform')->with($data);
        return view('admin.pekerjaan.form')->with($data);
    }
   public function edit($id)
    {
        $query 	                    = Job::where('id','=',$id)->get();
        if($query->count() > 0){
            
            foreach($query as $db){
                $data['id']                 = $id;
                $data['nama_pekerjaan']	    = $db->pekerjaan;
                $data['deskripsi']		    = $db->deskripsi;
                $data['short_deskripsi']	= $db->deskripsi_singkat;
                $data['kategori']			= $db->id_kategori;
                $data['lokerkota']			= $db->slugid;
                $data['provinsi']			= $db->provinsi;
                $data['kota']		        = $db->kota;
                $data['gaji']		        = $db->gaji;
                $data['pendidikan']		    = $db->pendidikan;
                $data['status']		        = $db->status;
                $data['email']			    = $db->email;
                $data['label']			    = $db->label;
                $data['bataswaktu']		    = Sistem::tgl_sql($db->batas_waktu);
                $data['perusahaan']		    = $db->perusahaan;
                $data['meta_deskripsi']	    = $db->meta_deskripsi;
                $data['meta_keyword']	    = $db->meta_keyword;
                $data['image']		        = $db->gambar;
            }
        }
        else{
                $data['id']                 = $id;
                $data['nama_pekerjaan']	    = '';
                $data['deskripsi']		    = '';
                $data['short_deskripsi']	= '';
                $data['kategori']			= '';
                $data['lokerkota']			= '';
                $data['provinsi']			= '';
                $data['kota']		        = '';
                $data['gaji']		        = '';
                $data['pendidikan']		    = '';
                $data['status']		        = '';
                $data['email']			    = '';
                $data['label']			    = '';
                $data['bataswaktu']		    = '';
                $data['perusahaan']		    = '';
                $data['meta_deskripsi']	    = '';
                $data['meta_keyword']	    = '';
                $data['image']		        = '';
        }
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
       
        $data['title']              = 'Edit Pekerjaan';
        $data['dd_kategori']		= $this->dd_kategori_pekerjaan();
        $data['dd_lokerkota']		= $this->dd_lokerkota();
		$data['levelpendidikan']	= $this->dd_level_pendidikan();
		$data['dd_provinsi']	    = $this->dd_provinsi();
        $data['dd_status']		    = $this->dd_status();
        $data['dd_label']		    = $this->dd_label();
        $data['dd_kotakab']		    = $this->dd_kabupaten($data['kota']);
        $data['css']                = view('admin.pekerjaan.cssform')->with($data);
        $data['js']                 = view('admin.pekerjaan.jsform')->with($data);
        $data['script']             = view('admin.pekerjaan.scriptsform')->with($data);
        return view('admin.pekerjaan.form')->with($data);
    }

    public function store(Request $request)
    {
        
        date_default_timezone_set('Asia/Jakarta');
        $request->validate([
            'image'                 => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        $file                       = $request->file('image');
        $imglama	                = $request->imagelama;
        if ($file) {
            $filename               = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $path                   = public_path('img');
            $file->move($path, $filename);
            $data = [
                'pekerjaan'	            => $request->nama_pekerjaan,
                'slug'			        => Str::slug($request->nama_pekerjaan,'-'),
                'slugid'			    => $request->lokerkota,
                'deskripsi'	            => $request->deskripsi,
                'deskripsi_singkat'	    => $request->short_deskripsi,
                'id_kategori'           => $request->kategori,
                'provinsi'  	        => $request->provinsi,
                'kota'  	            => $request->kota,
                'gaji'                  => $request->gaji,
                'label'                 => $request->label,
                'status'                => $request->status,
                'email'                 => $request->email,
                'pendidikan'            => $request->pendidikan,
                'batas_waktu'           => Sistem::tgl_sql($request->bataswaktu),
                'perusahaan'            => $request->perusahaan,
                'meta_deskripsi'        => $request->meta_deskripsi,
                'meta_keyword'          => $request->meta_keyword,
                'gambar'                => $filename,
            ];
            File::delete(public_path('img/'.$imglama));   
            $id						= $request->id;
            $d						= Job::where('id','=',$id);
        }
        else{
            $data = [
                'pekerjaan'	            => $request->nama_pekerjaan,
                'slug'			        => Str::slug($request->nama_pekerjaan,'-'),
                'slugid'			    => $request->lokerkota,
                'deskripsi'	            => $request->deskripsi,
                'deskripsi_singkat'	    => $request->short_deskripsi,
                'id_kategori'           => $request->kategori,
                'provinsi'  	        => $request->provinsi,
                'kota'  	            => $request->kota,
                'gaji'                  => $request->gaji,
                'label'                 => $request->label,
                'status'                => $request->status,
                'email'                 => $request->email,
                'pendidikan'            => $request->pendidikan,
                'batas_waktu'           => Sistem::tgl_sql($request->bataswaktu),
                'perusahaan'            => $request->perusahaan,
                'meta_deskripsi'        => $request->meta_deskripsi,
                'meta_keyword'          => $request->meta_keyword,
                'gambar'                => $imglama,
            ];
            $id						    = $request->id;
            $d						    = Job::where('id','=',$id);
        }
        if ($d->count() > 0){
            Job::where('id','=',$id)->update($data);
            return redirect('/appmaster/pekerjaan')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        else{
            Job::create($data);
            return redirect('/appmaster/pekerjaan')->with('SUCCESSMSG','Data Berhasil di Tambah');
        }
    }
    public function destroy(Request $request)
    {
        $id                         = $request['id'];
        $pekerjaan                  = Job::find($id);
        $pekerjaan->delete();
        return redirect('/appmaster/pekerjaan')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }
   public function show()
	{
        
        $total                      = Job::get()->count();
        
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = Job::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = Job::orWhere('pekerjaan','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $job) {
            if(!empty($job->gambar)){
				$gambar = "<a href=".url(asset('img/'.$job->gambar.''))." class='fancy-view'>
						   <img src=".url(asset('img/'.$job->gambar.''))." alt='' border='0' class='img-responsive'>";
			}else{
				$gambar = "<a href=".url(asset('img/no-image.png'))." class='fancy-view'>
						  <img src=".url(asset('img/no-image.png'))." class='img-responsive' alt='' border='0'>";
            }
            if($job->label== 0){
				$label = "<span class='label label-primary'>Freelance</span>";
			}else if($job->label== 1){
				$label = "<span class='label label-success'>Full Time</span>";
			}else if($job->label== 2){
				$label = "<span class='label label-info'>Part Time</span>";
			}
            $output['data'][]=
					array(
						$no,
						$job->pekerjaan,
						$job->id_kategori,
						$job->gaji,
						$label,
						$job->status=='0'?'<span class="label label-danger">Tidak Dipublikasi</span>':'<span class="label label-success">Dipublikasi</span>',
						$job->hits,
						$gambar,
						"<a href=".url('appmaster/pekerjaan/'.$job->id.'/edit')." class='btn btn-sm btn-primary btn-editable'><i class='fa fa-pencil'></i> </a>
						<a href='javascript:void(0);' onclick='hapusid($job->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>",
                    );
		$no++;
		}
		
		$output['draw']             = $draw;
		$output['recordsTotal']     = $total;
		$output['recordsFiltered']  = $total;
		
		echo json_encode($output);

    }
    function dd_status(){
		$dd['0']= 'Not Publish';
        $dd['1']= 'Publish';
		
		return $dd;
    }
    function dd_kategori_pekerjaan(){
		$query                      = JobCategory::where('status','=','2')->orderBy('id','ASC')->get();
        $dd                          = array();
        if ($query->count() > 0){
            foreach($query as $row){
                $dd[$row->id] = $row->kategori;
            }
        }
		return $dd;
    }
    function dd_level_pendidikan(){
		$query                      = Pendidikan::orderBy('id','ASC')->get();
        $dd                         = array();
        if ($query->count() > 0){
            foreach($query as $row){
                $dd[$row->id] = $row->pendidikan;
            }
        }
		return $dd;
    }
    function dd_label(){
        $dd['0']= 'Freelance';
        $dd['1']= 'Full Time';
        $dd['2']= 'Part Time';
        return $dd;
    }
    function dd_lokerkota(){
        $dd['jakarta']      = 'Lowongan Kerja di Jakarta';
        $dd['jogja']        = 'Lowongan Kerja di Jogja';
        $dd['surabaya']     = 'Lowongan Kerja di Surabaya';
        $dd['semarang']     = 'Lowongan Kerja di Semarang';
        $dd['malang']       = 'Lowongan Kerja di Malang';
        $dd['palembang']    = 'Lowongan Kerja di Palembang';
        $dd['ambon']        = 'Lowongan Kerja di Ambon';
        $dd['pontianak']    = 'Lowongan Kerja di Pontianak';
        $dd['manado']       = 'Lowongan Kerja di Manado';
        
        return $dd;
    }
    function dd_provinsi(){
        $query                      = Province::orderBy('id_propinsi','ASC')->get();
        $dd                          = array();
        if ($query->count() > 0){
            foreach($query as $row){
                $dd[$row->id_propinsi] = $row->nama_propinsi;
            }
        }
		return $dd;
		
    }
    function dd_kabupaten($slug=FALSE){
        if($slug === FALSE){
			$dd['']='Pilih Kota/Kab';
			return $dd; 
		}
        $query                      = City::where('id_kabkota','=',$slug)->get();
		$dd['']                     = 'Pilih Kota/Kab';
		    if($query->count() > 0){
            foreach($query as $row){
                $dd[$row->id_kabkota]= $row->nama_kabkota;
                }
            }
        return $dd;    
    }
    public function allkota(Request $request){
		$provinsi_id                = $request->prov_id;
		$query                      = City::where('id_propinsi','=',$provinsi_id)->orderBy('id_propinsi','ASC')->get();
		if($query->count()> 0){
			foreach($query as $row){
				echo "<option value='".$row->id_kabkota."'>".$row->nama_kabkota."</option>";
				}
			}
	
	}
}
