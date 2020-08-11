<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use App\Statistik;
use Illuminate\Routing\Controller;

class StatistikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
	{
			
			$data['title']				= 'Statistik Pengunjung';
            $setting                    = Setting::find(1);
            $data['logo']				= $setting['logo'];
            $data['situs']				= $setting['nama'];
            $data['favicon']			= $setting['favicon'];
            $data['author']				= $setting['pemilik'];
            
			$data['css']                = view('admin.visitor.css');            
            $data['js']                 = view('admin.visitor.js');             
            $data['script']             = view('admin.visitor.scripts');             
  
			return view('admin.visitor.list')->with($data);
			
    }
    public function show()
	{
		$total                      = Statistik::get()->count();
		$length                     = intval($_REQUEST['length']);
		$length                     = $length < 0 ? $total: $length; 
		$start                      = intval($_REQUEST['start']);
		$draw                       = intval($_REQUEST['draw']);
		
		$search                     = $_REQUEST['search']["value"];
		
		$output                     = array();
		$output['data']             = array();
		
		$end                        = $start + $length;
		$end                        = $end > $total ? $total : $end;
		
		$query                      = Statistik::take($length)->skip($start)->orderBy('tanggal','DESC')->get();
		
		if($search!=""){
        $query                      = Statistik::orWhere('agents','like','%'.$search.'%')->orderBy('tanggal','DESC')->get();
		$output['recordsTotal']     = $output['recordsFiltered']=$query->count();
		}

		$no=$start+1;
		foreach ($query as $visitor) {
            $output['data'][]=
					array(
						$no,
						$visitor->ip,
						$visitor->tanggal,
                        $visitor->agents,
                        $visitor->hits
                    );
		$no++;
		}
		
		$output['draw']             = $draw;
		$output['recordsTotal']     = $total;
		$output['recordsFiltered']  = $total;
		
		echo json_encode($output);

    }
}
