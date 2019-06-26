<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;

class LoaiTinController extends Controller
{
    public function getDanhSach()
    {
    	$loaitin = LoaiTin::all();
    	return view('admin.loaitin.danhsach',['loaitin'=>$loaitin]);
    }

    public function getThem()
    {
        $theloai = TheLoai::all();
    	return view('admin.loaitin.them',['theloai'=>$theloai]);
    }

    public function postThem(Request $request)
    {
    	$this->validate($request,
            [
                'Ten' => 'required|unique:LoaiTin,Ten|min:1|max:100',
                'TheLoai' => 'required'
            ],
            [
                'Ten.required'=>'Ban chua nhap loai tin',
                'Ten.unique'=>'ten loai tin da ton tai',
                'Ten.min'=>'Ten loai tin co do dai tu 1 den 100',
                'Ten.max'=>'Ten loai tin co do dai tu 1 den 100',
                'TheLoai.required'=>'Ban chua chon the loai'
            ]);

        $loaitin = new LoaiTin;
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();

        return redirect('admin/loaitin/them')->with('thongbao','Ban da them thanh cong');
    }

    public function getSua($id)
    {
        $theloai = TheLoai::all();
    	$loaitin = LoaiTin::find($id);
        return view('admin.loaitin.sua',['loaitin'=>$loaitin,'theloai'=>$theloai]);
    }

    public function postSua(Request $request,$id)
    {
    	$this->validate($request,
            [
                'Ten' => 'required|unique:LoaiTin,Ten|min:1|max:100',
                'TheLoai' => 'required'
            ],
            [
                'Ten.required'=>'Ban chua nhap loai tin',
                'Ten.unique'=>'ten loai tin da ton tai',
                'Ten.min'=>'Ten loai tin co do dai tu 1 den 100',
                'Ten.max'=>'Ten loai tin co do dai tu 1 den 100',
                'TheLoai.required'=>'Ban chua chon the loai'
            ]);

        $loaitin = LoaiTin::find($id);
        $loaitin->Ten = $request->Ten;
        $loaitin->TenKhongDau = changeTitle($request->Ten);
        $loaitin->idTheLoai = $request->TheLoai;
        $loaitin->save();

        return redirect('admin/loaitin/sua'.$id)->with('thongbao','Ban da sua thanh cong');
    }

    public function getXoa($id)
    {
    	$loaitin = LoaiTin::find($id);
        $loaitin->delete();
        return redirect('admin/loaitin/danhsach')->with('thongbao','Xoa thanh cong');
    }
}
