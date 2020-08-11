<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $data['title']				= 'List User';

        $data['css']                = view('admin.user.css');            
        $data['js']                 = view('admin.user.js');             
        $data['script']             = view('admin.user.scripts');
        return view('admin.user.list')->with($data);
    }

    public function create()
    {
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title']              = 'Tambah Pengguna';
        $data['id']		            = $this->kode_otomatis();
        $data['password']		    = '';
        $data['email']			    = '';
        $data['name']			    = '';
        
        $data['css']                = view('admin.user.cssform')->with($data);
        $data['js']                 = view('admin.user.jsform')->with($data);
        $data['script']             = view('admin.user.scriptsform')->with($data);
        return view('admin.user.create')->with($data);
    }

    public function store(Request $request)
    {
        $data =[ 
            'name'  		        => $request->name,
            'email' 			    => $request->email,
            'password'	    		=> Hash::make($request->password)
        ];
        User::create($data);
        return redirect('/appmaster/user')->with('SUCCESSMSG','Data Berhasil di Tambah');
        
    }

    public function edit($id)
    {
        $query 	                    = User::where('id','=',$id)->get();
        
        if($query->count() > 0){
            
            foreach($query as $db){
                $data['id']			= $id;
                $data['name']		= $db->name;
                $data['email']	    = $db->email;
                
            }
        }
        else{
            $data['id']				= $id;
            $data['name']			= '';
            $data['email']		    = '';
            
        }
        
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        
        $data['title'] 				= 'Edit Pengguna';

        $data['css']                = view('admin.user.cssform')->with($data);
        $data['js']                 = view('admin.user.jsform')->with($data);
        $data['script']             = view('admin.user.scriptsforms')->with($data);
        return view('admin.user.edit')->with($data);
    }

    public function update(Request $request)
    {
        $data =[ 
            'name'  		        => $request->name,
            'email' 			    => $request->email,
            'password'	    		=> Hash::make($request->password)
        ];
        $id						    = $request->id;
       

        if(empty($request->password)){
            User::where('id','=',$id)->update(array('email'=>$request->email,'name'=>$request->name));
            return redirect('/appmaster/user')->with('SUCCESSMSG','Data Berhasil di Update');
        }else{
            User::where('id','=',$id)->update($data);
            return redirect('/appmaster/user')->with('SUCCESSMSG','Data Berhasil di Update');
        }
        
    }

    public function destroy(Request $request)
    {
        $id                         = $request->id;
        $user                       = User::find($id);
        $user->delete();
        return redirect('/appmaster/user')->with('SUCCESSMSG','Data Berhasil di Hapus');
    }

    public function show()
	{
		$total                      = User::get()->count();
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;

		$query                      = User::take($length)->skip($start)->orderBy('id','DESC')->get();
		
		if($search!=""){
        $query                      = User::orWhere('name','like','%'.$search.'%')->orderBy('id','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $user) {
            if ($user->id == 1 ){
                $cek = "<a class='btn btn-warning btn-sm' type='button' data-toggle='tooltip'  title='Edit'  href=".url('appmaster/user/'.$user->id.'/edit')."><i class='fa fa-pencil'></i></a>
                ";
                }else{
                $cek= "<a class='btn btn-warning btn-sm' type='button' data-toggle='tooltip'  title='Edit'  href=".url('appmaster/user/'.$user->id.'/edit')."><i class='fa fa-pencil'></i></a>
                            <a href='javascript:void(0);' onclick='hapusid($user->id)' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i> </a>
                            ";
                }
           $output['data'][]=
					array(
						$no,
						$user->email,
						$user->name,
                        $cek
                );
		$no++;
		}
		
		$output['draw']             = $draw;
		$output['recordsTotal']     = $total;
		$output['recordsFiltered']  = $total;
		
		echo json_encode($output);

    }
    function kode_otomatis()
    {
        $query          = User::select(DB::raw('MAX(RIGHT(id,1)) as kode_max'))->get();
        $kd             = "";
        if ($query->count() > 0){
            foreach ($query as $k){
                $tmp = ((int)$k->kode_max)+1;
                $kd = sprintf("%01s", $tmp);
            }
        }
        else
        {
            $kd = "1";
        }
        return $kd;
		
    }
    public function cekemail(Request $request)
	{
		$email          = $request->email;
		$cek            = User::select('email')->where('email',$email)->get();
		if($cek->count() == 0)
		{
			echo "true";
		
		}
		else
		{
			echo "false";
		}
	}
}
