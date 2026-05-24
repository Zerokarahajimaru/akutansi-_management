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
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExportImportController extends Controller
{
    /**
     * Export specified data to CSV.
     */
    public function exportCSV($type)
    {
        $data = [];
        $filename = $type . "_export_" . date('Ymd_His') . ".csv";

        switch ($type) {
            case 'pelanggan':
                $data = Pelanggan::all(['ID_Pelanggan', 'Nama_Pelanggan', 'Alamat_Pelanggan', 'NoTelp_Pelanggan'])->toArray();
                $headers = ['ID_Pelanggan', 'Nama_Pelanggan', 'Alamat_Pelanggan', 'NoTelp_Pelanggan'];
                break;
            case 'pemasok':
                $data = Pemasok::all(['ID_Pemasok', 'Nama_Pemasok', 'Alamat_Pemasok', 'NoTelp_Pemasok'])->toArray();
                $headers = ['ID_Pemasok', 'Nama_Pemasok', 'Alamat_Pemasok', 'NoTelp_Pemasok'];
                break;
            case 'barang':
                $data = DataBarang::all(['ID_Barang', 'ID_Pemasok', 'Jenis_Barang', 'Nama_Barang', 'Warna_Barang', 'Ukuran_Barang', 'Harga_Beli', 'Harga_Jual'])->toArray();
                $headers = ['ID_Barang', 'ID_Pemasok', 'Jenis_Barang', 'Nama_Barang', 'Warna_Barang', 'Ukuran_Barang', 'Harga_Beli', 'Harga_Jual'];
                break;
            case 'user':
                $data = User::all(['username', 'name', 'role', 'NoTelp_User', 'Alamat_User'])->toArray();
                $headers = ['Username', 'Nama', 'Role', 'No_Telp', 'Alamat'];
                break;
            case 'pembelian':
                $data = Pembelian::all(['ID_Pembelian', 'ID_Pemasok', 'ID_Barang', 'user_id', 'Tgl_Pembelian', 'Kuantitas', 'Jenis_Pembayaran', 'Total_Harga_Barang', 'Ongkir', 'Total_Harga'])->toArray();
                $headers = ['ID_Pembelian', 'ID_Pemasok', 'ID_Barang', 'User_ID', 'Tgl_Pembelian', 'Kuantitas', 'Jenis_Pembayaran', 'Total_Harga_Barang', 'Ongkir', 'Total_Harga'];
                break;
            case 'penjualan':
                $data = Penjualan::all(['ID_Penjualan', 'user_id', 'ID_Barang', 'ID_Pelanggan', 'Tanggal_Penjualan', 'Jenis_Pembayaran', 'Total_Harga_Barang', 'Ongkir', 'Total_Harga', 'Kuantitas'])->toArray();
                $headers = ['ID_Penjualan', 'User_ID', 'ID_Barang', 'ID_Pelanggan', 'Tanggal_Penjualan', 'Jenis_Pembayaran', 'Total_Harga_Barang', 'Ongkir', 'Total_Harga', 'Kuantitas'];
                break;
            default:
                return back()->with('error', 'Tipe data tidak valid.');
        }

        if (empty($data)) {
            return back()->with('error', 'Tidak ada data untuk di-export.');
        }

        $callback = function() use ($data, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }

    /**
     * Download CSV template for import.
     */
    public function downloadTemplate($type)
    {
        $headers = [];
        $filename = "template_import_" . $type . ".csv";

        switch ($type) {
            case 'pelanggan':
                $headers = ['Nama_Pelanggan', 'Alamat_Pelanggan', 'NoTelp_Pelanggan'];
                break;
            case 'pemasok':
                $headers = ['Nama_Pemasok', 'Alamat_Pemasok', 'NoTelp_Pemasok'];
                break;
            case 'barang':
                $headers = ['Nama_Pemasok', 'Jenis_Barang', 'Nama_Barang', 'Warna_Barang', 'Ukuran_Barang', 'Harga_Beli', 'Harga_Jual', 'Stok_Awal'];
                break;
            case 'user':
                $headers = ['Username', 'Nama', 'Password', 'Role', 'No_Telp'];
                break;
            case 'pembelian':
                $headers = ['Tgl_Pembelian', 'Nama_Barang', 'Nama_Pemasok', 'Kuantitas', 'Jenis_Pembayaran', 'Ongkir'];
                break;
            case 'penjualan':
                $headers = ['Tanggal_Penjualan', 'Kuantitas', 'Jenis_Pembayaran', 'Ongkir', 'Nama_Barang', 'Nama_Pelanggan'];
                break;
            default:
                return back()->with('error', 'Tipe template tidak valid.');
        }

        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            fclose($file);
        };

        return Response::stream($callback, 200, [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ]);
    }

    /**
     * Import specified data from CSV.
     */
    public function importCSV(Request $request, $type)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        // Remove header row
        $header = array_shift($data);

        DB::beginTransaction();
        try {
            foreach ($data as $row) {
                switch ($type) {
                    case 'pelanggan':
                        $this->importPelanggan($row);
                        break;
                    case 'pemasok':
                        $this->importPemasok($row);
                        break;
                    case 'barang':
                        $this->importBarang($row);
                        break;
                    case 'user':
                        $this->importUser($row);
                        break;
                    case 'pembelian':
                        $this->importPembelian($row);
                        break;
                    case 'penjualan':
                        $this->importPenjualan($row);
                        break;
                }
            }
            DB::commit();
            return back()->with('success', 'Data ' . ucfirst($type) . ' berhasil di-import.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    private function importPelanggan($row) {
        Pelanggan::create([
            'ID_Pelanggan' => 'PLG-' . strtoupper(Str::random(8)),
            'Nama_Pelanggan' => $row[0],
            'Alamat_Pelanggan' => $row[1],
            'NoTelp_Pelanggan' => $row[2],
        ]);
    }

    private function importPemasok($row) {
        Pemasok::create([
            'ID_Pemasok' => 'PMS-' . strtoupper(Str::random(8)),
            'Nama_Pemasok' => $row[0],
            'Alamat_Pemasok' => $row[1],
            'NoTelp_Pemasok' => $row[2],
        ]);
    }

    private function importBarang($row) {
        $pemasok = Pemasok::where('Nama_Pemasok', 'like', '%' . $row[0] . '%')->first();
        if (!$pemasok) throw new \Exception("Pemasok '{$row[0]}' tidak ditemukan.");

        $id_barang = 'BRG-' . strtoupper(Str::random(8));
        DataBarang::create([
            'ID_Barang' => $id_barang,
            'ID_Pemasok' => $pemasok->ID_Pemasok,
            'Jenis_Barang' => $row[1],
            'Nama_Barang' => $row[2],
            'Warna_Barang' => $row[3],
            'Ukuran_Barang' => $row[4],
            'Harga_Beli' => $row[5],
            'Harga_Jual' => $row[6],
        ]);

        StokBarang::create([
            'ID_Stok' => 'ST-' . strtoupper(Str::random(8)),
            'user_id' => auth()->id(),
            'ID_Pemasok' => $pemasok->ID_Pemasok,
            'ID_Barang' => $id_barang,
            'Stok_Awal' => $row[7] ?? 0,
            'Stok_Akhir' => $row[7] ?? 0,
        ]);
    }

    private function importUser($row) {
        User::create([
            'username' => $row[0],
            'name' => $row[1],
            'password' => Hash::make($row[2]),
            'role' => strtolower($row[3]),
            'NoTelp_User' => $row[4] ?? '-',
            'Alamat_User' => '-',
        ]);
    }

    private function importPembelian($row) {
        $barang = DataBarang::where('Nama_Barang', 'like', '%' . $row[1] . '%')->first();
        $pemasok = Pemasok::where('Nama_Pemasok', 'like', '%' . $row[2] . '%')->first();
        if (!$barang || !$pemasok) throw new \Exception("Barang atau Pemasok tidak ditemukan.");

        $id_pembelian = 'PB-' . strtoupper(Str::random(8));
        $total_harga_barang = $barang->Harga_Beli * $row[3];
        $total_harga = $total_harga_barang + ($row[5] ?? 0);

        Pembelian::create([
            'ID_Pembelian' => $id_pembelian,
            'ID_Pemasok' => $pemasok->ID_Pemasok,
            'ID_Barang' => $barang->ID_Barang,
            'user_id' => auth()->id(),
            'Tgl_Pembelian' => $row[0],
            'Kuantitas' => $row[3],
            'Jenis_Pembayaran' => $row[4],
            'Total_Harga_Barang' => $total_harga_barang,
            'Ongkir' => $row[5] ?? 0,
            'Total_Harga' => $total_harga,
        ]);

        // Update Stock
        $stok = StokBarang::where('ID_Barang', $barang->ID_Barang)->first();
        if ($stok) {
            $stok->increment('Stok_Akhir', $row[3]);
        }
    }

    private function importPenjualan($row) {
        $barang = DataBarang::where('Nama_Barang', 'like', '%' . $row[4] . '%')->first();
        $pelanggan = Pelanggan::where('Nama_Pelanggan', 'like', '%' . $row[5] . '%')->first();
        if (!$barang || !$pelanggan) throw new \Exception("Barang atau Pelanggan tidak ditemukan.");

        $id_penjualan = 'PJ-' . strtoupper(Str::random(8));
        $total_harga_barang = $barang->Harga_Jual * $row[1];
        $total_harga = $total_harga_barang + ($row[3] ?? 0);

        Penjualan::create([
            'ID_Penjualan' => $id_penjualan,
            'user_id' => auth()->id(),
            'ID_Pelanggan' => $pelanggan->ID_Pelanggan,
            'ID_Barang' => $barang->ID_Barang,
            'Tanggal_Penjualan' => $row[0],
            'Kuantitas' => $row[1],
            'Jenis_Pembayaran' => $row[2],
            'Total_Harga_Barang' => $total_harga_barang,
            'Ongkir' => $row[3] ?? 0,
            'Total_Harga' => $total_harga,
        ]);

        // Update Stock
        $stok = StokBarang::where('ID_Barang', $barang->ID_Barang)->first();
        if ($stok) {
            $stok->decrement('Stok_Akhir', $row[1]);
        }
    }
}
