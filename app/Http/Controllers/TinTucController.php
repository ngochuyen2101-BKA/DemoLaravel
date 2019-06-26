<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;

class TinTucController extends Controller
{
    public function getDanhSach()
    {
    	$tintuc = TinTuc::orderBy('id','DESC')->get();
    	return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }

    public function getThem()
    {
    	$theloai = TheLoai::all();
    	$loaitin = LoaiTin::all();
    	return view('admin.tintuc.them',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    }

    public function postThem(Request $request)
    {
    	$this->validate($request,
    		[
    			'LoaiTin'=>'required',
    			'TieuDe'=>'required|unique:TinTuc,TieuDe|min:3',
    			'TomTat'=>'required',
    			'NoiDung'=>'required'
    		],
    		[
    			'LoaiTin.required'=>'Ban chua chon loai tin',
    			'TieuDe.required'=>'Ban chua nhap tieu de',
    			'TieuDe.unique'=>'Tieu de da ton tai',
    			'TieuDe.min'=>'Tieu de co do dai nho nhat la 3 ky tu',
    			'TomTat.required'=>'Ban chua nhap tom tat',
    			'Noi dung.required'=>'Ban chua nhap noi dung',
    		]);

    		$tintuc = new TinTuc;
    		$tintuc->TieuDe = $request->TieuDe;
    		$tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
    		$tintuc->idLoaiTin = $request->LoaiTin;
    		$tintuc->TomTat = $request->TomTat;
    		$tintuc->NoiDung = $request->NoiDung;
    		$tintuc->SoLuotXem = 0;

    		if ($request->hasFile('Hinh')) 
    		{
    			$file = $request->file('Hinh');
    			$duoi = $file->getClientOriginalExtension();
    			if ($duoi != 'jpg' && $duoi !='png' && $duoi != 'jpeg') {
    					return redirect('admin/tintuc/them')->with('loi','Ban chi duoc them file hinh');
    				}
    			$name = $file->getClientOriginalName();
    			$Hinh = str_random(4)."_".$name;
    			while (file_exists("upload/tintuc".$Hinh))
    			{
    				$Hinh = str_random(4)."_".$name;
    			}
    			$file->move("upload/tintuc",$Hinh);
    			$tintuc->Hinh = $Hinh;
    		}
    		else
    		{
    			$tintuc->Hinh = "";
    		}

    		$tintuc->save();

    		return redirect('admin/tintuc/them')->with('thongbao','Them tin thanh cong');

    }

    public function getSua($id)
    {
    	
    }

    public function postSua(Request $request,$id)
    {
    	
    }

    public function getXoa($id)
    {
    	
    }
}
