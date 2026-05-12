<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\DataBarang;
use App\Models\Admin;
use App\Models\User;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\StokBarang;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ExportImportController extends Controller
{
    public function downloadTemplate($type)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=template_{$type}.csv",
        ];

        $columns = match($type) {
            'pelanggan' => ['Nama_Pelanggan', 'Alamat_Pelanggan', 'NoTelp_Pelanggan'],
            'pemasok' => ['Nama_Pemasok', 'Alamat_Pemasok', 'NoTelp_Pemasok'],
            'barang' => ['Nama_Barang', 'Jenis_Barang', 'Warna_Barang', 'Ukuran_Barang', 'Nama_Pemasok', 'Harga_Beli', 'Harga_Jual', 'Stok_Awal'],
            'admin' => ['username', 'name', 'password', 'role', 'NoTelp_Admin'],
            'pembelian' => ['Tgl_Pembelian', 'Kuantitas', 'Jenis_Pembayaran', 'Ongkir', 'Nama_Pemasok', 'Nama_Barang'],
            'penjualan' => ['Tanggal_Penjualan', 'Kuantitas', 'Jenis_Pembayaran', 'Ongkir', 'Nama_Pelanggan', 'Nama_Barang'],
            default => []
        };

        if (empty($columns)) {
            return back()->with('error', "Template untuk tipe {$type} tidak tersedia.");
        }

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM for Excel
            fputcsv($file, $columns, ';');
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportCSV($type)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=data_{$type}_export.csv",
        ];

        $data = match($type) {
            'pelanggan' => Pelanggan::all(['Nama_Pelanggan', 'Alamat_Pelanggan', 'NoTelp_Pelanggan'])->toArray(),
            'pemasok' => Pemasok::all(['Nama_Pemasok', 'Alamat_Pemasok', 'NoTelp_Pemasok'])->toArray(),
            'barang' => DataBarang::with('pemasok')->get()->map(function($b) {
                return [
                    'Nama_Barang' => $b->Nama_Barang,
                    'Jenis_Barang' => $b->Jenis_Barang,
                    'Warna_Barang' => $b->Warna_Barang,
                    'Ukuran_Barang' => $b->Ukuran_Barang,
                    'Nama_Pemasok' => $b->pemasok->Nama_Pemasok ?? '-',
                    'Harga_Beli' => $b->Harga_Beli,
                    'Harga_Jual' => $b->Harga_Jual,
                ];
            })->toArray(),
            'admin' => Admin::with('user')->get()->map(function($a) {
                return [
                    'Username' => $a->user->username ?? '-',
                    'Nama' => $a->Nama_Admin,
                    'No_Telp' => $a->NoTelp_Admin,
                    'Role' => $a->user->role ?? '-',
                ];
            })->toArray(),
            'pembelian' => Pembelian::with(['pemasok', 'dataBarang'])->get()->map(function($p) {
                return [
                    'Tgl_Pembelian' => $p->Tgl_Pembelian,
                    'Kuantitas' => $p->Kuantitas,
                    'Jenis_Pembayaran' => $p->Jenis_Pembayaran,
                    'Ongkir' => $p->Ongkir,
                    'Nama_Pemasok' => $p->pemasok->Nama_Pemasok ?? '-',
                    'Nama_Barang' => $p->dataBarang->Nama_Barang ?? '-',
                ];
            })->toArray(),
            'penjualan' => Penjualan::with(['pelanggan', 'dataBarang'])->get()->map(function($p) {
                return [
                    'Tanggal_Penjualan' => $p->Tanggal_Penjualan,
                    'Kuantitas' => $p->Kuantitas,
                    'Jenis_Pembayaran' => $p->Jenis_Pembayaran,
                    'Ongkir' => $p->Ongkir,
                    'Nama_Pelanggan' => $p->pelanggan->Nama_Pelanggan ?? '-',
                    'Nama_Barang' => $p->dataBarang->Nama_Barang ?? '-',
                ];
            })->toArray(),
            default => []
        };

        if (empty($data) && !in_array($type, ['pelanggan', 'pemasok', 'barang', 'admin', 'pembelian', 'penjualan'])) {
            return back()->with('error', "Data untuk tipe {$type} tidak tersedia atau kosong.");
        }

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM for Excel
            if (!empty($data)) {
                fputcsv($file, array_keys($data[0]), ';'); // headers
                foreach ($data as $row) {
                    fputcsv($file, $row, ';');
                }
            } else {
                fputcsv($file, ['Data Kosong'], ';');
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function importCSV(Request $request, $type)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = fopen($request->file('file')->getRealPath(), 'r');
        
        // Skip BOM if present
        $bom = fread($file, 3);
        if ($bom != chr(0xEF).chr(0xBB).chr(0xBF)) {
            rewind($file);
        }

        $header = fgetcsv($file, 0, ';'); // Use semicolon

        DB::beginTransaction();
        try {
            $rowCount = 0;
            while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
                $rowCount++;
                if (empty($row[0])) continue;

                try {
                    match($type) {
                        'pelanggan' => Pelanggan::create([
                            'ID_Pelanggan' => 'PLG-' . strtoupper(Str::random(8)),
                            'Nama_Pelanggan' => $row[0],
                            'Alamat_Pelanggan' => $row[1],
                            'NoTelp_Pelanggan' => $row[2],
                        ]),
                        'pemasok' => Pemasok::create([
                            'ID_Pemasok' => 'PMS-' . strtoupper(Str::random(8)),
                            'Nama_Pemasok' => $row[0],
                            'Alamat_Pemasok' => $row[1],
                            'NoTelp_Pemasok' => $row[2],
                        ]),
                        'barang' => $this->importBarang($row),
                        'admin' => $this->importAdmin($row),
                        'pembelian' => $this->importPembelian($row),
                        'penjualan' => $this->importPenjualan($row),
                        default => null
                    };
                } catch (\Exception $e) {
                    throw new \Exception("Error pada baris {$rowCount}: " . $e->getMessage());
                }
            }
            DB::commit();
            fclose($file);
            return back()->with('success', "Import data {$type} berhasil.");
        } catch (\Exception $e) {
            DB::rollBack();
            if ($file) fclose($file);
            return back()->with('error', "Gagal import data: " . $e->getMessage());
        }
    }

    private function importBarang($row)
    {
        $id_barang = 'BRG-' . strtoupper(Str::random(8));
        // Use LIKE for fuzzy matching to handle small typos
        $pemasok = Pemasok::where('Nama_Pemasok', 'LIKE', '%' . $row[4] . '%')->first();
        
        if (!$pemasok) {
            throw new \Exception("Pemasok '{$row[4]}' tidak ditemukan. Pastikan nama pemasok benar atau sudah terdaftar.");
        }

        DataBarang::create([
            'ID_Barang' => $id_barang,
            'Nama_Barang' => $row[0],
            'Jenis_Barang' => $row[1],
            'Warna_Barang' => $row[2],
            'Ukuran_Barang' => $row[3],
            'ID_Pemasok' => $pemasok->ID_Pemasok,
            'Harga_Beli' => $row[5],
            'Harga_Jual' => $row[6],
        ]);

        StokBarang::create([
            'ID_Stok' => 'ST-' . strtoupper(Str::random(8)),
            'ID_Admin' => auth()->user()->ID_Admin ?? 'ADM001',
            'ID_Pemasok' => $pemasok->ID_Pemasok,
            'ID_Barang' => $id_barang,
            'Stok_Awal' => $row[7] ?? 0,
            'Stok_Akhir' => $row[7] ?? 0,
        ]);
    }

    private function importAdmin($row)
    {
        $id_admin = 'ADM-' . strtoupper(Str::random(8));
        Admin::create([
            'ID_Admin' => $id_admin,
            'Nama_Admin' => $row[1],
            'NoTelp_Admin' => $row[4],
        ]);

        User::create([
            'username' => $row[0],
            'name' => $row[1],
            'password' => Hash::make($row[2]),
            'role' => $row[3],
            'ID_Admin' => $id_admin,
        ]);
    }

    private function importPembelian($row)
    {
        $id_pembelian = 'PB-' . strtoupper(Str::random(8));
        $pemasok = Pemasok::where('Nama_Pemasok', 'LIKE', '%' . $row[4] . '%')->first();
        $barang = DataBarang::where('Nama_Barang', 'LIKE', '%' . $row[5] . '%')->first();

        if (!$pemasok) throw new \Exception("Pemasok '{$row[4]}' tidak ditemukan.");
        if (!$barang) throw new \Exception("Barang '{$row[5]}' tidak ditemukan.");

        $total_harga_barang = $barang->Harga_Beli * $row[1];
        $total_harga = $total_harga_barang + ($row[3] ?? 0);

        Pembelian::create([
            'ID_Pembelian' => $id_pembelian,
            'ID_Pemasok' => $pemasok->ID_Pemasok,
            'ID_Barang' => $barang->ID_Barang,
            'Tgl_Pembelian' => $row[0],
            'Kuantitas' => $row[1],
            'Jenis_Pembayaran' => $row[2],
            'Total_Harga_Barang' => $total_harga_barang,
            'Ongkir' => $row[3] ?? 0,
            'Total_Harga' => $total_harga,
        ]);

        $stok = StokBarang::where('ID_Barang', $barang->ID_Barang)->first();
        if ($stok) {
            $stok->increment('Stok_Akhir', $row[1]);
        }
    }

    private function importPenjualan($row)
    {
        $id_penjualan = 'PJ-' . strtoupper(Str::random(8));
        $pelanggan = Pelanggan::where('Nama_Pelanggan', 'LIKE', '%' . $row[4] . '%')->first();
        $barang = DataBarang::where('Nama_Barang', 'LIKE', '%' . $row[5] . '%')->first();

        if (!$pelanggan) throw new \Exception("Pelanggan '{$row[4]}' tidak ditemukan.");
        if (!$barang) throw new \Exception("Barang '{$row[5]}' tidak ditemukan.");

        $total_harga_barang = $barang->Harga_Jual * $row[1];
        $total_harga = $total_harga_barang + ($row[3] ?? 0);

        Penjualan::create([
            'ID_Penjualan' => $id_penjualan,
            'ID_Admin' => auth()->user()->ID_Admin ?? 'ADM001',
            'ID_Pelanggan' => $pelanggan->ID_Pelanggan,
            'ID_Barang' => $barang->ID_Barang,
            'Tanggal_Penjualan' => $row[0],
            'Kuantitas' => $row[1],
            'Jenis_Pembayaran' => $row[2],
            'Total_Harga_Barang' => $total_harga_barang,
            'Ongkir' => $row[3] ?? 0,
            'Total_Harga' => $total_harga,
        ]);

        $stok = StokBarang::where('ID_Barang', $barang->ID_Barang)->first();
        if ($stok) {
            $stok->decrement('Stok_Akhir', $row[1]);
        }
    }
}
