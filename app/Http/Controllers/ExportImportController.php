<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\DataBarang;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ExportImportController extends Controller
{
    /**
     * Export specified data to Excel (.xlsx).
     */
    public function exportCSV($type)
    {
        $data = null;
        $headings = [];
        $filename = "Export_" . ucfirst($type) . "_" . date('Ymd_His') . ".xlsx";

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
                $data = Pembelian::with(['pemasok', 'dataBarang'])->get()->map(function($item) {
                    return [
                        'ID' => $item->ID_Pembelian,
                        'Tgl' => $item->Tgl_Pembelian,
                        'Produk' => $item->dataBarang->Nama_Barang ?? '-',
                        'Pemasok' => $item->pemasok->Nama_Pemasok ?? '-',
                        'ID_PMS' => $item->ID_Pemasok,
                        'Qty' => $item->Kuantitas,
                        'Payment' => $item->jenis_pembayaran,
                        'Total' => $item->Total_Harga
                    ];
                });
                $headings = ['ID Transaksi', 'Tanggal', 'Produk', 'Pemasok', 'ID Pemasok', 'Kuantitas', 'Metode Pembayaran', 'Total Harga'];
                break;
            case 'penjualan':
                $data = Penjualan::with(['pelanggan', 'dataBarang'])->get()->map(function($item) {
                    return [
                        'ID' => $item->ID_Penjualan,
                        'Tgl' => $item->Tanggal_Penjualan,
                        'Produk' => $item->dataBarang->Nama_Barang ?? '-',
                        'Pelanggan' => $item->pelanggan->Nama_Pelanggan ?? 'Umum',
                        'ID_PLG' => $item->ID_Pelanggan,
                        'Qty' => $item->Kuantitas,
                        'Payment' => $item->jenis_pembayaran,
                        'Total' => $item->Total_Harga
                    ];
                });
                $headings = ['ID Transaksi', 'Tanggal', 'Produk', 'Pelanggan', 'ID Pelanggan', 'Kuantitas', 'Metode Pembayaran', 'Total Harga'];
                break;
            default:
                return back()->with('error', 'Format ekspor tidak didukung.');
        }

        return Excel::download(new DataExport($data, $headings), $filename);
    }

    /**
     * Download Excel template for import.
     */
    public function downloadTemplate($type)
    {
        $headings = [];
        $filename = "Template_Impor_" . ucfirst($type) . ".xlsx";

        switch ($type) {
            case 'pelanggan':
                $headings = ['Nama_Pelanggan', 'Alamat_Pelanggan', 'NoTelp_Pelanggan'];
                break;
            case 'pemasok':
                $headings = ['Nama_Pemasok', 'Alamat_Pemasok', 'NoTelp_Pemasok'];
                break;
            case 'barang':
                $headings = ['Nama_Pemasok', 'Jenis_Barang', 'Nama_Barang', 'Warna_Barang', 'Ukuran_Barang', 'Harga_Beli', 'Harga_Jual', 'Stok_Awal'];
                break;
            case 'pembelian':
                $headings = ['Tgl_Pembelian', 'Nama_Barang', 'Nama_Pemasok', 'Kuantitas', 'Jenis_Pembayaran', 'Ongkir'];
                break;
            case 'penjualan':
                $headings = ['Tanggal_Penjualan', 'Kuantitas', 'Jenis_Pembayaran', 'Ongkir', 'Nama_Barang', 'Nama_Pelanggan'];
                break;
            default:
                return back()->with('error', 'Template tidak tersedia.');
        }

        return Excel::download(new DataExport(collect([]), $headings), $filename);
    }

    /**
     * Import specified data from Excel (.xlsx).
     */
    public function importCSV(Request $request, $type)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ], [
            'csv_file.required' => 'Silakan pilih file Excel untuk diimpor.',
            'csv_file.mimes' => 'Hanya file dengan format .xlsx, .xls, atau .csv yang diperbolehkan.',
        ]);

        try {
            $data = Excel::toArray([], $request->file('csv_file'))[0];
            array_shift($data); // Remove header row

            DB::beginTransaction();
            foreach ($data as $row) {
                if (empty(array_filter($row))) continue;

                switch ($type) {
                    case 'pelanggan':
                        $this->importPelanggan($row);
                        break;
                    case 'pemasok':
                        $this->importPemasok($row);
                        break;
                    case 'barang':    $this->importBarang($row); break;
                    case 'pembelian': $this->importPembelian($row); break;
                    case 'penjualan':
                        $this->importPenjualan($row);
                        break;
                }
            }
            DB::commit();
            return back()->with('success', 'Impor data ' . ucfirst($type) . ' berhasil diselesaikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem saat memproses file impor. Silakan pastikan format file sudah benar.');
        }
    }

    private function importPelanggan($row) {
        Pelanggan::create([
            'ID_Pelanggan' => Pelanggan::generateId('PLG'),
            'Nama_Pelanggan' => $row[0],
            'Alamat_Pelanggan' => $row[1],
            'NoTelp_Pelanggan' => $row[2],
        ]);
    }

    private function importPemasok($row) {
        Pemasok::create([
            'ID_Pemasok' => Pemasok::generateId('PMS'),
            'Nama_Pemasok' => $row[0],
            'Alamat_Pemasok' => $row[1],
            'NoTelp_Pemasok' => $row[2],
        ]);
    }

    private function importBarang($row) {
        $pemasok = Pemasok::where('Nama_Pemasok', 'like', '%' . $row[0] . '%')->first();
        if (!$pemasok) throw new \Exception("Pemasok '{$row[0]}' tidak terdaftar di sistem.");

        $id_barang = DataBarang::generateId('BRG');
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

        \App\Models\StokBarang::create([
            'ID_Stok' => 'STK-' . substr($id_barang, 4),
            'user_id' => auth()->id(),
            'ID_Pemasok' => $pemasok->ID_Pemasok,
            'ID_Barang' => $id_barang,
            'Stok_Awal' => $row[7] ?? 0,
            'Stok_Akhir' => $row[7] ?? 0,
        ]);
    }

    private function importPembelian($row) {
        $barang = DataBarang::where('Nama_Barang', 'like', '%' . $row[1] . '%')->first();
        $pemasok = Pemasok::where('Nama_Pemasok', 'like', '%' . $row[2] . '%')->first();
        if (!$barang || !$pemasok) throw new \Exception("Produk atau Pemasok tidak valid.");

        $total_harga_barang = $barang->Harga_Beli * $row[3];
        $total_harga = $total_harga_barang + ($row[5] ?? 0);

        Pembelian::create([
            'ID_Pembelian' => Pembelian::generateId('PB'),
            'ID_Pemasok' => $pemasok->ID_Pemasok,
            'ID_Barang' => $barang->ID_Barang,
            'user_id' => auth()->id(),
            'Tgl_Pembelian' => $row[0],
            'Kuantitas' => $row[3],
            'jenis_pembayaran' => $row[4],
            'Total_Harga_Barang' => $total_harga_barang,
            'Ongkir' => $row[5] ?? 0,
            'Total_Harga' => $total_harga,
        ]);

        $stok = \App\Models\StokBarang::where('ID_Barang', $barang->ID_Barang)->first();
        if ($stok) $stok->increment('Stok_Akhir', $row[3]);
    }

    private function importPenjualan($row) {
        $barang = DataBarang::where('Nama_Barang', 'like', '%' . $row[4] . '%')->first();
        $pelanggan = Pelanggan::where('Nama_Pelanggan', 'like', '%' . $row[5] . '%')->first();
        if (!$barang) throw new \Exception("Data produk tidak ditemukan.");

        $total_harga_barang = $barang->Harga_Jual * $row[1];
        $total_harga = $total_harga_barang + ($row[3] ?? 0);

        Penjualan::create([
            'ID_Penjualan' => Penjualan::generateId('PJ'),
            'user_id' => auth()->id(),
            'ID_Pelanggan' => $pelanggan->ID_Pelanggan ?? 'Umum',
            'ID_Barang' => $barang->ID_Barang,
            'Tanggal_Penjualan' => $row[0],
            'Kuantitas' => $row[1],
            'jenis_pembayaran' => $row[2],
            'Total_Harga_Barang' => $total_harga_barang,
            'Ongkir' => $row[3] ?? 0,
            'Total_Harga' => $total_harga,
        ]);

        $stok = \App\Models\StokBarang::where('ID_Barang', $barang->ID_Barang)->first();
        if ($stok) $stok->decrement('Stok_Akhir', $row[1]);
    }
}
