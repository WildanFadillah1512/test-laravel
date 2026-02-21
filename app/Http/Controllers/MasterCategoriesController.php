<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MasterCategory;
use App\Models\MasterItem;

class MasterCategoriesController extends Controller
{
    public function index()
    {
        return view('master_categories.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = MasterCategory::query();

        if ($kode != '') $data_search = $data_search->where('kode', 'LIKE', '%' . $kode . '%');
        if ($nama != '') $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        $data_search = $data_search->select('id', 'kode', 'nama')->orderBy('id')->get();

        return response()->json([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = null;
        } else {
            $item = MasterCategory::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('master_categories.form.index', $data);
    }

    public function singleView($id)
    {
        $data['data'] = MasterCategory::with('items')->find($id);
        return view('master_categories.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required'
        ]);

        if ($method == 'new') {
            $data_item = new MasterCategory;
        } else {
            $data_item = MasterCategory::find($id);
        }

        $data_item->nama = $request->nama;
        $data_item->kode = $request->kode;
        $data_item->save();

        if ($request->filled('redirect_to')) {
            return redirect($request->redirect_to);
        }

        return redirect('master-categories');
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required'
        ]);

        $data_item = new MasterCategory;
        $data_item->nama = $request->nama;
        $data_item->kode = $request->kode;
        $data_item->save();

        return response()->json([
            'status' => 200,
            'data' => $data_item
        ]);
    }

    public function delete($id)
    {
        MasterCategory::find($id)->delete();
        return redirect('master-categories');
    }

    public function printPdf($id)
    {
        $data['data'] = MasterCategory::with('items')->find($id);
        
        $pdf = \PDF::loadView('master_categories.single.print', $data);
        return $pdf->download('Kategori-'.$data['data']->kode.'-'.time().'.pdf');
    }
}
