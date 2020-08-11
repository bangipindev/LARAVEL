<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Menu;
use App\MenuItems;
use App\Setting;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
    public function index(){
        $data['title']			        = "Menu";
        $setting                        = Setting::find(1);
        $data['logo']				    = $setting['logo'];
        $data['situs']				    = $setting['nama'];
        $data['favicon']			    = $setting['favicon'];
        $data['author']				    = $setting['pemilik'];
        $data['script']                 = view('admin.menu.scripts');

        $menu                           = new Menu();
        $menuitems                      = new MenuItems();
        $menulist                       = $menu->select(['id','name'])->get();
        $menulist                       = $menulist->pluck('name', 'id')->prepend('Select menu', 0)->all();
        
        if ((request()->has("action") && empty(request()->input("menu"))) || request()->input("menu") == '0') {
            
            return view('admin.menu.menu',$data)->with("menulist", $menulist);
       
        } else {
           
            $menu                       = Menu::find(request()->input("menu"));
            $menus                      = $menuitems->getall(request()->input("menu"));

            $d                          = ['menus' => $menus, 'indmenu' => $menu, 'menulist' => $menulist];
            if(false) {
                $d['roles']             = DB::table('roles')->select('id','name')->get();
                $d['role_pk']           = 'id';
                $d['role_title_field']  = 'name';
            }
            return view('admin.menu.menu',$d)->with($data);
        }
       
    }

    public function createnewmenu()
    {

        $menu = new Menu();
        $menu->name = request()->input("menuname");
        $menu->save();
        return json_encode(array("resp" => $menu->id));
    }

    public function deleteitemmenu()
    {
        $menuitem = MenuItems::find(request()->input("id"));

        $menuitem->delete();
    }

    public function deletemenug()
    {
        $menus = new MenuItems();
        $getall = $menus->getall(request()->input("id"));
        if (count($getall) == 0) {
            $menudelete = Menu::find(request()->input("id"));
            $menudelete->delete();

            return json_encode(array("resp" => "you delete this item"));
        } else {
            return json_encode(array("resp" => "You have to delete all items first", "error" => 1));

        }
    }

    public function updateitem()
    {
        $arraydata = request()->input("arraydata");
        if (is_array($arraydata)) {
            foreach ($arraydata as $value) {
                $menuitem = MenuItems::find($value['id']);
                $menuitem->label = $value['label'];
                $menuitem->link = $value['link'];
                $menuitem->class = $value['class'];
                if (false) {
                    $menuitem->role_id = $value['role_id'] ? $value['role_id'] : 0 ;
                }
                $menuitem->save();
            }
        } else {
            $menuitem = MenuItems::find(request()->input("id"));
            $menuitem->label = request()->input("label");
            $menuitem->link = request()->input("url");
            $menuitem->class = request()->input("clases");
            if (false) {
                $menuitem->role_id = request()->input("role_id") ? request()->input("role_id") : 0 ;
            }
            $menuitem->save();
        }
    }

    public function addcustommenu()
    {

        $menuitem = new MenuItems();
        $menuitem->label = request()->input("labelmenu");
        $menuitem->link = request()->input("linkmenu");
        if (false) {
            $menuitem->role_id = request()->input("rolemenu") ? request()->input("rolemenu")  : 0 ;
        }
        $menuitem->menu = request()->input("idmenu");
        $menuitem->sort = MenuItems::getNextSortRoot(request()->input("idmenu"));
        $menuitem->save();

    }

    public function generatemenucontrol()
    {
        $menu = Menu::find(request()->input("idmenu"));
        $menu->name = request()->input("menuname");

        $menu->save();
        if (is_array(request()->input("arraydata"))) {
            foreach (request()->input("arraydata") as $value) {

                $menuitem = MenuItems::find($value["id"]);
                $menuitem->parent = $value["parent"];
                $menuitem->sort = $value["sort"];
                $menuitem->depth = $value["depth"];
                if (false) {
                    $menuitem->role_id = request()->input("role_id");
                }
                $menuitem->save();
            }
        }
        echo json_encode(array("resp" => 1));

    }
}
