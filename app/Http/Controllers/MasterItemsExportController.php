<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MasterItem;

use Shuchkin\SimpleXLSXGen;

class MasterItemsExportController extends Controller
{
    public function exportExcel()
    {
        $fileName = 'master_items_' . date('Y-m-d_H-i-s') . '.xlsx';

        $items = MasterItem::with('categories')->get();

        $data = [];
        $data[] = ['No', 'Nama Kategori', 'Nama Items', 'Nama Supplier', 'Harga Beli', 'Laba', 'Harga Jual'];

        $count = 1;
        foreach ($items as $item) {
            // Get comma-separated categories
            $categoriesStr = '';
            if ($item->categories && $item->categories->count() > 0) {
                $categoriesStr = $item->categories->pluck('nama')->implode(', ');
            }

            $hargaJual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);

            $data[] = [
                $count++,
                $categoriesStr,
                $item->nama,
                $item->supplier,
                $item->harga_beli,
                $item->laba,
                round($hargaJual)
            ];
        }

        $xlsx = SimpleXLSXGen::fromArray($data);

        return response($xlsx->__toString(), 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
        ]);
    }
}
