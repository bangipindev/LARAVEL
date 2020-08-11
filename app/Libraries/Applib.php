<?php

namespace App\Libraries;

use App\Blog;
use App\Category;
use App\City;
use App\Comment;
use App\Contact;
use App\Job;
use App\JobCategory;
use App\Menu;
use App\MenuItems;
use App\Modul;
use App\Page;
use App\Pendidikan;
use App\Province;
use App\Slider;
use Illuminate\Support\Facades\DB;

class Applib {
    //SLIDER
    public static function get_slider_top(){
        $query= Slider::where('status',2)->where('tipe',1)->orderBy('posisi')->take(5)->get();
        return $query;
	}
	
	public static function get_countsliderTop(){
		$query= Slider::where('status',3)->where('tipe',1)->orderBy('posisi')->get()->count();
	}
	
    public static function WebMenu($id)
    {
        $menu            = Menu::where('id',$id)->with('items')->first();
        $public_menu     = $menu->items;
        return $public_menu;
        
    }
    
   public static function listInbox(){
        $query                      = Contact::where('status','=','0')->orderBy('created_at','DESC')->get();
        return $query;
    }
    public static function totalInbox(){
        $totalinbox                 = Contact::where('status','=','0')->get()->count();
        $semua                      = isset($totalinbox) ? $totalinbox : 0;
        return $semua;
    }
    
    public static function totalKomentar(){
        $totalkomentar              = Comment::where('dibaca','=','0')->get()->count();
        $semua                      = isset($totalkomentar) ? $totalkomentar : 0;
        return $semua;
    }
   
    public static function getJudulBlog($id){
        $query                      = Blog::where('id','=',$id)->get();
		if($query->count() > 0){
			foreach($query as $h){
				$hasil = $h->judul;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
    }

    public static function CariNamaKota($id){
		$t = City::where('id_kabkota',$id)->get();
		if($t->count() > 0){
			foreach($t as $h){
				$hasil              = $h->nama_kabkota;
			}
		}else{
			$hasil                  = '';
		}
		return $hasil;
    }
	public static function CariNamaProvinsi($id){
		$t = Province::where('id_propinsi',$id)->get();
		if($t->count() > 0){
			foreach($t as $h){
				$hasil              = $h->nama_propinsi;
			}
		}else{
			$hasil                  = '';
		}
		return $hasil;
    }
	public static function CariNamaPendidikan($id){
		$t = Pendidikan::where('id',$id)->get();
		if($t->count() > 0){
			foreach($t as $h){
				$hasil              = $h->pendidikan;
			}
		}else{
			$hasil                  = '';
		}
		return $hasil;
    }
    public static function CariNamaKategori($id){
		$t = JobCategory::where('id',$id)->get();
		if($t->count() > 0){
			foreach($t as $h){
				$hasil              = $h->kategori;
			}
		}else{
			$hasil                  = '';
		}
		return $hasil;
    }
    public static function CariKodeKategori($slug){
		$t = JobCategory::where('slug',$slug)->get();
		if($t->count() > 0){
			foreach($t as $h){
				$hasil              = $h->id;
			}
		}else{
			$hasil                  = '';
		}
		return $hasil;
    }
    public static function selisih($id){
        date_default_timezone_set('Asia/Jakarta');
       $t = Job::select(DB::raw('DATEDIFF(DATE_ADD(batas_waktu, INTERVAL 0 DAY), CURDATE()) as selisih'))->where('id',$id)->get();
       if($t->count() >0){
           foreach($t as $h){
               $hasil = $h->selisih;
           }
       }else{
           $hasil = 0;
       }
       return $hasil;
   }
   public static function expired($id,$selisih) {
        $query          = " UPDATE jobs";
        $query_parent   = " SET expired = 0";
        $query_ids      = " WHERE DATEDIFF(CURDATE(),batas_waktu) > $selisih AND id =$id";
        DB::update($query.$query_parent.$query_ids);
   }
   public static function updatehits($id,$baca) {
        $query          = " UPDATE jobs";
        $query_parent   = " SET hits = $baca + 1";
        $query_ids      = " WHERE id =$id";
        DB::update($query.$query_parent.$query_ids);
   }
   
    public static function select($name = "menu", $menulist = array())
    {
        $html = '<select name="' . $name . '">';

        foreach ($menulist as $key => $val) {
            $active = '';
            if (request()->input('menu') == $key) {
                $active = 'selected="selected"';
            }
            $html .= '<option ' . $active . ' value="' . $key . '">' . $val . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public static function getByName($name)
    {
        $menu = Menu::byName($name);
        return is_null($menu) ? [] : self::get($menu->id);
    }

    public static function get($menu_id)
    {
        $menuItem = new MenuItems;
        $menu_list = $menuItem->getall($menu_id);

        $roots = $menu_list->where('menu', (integer) $menu_id)->where('parent', 0);

        $items = self::tree($roots, $menu_list);
        return $items;
    }

    private static function tree($items, $all_items)
    {
        $data_arr = array();
        $i = 0;
        foreach ($items as $item) {
            $data_arr[$i] = $item->toArray();
            $find = $all_items->where('parent', $item->id);

            $data_arr[$i]['child'] = array();

            if ($find->count()) {
                $data_arr[$i]['child'] = self::tree($find, $all_items);
            }

            $i++;
        }

        return $data_arr;
    }

    public static function menupage(){
        $querypages     = Page::orderBy('id','ASC')->get();
        foreach ($querypages as $pages){
        echo "<tbody>
                <td>
                    $pages->nama_laman
                </td>
                <td align='center'>
                    <a  href='#' data-url='$pages->pages_seo' data-title='$pages->nama_laman'class='button-secondary tambahkan-ke-menu right'  >Add <i class='fa fa-sign-out'></i> </a>
                    <span class='spinner' id='spinkategori'></span>
                 </td>
            </tbody>";
        }
    }
    public static function menukategori(){
        $query     = Category::where('_parent','=','1')->get();
        foreach ($query as $pages){
        echo "<tbody>
                <td>
                    $pages->kategori
                </td>
                <td align='center'>
                    <a href='#' data-url='blog/$pages->_slug' data-title='$pages->kategori' class='button-secondary tambahkan-ke-menu right'  >Add <i class='fa fa-sign-out'></i> </a>
                    <span class='spinner' id='spinkategori'></span>
                 </td>
            </tbody>";
        }
    }
    public static function menumodul(){
        $query     = Modul::all();
        foreach ($query as $modul){
        echo "<tbody>
                <td>
                    $modul->nama
                </td>
                <td align='center'>
                    <a href='#' data-url='$modul->url_modul' data-title='$modul->nama' class='button-secondary tambahkan-ke-menu right'  >Add <i class='fa fa-sign-out'></i> </a>
                    <span class='spinner' id='spinkategori'></span>
                 </td>
            </tbody>";
        }
    }
}