<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
	{
        $data['title']			    = "Kotak Pesan";
        $setting                    = Setting::find(1);
        $data['logo']				= $setting['logo'];
        $data['situs']				= $setting['nama'];
        $data['favicon']			= $setting['favicon'];
        $data['author']				= $setting['pemilik'];
        $data['datainbox'] 			= Contact::orderBy('id','DESC')->get();
        $data['css']                = view('admin.inbox.css');            
        $data['js']                 = view('admin.inbox.js');             
        $data['script']             = view('admin.inbox.script');
        
        return view('admin.inbox.list')->with($data);
    }
    public function show()
	{	
		$data['datainbox'] 			= Contact::orderBy('id','DESC')->get();
		return view('admin.inbox.inbox')->with($data);
			
    }
    public function viewinbox(Request $request)
	{	
        $id                         = $request->message_id;
        $data['viewinbox'] 			= Contact::where('id','=',$id)->get();
        $this->updateContact($id);
        return view('admin.inbox.view')->with($data);
        
    }
    public function balasinbox(Request $request)
	{	
    
        $id                         = $request->messageid;
        $data['viewinbox'] 			= Contact::where('id','=',$id)->get();
        return view('admin.inbox.reply')->with($data);
	}
    public function tulis()
	{	
		
		return view('admin.inbox.compose');
			
    }

    public function sendemail(Request $request){
        $config = [
            'useragent' 		=> 'Laravel',
            'protocol' 	 	    => 'smtp',
            'mailpath'  		=> '/usr/sbin/smtp',
            'smtp_host' 		=> 'mail.halokerja.id',
            'smtp_user' 		=> 'info@halokerja.id',   
            'smtp_pass' 		=> 'infohalokerja123123',             
            'smtp_port' 		=> 587,
            'smtp_keepalive'    => TRUE,
            'smtp_crypto' 	    => 'SSL',
            'wordwrap'  		=> TRUE,
            'wrapchars' 		=> 80,
            'mailtype' 		    => 'html',
            'charset'   		=> 'utf-8',
            'validate'  		=> TRUE,
            'crlf'      		=> "\r\n",
            'newline'   		=> "\r\n",
        ];

        //$this->email->initialize($config);
    
        $to						= $request->to;
        $cc						= $request->cc;
        $bcc					= $request->bcc; 
        $subject				= $request->subject; 
        $message				= $request->message; 
        $attach					= $request->files; 
        $from					= "info@halokerja.id";
        $name					= "Info@Halokerja.id";
        
        if(!empty($cc)){
            $cc_id = implode(",", $cc);
        }else{
            $cc_id = '';
        }
        if(!empty($bcc)){
            $bcc_id = implode(",", $bcc);
        }else{
            $bcc_id = '';
        }
        
        $this->email->from($from,$name);
        $this->email->to($to);
        $this->email->cc($cc_id);
        $this->email->bcc($bcc_id);
        $this->email->subject($subject);
        $this->email->message($message);
        foreach($attach as $ulang){
            $this->email->attach($ulang);
        }
        if($this->email->send()) {
            return with('SUCCESSMSG','Email berhasil terkirim ke alamat <strong>'.$to.'</strong>');
        }
        else {
            return with('GAGALMSG', 'Terjadi kesalahan. Harap ulangi kembali');
        }
        return redirect('/appmaster/inbox');
		
    }
    public function updateContact($id){
        $query          = "UPDATE contacts";
        $query_parent   = " SET status = 1";
        $query_ids      = " WHERE id =$id";
        DB::update($query.$query_parent.$query_ids);
        
    }
    public function destroy($id){
        $inbox       = Contact::find($id);
        $inbox->delete();
        return redirect ('appmaster/inbox')->with('SUCCESSMSG','Pesan Berhasil Di Hapus');
    
	}

}
