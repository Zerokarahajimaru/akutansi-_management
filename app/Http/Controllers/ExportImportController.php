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
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
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
            'csv_file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ], [
            'csv_file.required' => 'Silakan pilih file Excel untuk diimpor.',
            'csv_file.mimes' => 'Hanya file dengan format .xlsx, .xls, atau .csv yang diperbolehkan.',
        ]);

        try {
            $data = Excel::toArray([], $request->file('csv_file'))[0];
            
            // Audit Fix: Properly identify rows
            $rows = array_filter($data, function($row) {
                return !empty(array_filter($row));
            });
            
            if (count($rows) <= 1) {
                return back()->with('error', 'File Excel kosong atau hanya berisi baris judul.');
            }

            array_shift($rows); // Remove header row

            DB::beginTransaction();
            foreach ($rows as $index => $row) {
                try {
                    switch ($type) {
                        case 'pelanggan': $this->importPelanggan($row); break;
                        case 'pemasok':   $this->importPemasok($row); break;
                        case 'barang':    $this->importBarang($row); break;
                        case 'pembelian': $this->importPembelian($row); break;
                        case 'penjualan': $this->importPenjualan($row); break;
                    }
                } catch (\Exception $e) {
                    // Audit Fix: Pinpoint error location for bulk imports
                    throw new \Exception("Kesalahan pada baris ke-" . ($index + 2) . ": " . $e->getMessage());
                }
            }
            DB::commit();
            
            return back()->with('success', 'Impor data ' . ucfirst($type) . ' telah berhasil diselesaikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Audit Fix: Critical transparency for debugging
            return back()->with('error', 'Gagal memproses file impor: ' . $e->getMessage());
        }
    }

    private function importPelanggan($row) {
        if (empty($row[0])) throw new \Exception("Nama Pelanggan tidak boleh kosong.");
        Pelanggan::create([
            'ID_Pelanggan' => Pelanggan::generateId('PLG'),
            'Nama_Pelanggan' => $row[0],
            'Alamat_Pelanggan' => $row[1] ?? '-',
            'NoTelp_Pelanggan' => $row[2] ?? '-',
        ]);
    }

    private function importPemasok($row) {
        if (empty($row[0])) throw new \Exception("Nama Pemasok tidak boleh kosong.");
        Pemasok::create([
            'ID_Pemasok' => Pemasok::generateId('PMS'),
            'Nama_Pemasok' => $row[0],
            'Alamat_Pemasok' => $row[1] ?? '-',
            'NoTelp_Pemasok' => $row[2] ?? '-',
        ]);
    }

    private function importBarang($row) {
        if (empty($row[2])) throw new \Exception("Nama Barang tidak boleh kosong.");
        
        $pemasok = Pemasok::where('Nama_Pemasok', 'like', '%' . $row[0] . '%')->first();
        if (!$pemasok) throw new \Exception("Pemasok '{$row[0]}' tidak terdaftar dalam sistem.");

        $id_barang = DataBarang::generateId('BRG');
        DataBarang::create([
            'ID_Barang' => $id_barang,
            'ID_Pemasok' => $pemasok->ID_Pemasok,
            'Jenis_Barang' => $row[1] ?? 'Lainnya',
            'Nama_Barang' => $row[2],
            'Warna_Barang' => $row[3] ?? '-',
            'Ukuran_Barang' => $row[4] ?? 'All Size',
            'Harga_Beli' => $row[5] ?? 0,
            'Harga_Jual' => $row[6] ?? 0,
        ]);

        StokBarang::create([
            'ID_Stok' => 'STK-' . substr($id_barang, 4),
            'user_id' => auth()->id(),
            'ID_Pemasok' => $pemasok->ID_Pemasok,
            'ID_Barang' => $id_barang,
            'Stok_Awal' => $row[7] ?? 0,
            'Stok_Akhir' => $row[7] ?? 0,
            'Keterangan' => 'Import bulk otomatis',
        ]);
    }

    private function importPembelian($row) {
        $barang = DataBarang::where('Nama_Barang', 'like', '%' . $row[1] . '%')->first();
        $pemasok = Pemasok::where('Nama_Pemasok', 'like', '%' . $row[2] . '%')->first();
        
        if (!$barang) throw new \Exception("Produk '{$row[1]}' tidak ditemukan.");
        if (!$pemasok) throw new \Exception("Pemasok '{$row[2]}' tidak ditemukan.");

        $qty = (int)$row[3];
        $total_harga_barang = $barang->Harga_Beli * $qty;
        $ongkir = $row[5] ?? 0;

        $newId = Pembelian::generateId('PB');
        Pembelian::create([
            'ID_Pembelian' => $newId,
            'ID_Pemasok' => $pemasok->ID_Pemasok,
            'ID_Barang' => $barang->ID_Barang,
            'user_id' => auth()->id(),
            'Tgl_Pembelian' => $this->parseDate($row[0]),
            'Kuantitas' => $qty,
            'jenis_pembayaran' => $row[4] ?? 'Transfer',
            'Total_Harga_Barang' => $total_harga_barang,
            'Ongkir' => $ongkir,
            'Total_Harga' => $total_harga_barang + $ongkir,
        ]);

        $stok = StokBarang::where('ID_Barang', $barang->ID_Barang)->first();
        if ($stok) {
            $stok->increment('Stok_Akhir', $qty);
        }
    }

    private function importPenjualan($row) {
        $barang = DataBarang::where('Nama_Barang', 'like', '%' . $row[4] . '%')->first();
        $pelanggan = Pelanggan::where('Nama_Pelanggan', 'like', '%' . $row[5] . '%')->first();
        
        if (!$barang) throw new \Exception("Produk '{$row[4]}' tidak ditemukan.");
        // Customers are optional in import, defaults to 'Umum' if ID_Pelanggan is null in DB
        
        $qty = (int)$row[1];
        $total_harga_barang = $barang->Harga_Jual * $qty;
        $ongkir = $row[3] ?? 0;

        $stok = StokBarang::where('ID_Barang', $barang->ID_Barang)->first();
        if (!$stok || $stok->Stok_Akhir < $qty) {
            throw new \Exception("Stok produk '{$barang->Nama_Barang}' tidak mencukupi.");
        }

        $newId = Penjualan::generateId('PJ');
        Penjualan::create([
            'ID_Penjualan' => $newId,
            'user_id' => auth()->id(),
            'ID_Pelanggan' => $pelanggan->ID_Pelanggan ?? 'Umum',
            'ID_Barang' => $barang->ID_Barang,
            'Tanggal_Penjualan' => $this->parseDate($row[0]),
            'Kuantitas' => $qty,
            'jenis_pembayaran' => $row[2] ?? 'Tunai',
            'Total_Harga_Barang' => $total_harga_barang,
            'Ongkir' => $ongkir,
            'Total_Harga' => $total_harga_barang + $ongkir,
        ]);

        $stok->decrement('Stok_Akhir', $qty);
    }

    private function parseDate($value) {
        if (empty($value)) return Carbon::now();
        try {
            // Handle various date formats (DD/MM/YYYY, YYYY-MM-DD, etc)
            return Carbon::parse($value);
        } catch (\Exception $e) {
            // Fallback for Excel specific numeric formats if standard parsing fails
            if (is_numeric($value)) {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
            }
            return Carbon::now();
        }
    }
}
