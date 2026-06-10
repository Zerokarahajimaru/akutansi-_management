<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\DataBarang;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\StokBarang;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ExportImportController extends Controller
{
    /**
     * Export specified data to Excel (.xlsx).
     */
    public function exportCSV($type)
    {
        $data = null;
        $headings = [];
        $filename = "Ekspor_" . ucfirst($type) . "_" . date('Ymd_His') . ".xlsx";

        try {
            switch ($type) {
                case 'pelanggan':
                    $data = Pelanggan::all(['ID_Pelanggan', 'Nama_Pelanggan', 'Alamat_Pelanggan', 'NoTelp_Pelanggan']);
                    $headings = ['ID Pelanggan', 'Nama Pelanggan', 'Alamat', 'No. Telepon'];
                    break;
                case 'pemasok':
                    $data = Pemasok::all(['ID_Pemasok', 'Nama_Pemasok', 'Alamat_Pemasok', 'NoTelp_Pemasok']);
                    $headings = ['ID Pemasok', 'Nama Pemasok', 'Alamat', 'No. Telepon'];
                    break;
                case 'barang':
                    $data = DataBarang::all(['ID_Barang', 'ID_Pemasok', 'Jenis_Barang', 'Nama_Barang', 'Warna_Barang', 'Ukuran_Barang', 'Harga_Beli', 'Harga_Jual']);
                    $headings = ['ID Barang', 'ID Pemasok', 'Kategori', 'Nama Produk', 'Warna', 'Ukuran', 'Harga Beli', 'Harga Jual'];
                    break;
                case 'stok':
                    $data = StokBarang::with('dataBarang')->get()->map(function($stok) {
                        return [
                            'ID_Stok' => $stok->ID_Stok,
                            'ID_Barang' => $stok->ID_Barang,
                            'Nama_Barang' => $stok->dataBarang->Nama_Barang ?? '-',
                            'Stok_Awal' => $stok->Stok_Awal,
                            'Stok_Akhir' => $stok->Stok_Akhir,
                        ];
                    });
                    $headings = ['ID Stok', 'ID Barang', 'Nama Produk', 'Stok Awal', 'Sisa Stok'];
                    break;
                case 'user':
                    $data = User::all()->map(function($user) {
                        return [
                            'ID' => $user->id,
                            'Username' => $user->username,
                            'Nama' => $user->name,
                            'Role' => $user->role,
                            'Telp' => $user->NoTelp_User,
                            'Alamat' => $user->Alamat_User
                        ];
                    });
                    $headings = ['ID Pengguna', 'Username', 'Nama Lengkap', 'Hak Akses', 'No. Telepon', 'Alamat'];
                    break;
                case 'pembelian':
                    $data = Pembelian::with(['pemasok', 'dataBarang', 'user'])->get()->map(function($item) {
                        return [
                            'ID' => $item->ID_Pembelian,
                            'Tgl' => $item->Tgl_Pembelian,
                            'Produk' => $item->dataBarang->Nama_Barang ?? '-',
                            'Pemasok' => $item->pemasok->Nama_Pemasok ?? '-',
                            'ID_PMS' => $item->ID_Pemasok,
                            'Qty' => $item->Kuantitas,
                            'Payment' => $item->jenis_pembayaran,
                            'Total' => $item->Total_Harga,
                            'Pencatat' => ($item->user->name ?? 'Sistem') . ' (' . ($item->user_id ?? '-') . ')'
                        ];
                    });
                    $headings = ['ID Transaksi', 'Tanggal', 'Produk', 'Pemasok', 'ID Pemasok', 'Kuantitas', 'Metode Pembayaran', 'Total Harga', 'Pencatat'];
                    break;
                case 'penjualan':
                    $data = Penjualan::with(['pelanggan', 'dataBarang', 'user'])->get()->map(function($item) {
                        return [
                            'ID' => $item->ID_Penjualan,
                            'Tgl' => $item->Tanggal_Penjualan,
                            'Produk' => $item->dataBarang->Nama_Barang ?? '-',
                            'Pelanggan' => $item->pelanggan->Nama_Pelanggan ?? 'Umum',
                            'ID_PLG' => $item->ID_Pelanggan,
                            'Qty' => $item->Kuantitas,
                            'Payment' => $item->jenis_pembayaran,
                            'Total' => $item->Total_Harga,
                            'Pencatat' => ($item->user->name ?? 'Sistem') . ' (' . ($item->user_id ?? '-') . ')'
                        ];
                    });
                    $headings = ['ID Transaksi', 'Tanggal', 'Produk', 'Pelanggan', 'ID Pelanggan', 'Kuantitas', 'Metode Pembayaran', 'Total Harga', 'Pencatat'];
                    break;
                default:
                    return back()->with('error', 'Format ekspor tidak didukung.');
            }

            return Excel::download(new DataExport($data, $headings), $filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }
}
