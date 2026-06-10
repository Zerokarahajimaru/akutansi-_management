<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\StokBarang;
use App\Models\DataBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;

class ReportController extends Controller
{
    public function pembelian(Request $request)
    {
        $start_date = $request->input('start_date', Carbon::now()->subMonth()->toDateString());
        $end_date = $request->input('end_date', Carbon::now()->toDateString());
        $search = $request->input('search');

        $query = Pembelian::with(['dataBarang', 'pemasok', 'user'])
            ->whereBetween('Tgl_Pembelian', [$start_date, $end_date]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('ID_Pembelian', 'ilike', "%{$search}%")
                  ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                  ->orWhere('ID_Pemasok', 'ilike', "%{$search}%")
                  ->orWhereHas('dataBarang', function($sub) use ($search) {
                      $sub->where('Nama_Barang', 'ilike', "%{$search}%");
                  })
                  ->orWhereHas('pemasok', function($sub) use ($search) {
                      $sub->where('Nama_Pemasok', 'ilike', "%{$search}%");
                  });
            });
        }

        $pembelians = $query->orderBy('Tgl_Pembelian', 'desc')->get();

        // Analytics Summary
        $summary = [
            'total_pengeluaran' => $pembelians->sum('Total_Harga'),
            'total_barang_masuk' => $pembelians->sum('Kuantitas'),
            'top_pemasok' => $pembelians->groupBy('ID_Pemasok')->map->count()->sortDesc()->keys()->first() 
                ? (\App\Models\Pemasok::find($pembelians->groupBy('ID_Pemasok')->map->count()->sortDesc()->keys()->first())->Nama_Pemasok ?? '-') 
                : '-'
        ];

        return view('laporan.pembelian', compact('pembelians', 'start_date', 'end_date', 'summary'));
    }

    public function penjualan(Request $request)
    {
        $start_date = $request->input('start_date', Carbon::now()->subMonth()->toDateString());
        $end_date = $request->input('end_date', Carbon::now()->toDateString());
        $search = $request->input('search');

        $query = Penjualan::with(['dataBarang', 'pelanggan', 'user'])
            ->whereBetween('Tanggal_Penjualan', [$start_date, $end_date]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('ID_Penjualan', 'ilike', "%{$search}%")
                  ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                  ->orWhere('ID_Pelanggan', 'ilike', "%{$search}%")
                  ->orWhereHas('dataBarang', function($sub) use ($search) {
                      $sub->where('Nama_Barang', 'ilike', "%{$search}%");
                  })
                  ->orWhereHas('pelanggan', function($sub) use ($search) {
                      $sub->where('Nama_Pelanggan', 'ilike', "%{$search}%");
                  });
            });
        }

        $penjualans = $query->orderBy('Tanggal_Penjualan', 'desc')->get();

        // Analytics Summary
        $summary = [
            'total_pendapatan' => $penjualans->sum('Total_Harga'),
            'total_transaksi' => $penjualans->count(),
            'best_seller' => $penjualans->groupBy('ID_Barang')->map->sum('Kuantitas')->sortDesc()->keys()->first()
                ? (\App\Models\DataBarang::find($penjualans->groupBy('ID_Barang')->map->sum('Kuantitas')->sortDesc()->keys()->first())->Nama_Barang ?? '-')
                : '-'
        ];

        return view('laporan.penjualan', compact('penjualans', 'start_date', 'end_date', 'summary'));
    }

    public function stok(Request $request)
    {
        $search = $request->input('search');

        $query = StokBarang::with('dataBarang');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('ID_Stok', 'ilike', "%{$search}%")
                  ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                  ->orWhereHas('dataBarang', function($sub) use ($search) {
                      $sub->where('Nama_Barang', 'ilike', "%{$search}%")
                          ->orWhere('Jenis_Barang', 'ilike', "%{$search}%");
                  });
            });
        }

        $stoks = $query->get();

        // Analytics Summary
        $summary = [
            'valuasi_aset' => $stoks->sum(fn($s) => $s->Stok_Akhir * ($s->dataBarang->Harga_Beli ?? 0)),
            'stok_aman' => $stoks->where('Stok_Akhir', '>=', 10)->count(),
            'stok_kritis' => $stoks->where('Stok_Akhir', '<', 10)->count(),
        ];

        return view('laporan.stok', compact('stoks', 'summary'));
    }

    public function exportExcel(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');
        $start_date = $request->input('start_date', Carbon::now()->subMonth()->toDateString());
        $end_date = $request->input('end_date', Carbon::now()->toDateString());

        $data = collect([]);
        $headings = [];
        $filename = "Ekspor_Laporan_" . ucfirst($type) . "_" . date('Ymd_His') . ".xlsx";

        try {
            if ($type === 'pembelian') {
                $query = Pembelian::with(['dataBarang', 'pemasok', 'user'])
                    ->whereBetween('Tgl_Pembelian', [$start_date, $end_date]);
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('ID_Pembelian', 'ilike', "%{$search}%")
                          ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                          ->orWhere('ID_Pemasok', 'ilike', "%{$search}%")
                          ->orWhereHas('dataBarang', function($sub) use ($search) {
                              $sub->where('Nama_Barang', 'ilike', "%{$search}%");
                          })
                          ->orWhereHas('pemasok', function($sub) use ($search) {
                              $sub->where('Nama_Pemasok', 'ilike', "%{$search}%");
                          });
                    });
                }
                $data = $query->orderBy('Tgl_Pembelian', 'desc')->get()->map(function($item) {
                    return [
                        'ID' => $item->ID_Pembelian,
                        'Tanggal' => $item->Tgl_Pembelian,
                        'Produk' => $item->dataBarang->Nama_Barang ?? '-',
                        'Pemasok' => $item->pemasok->Nama_Pemasok ?? '-',
                        'Kuantitas' => $item->Kuantitas,
                        'Pembayaran' => $item->jenis_pembayaran,
                        'Total Biaya' => $item->Total_Harga,
                        'Pencatat' => ($item->user->name ?? 'Sistem') . ' (' . ($item->user_id ?? '-') . ')'
                    ];
                });
                $headings = ['ID Transaksi', 'Tanggal', 'Produk', 'Pemasok', 'Kuantitas', 'Pembayaran', 'Total Biaya', 'Pencatat'];
            } elseif ($type === 'penjualan') {
                $query = Penjualan::with(['dataBarang', 'pelanggan', 'user'])
                    ->whereBetween('Tanggal_Penjualan', [$start_date, $end_date]);
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('ID_Penjualan', 'ilike', "%{$search}%")
                          ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                          ->orWhere('ID_Pelanggan', 'ilike', "%{$search}%")
                          ->orWhereHas('dataBarang', function($sub) use ($search) {
                              $sub->where('Nama_Barang', 'ilike', "%{$search}%");
                          })
                          ->orWhereHas('pelanggan', function($sub) use ($search) {
                              $sub->where('Nama_Pelanggan', 'ilike', "%{$search}%");
                          });
                    });
                }
                $data = $query->orderBy('Tanggal_Penjualan', 'desc')->get()->map(function($item) {
                    return [
                        'ID' => $item->ID_Penjualan,
                        'Tanggal' => $item->Tanggal_Penjualan,
                        'Produk' => $item->dataBarang->Nama_Barang ?? '-',
                        'Pelanggan' => $item->pelanggan->Nama_Pelanggan ?? 'Umum',
                        'Kuantitas' => $item->Kuantitas,
                        'Pembayaran' => $item->jenis_pembayaran,
                        'Total Harga' => $item->Total_Harga,
                        'Pencatat' => ($item->user->name ?? 'Sistem') . ' (' . ($item->user_id ?? '-') . ')'
                    ];
                });
                $headings = ['ID Transaksi', 'Tanggal', 'Produk', 'Nama Pelanggan', 'Kuantitas', 'Pembayaran', 'Total Harga', 'Pencatat'];
            } elseif ($type === 'stok') {
                $query = StokBarang::with('dataBarang');
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('ID_Stok', 'ilike', "%{$search}%")
                          ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                          ->orWhereHas('dataBarang', function($sub) use ($search) {
                              $sub->where('Nama_Barang', 'ilike', "%{$search}%")
                                  ->orWhere('Jenis_Barang', 'ilike', "%{$search}%");
                          });
                    });
                }
                $data = $query->get()->map(function($item) {
                    return [
                        'ID Produk' => $item->ID_Barang,
                        'Nama Produk' => $item->dataBarang->Nama_Barang ?? 'Produk Dihapus',
                        'Kategori' => $item->dataBarang->Jenis_Barang ?? '-',
                        'Stok Awal' => $item->Stok_Awal,
                        'Stok Akhir' => $item->Stok_Akhir,
                        'Status' => $item->Stok_Akhir < 10 ? 'Kritis' : 'Aman'
                    ];
                });
                $headings = ['ID Produk', 'Nama Produk', 'Kategori', 'Stok Awal', 'Stok Akhir', 'Status'];
            } else {
                return back()->with('error', 'Tipe ekspor tidak didukung.');
            }

            return Excel::download(new DataExport($data, $headings), $filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');
        $start_date = $request->input('start_date', Carbon::now()->subMonth()->toDateString());
        $end_date = $request->input('end_date', Carbon::now()->toDateString());

        $data = [];
        $headers = [];
        $title = "Laporan " . ucfirst($type);
        $period = "Periode: " . date('d M Y', strtotime($start_date)) . " s/d " . date('d M Y', strtotime($end_date));

        try {
            if ($type === 'pembelian') {
                $query = Pembelian::with(['dataBarang', 'pemasok', 'user'])
                    ->whereBetween('Tgl_Pembelian', [$start_date, $end_date]);
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('ID_Pembelian', 'ilike', "%{$search}%")
                          ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                          ->orWhere('ID_Pemasok', 'ilike', "%{$search}%")
                          ->orWhereHas('dataBarang', function($sub) use ($search) {
                              $sub->where('Nama_Barang', 'ilike', "%{$search}%");
                          })
                          ->orWhereHas('pemasok', function($sub) use ($search) {
                              $sub->where('Nama_Pemasok', 'ilike', "%{$search}%");
                          });
                    });
                }
                $results = $query->orderBy('Tgl_Pembelian', 'desc')->get();
                $summary = [
                    'total_pengeluaran' => $results->sum('Total_Harga'),
                    'total_barang_masuk' => $results->sum('Kuantitas'),
                    'top_pemasok' => $results->groupBy('ID_Pemasok')->map->count()->sortDesc()->keys()->first() 
                        ? (\App\Models\Pemasok::find($results->groupBy('ID_Pemasok')->map->count()->sortDesc()->keys()->first())->Nama_Pemasok ?? '-') 
                        : '-'
                ];
                $headers = ['Tanggal', 'Produk', 'Pemasok', 'Qty', 'Total Biaya', 'Pencatat'];
                foreach ($results as $item) {
                    $data[] = [
                        $item->Tgl_Pembelian ? date('d/m/Y', strtotime($item->Tgl_Pembelian)) : '-',
                        $item->dataBarang->Nama_Barang ?? '-',
                        $item->pemasok->Nama_Pemasok ?? '-',
                        $item->Kuantitas,
                        'Rp ' . number_format($item->Total_Harga, 0, ',', '.'),
                        ($item->user->name ?? 'Sistem') . ' (' . ($item->user_id ?? '-') . ')'
                    ];
                }
            } elseif ($type === 'penjualan') {
                $query = Penjualan::with(['dataBarang', 'pelanggan', 'user'])
                    ->whereBetween('Tanggal_Penjualan', [$start_date, $end_date]);
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('ID_Penjualan', 'ilike', "%{$search}%")
                          ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                          ->orWhere('ID_Pelanggan', 'ilike', "%{$search}%")
                          ->orWhereHas('dataBarang', function($sub) use ($search) {
                              $sub->where('Nama_Barang', 'ilike', "%{$search}%");
                          })
                          ->orWhereHas('pelanggan', function($sub) use ($search) {
                              $sub->where('Nama_Pelanggan', 'ilike', "%{$search}%");
                          });
                    });
                }
                $results = $query->orderBy('Tanggal_Penjualan', 'desc')->get();
                $summary = [
                    'total_pendapatan' => $results->sum('Total_Harga'),
                    'total_transaksi' => $results->count(),
                    'best_seller' => $results->groupBy('ID_Barang')->map->sum('Kuantitas')->sortDesc()->keys()->first()
                        ? (\App\Models\DataBarang::find($results->groupBy('ID_Barang')->map->sum('Kuantitas')->sortDesc()->keys()->first())->Nama_Barang ?? '-')
                        : '-'
                ];
                $headers = ['Tanggal', 'Produk', 'Pelanggan', 'Qty', 'Total Harga', 'Pencatat'];
                foreach ($results as $item) {
                    $data[] = [
                        $item->Tanggal_Penjualan ? date('d/m/Y', strtotime($item->Tanggal_Penjualan)) : '-',
                        $item->dataBarang->Nama_Barang ?? '-',
                        $item->pelanggan->Nama_Pelanggan ?? 'Umum',
                        $item->Kuantitas,
                        'Rp ' . number_format($item->Total_Harga, 0, ',', '.'),
                        ($item->user->name ?? 'Sistem') . ' (' . ($item->user_id ?? '-') . ')'
                    ];
                }
            } elseif ($type === 'stok') {
                $period = "Per Tanggal: " . date('d M Y');
                $query = StokBarang::with('dataBarang');
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('ID_Stok', 'ilike', "%{$search}%")
                          ->orWhere('ID_Barang', 'ilike', "%{$search}%")
                          ->orWhereHas('dataBarang', function($sub) use ($search) {
                              $sub->where('Nama_Barang', 'ilike', "%{$search}%")
                                  ->orWhere('Jenis_Barang', 'ilike', "%{$search}%");
                          });
                    });
                }
                $results = $query->get();
                $summary = [
                    'valuasi_aset' => $results->sum(fn($s) => $s->Stok_Akhir * ($s->dataBarang->Harga_Beli ?? 0)),
                    'stok_aman' => $results->where('Stok_Akhir', '>=', 10)->count(),
                    'stok_kritis' => $results->where('Stok_Akhir', '<', 10)->count(),
                ];
                $headers = ['ID Produk', 'Nama Produk', 'Kategori', 'Stok Akhir', 'Status'];
                foreach ($results as $item) {
                    $data[] = [
                        $item->ID_Barang,
                        $item->dataBarang->Nama_Barang ?? 'Dihapus',
                        $item->dataBarang->Jenis_Barang ?? '-',
                        $item->Stok_Akhir,
                        $item->Stok_Akhir < 10 ? 'Kritis' : 'Aman'
                    ];
                }
            } elseif ($type === 'stok_history') {
                $stokId = $request->input('stok_id');
                $stok = StokBarang::with('dataBarang')->findOrFail($stokId);
                $title = "Kartu Riwayat Stok";
                $period = "Produk: " . $stok->dataBarang->Nama_Barang . " (" . $stok->ID_Stok . ")";
                
                $query = StokAdjustment::with('user')->where('ID_Stok', $stokId);
                if ($search) {
                    $query->where('Keterangan', 'ilike', "%{$search}%");
                }
                
                $results = $query->orderBy('created_at', 'desc')->get();
                $summary = [
                    'Total_Penyesuaian' => $results->count(),
                    'Stok_Masuk' => $results->where('Tipe', 'Masuk')->sum('Kuantitas'),
                    'Stok_Keluar' => $results->where('Tipe', 'Keluar')->sum('Kuantitas'),
                    'Saldo_Saat_Ini' => $stok->Stok_Akhir
                ];
                
                $headers = ['Waktu', 'Tipe', 'Qty', 'Keterangan', 'Petugas'];
                foreach ($results as $item) {
                    $data[] = [
                        $item->created_at->format('d/m/Y H:i'),
                        $item->Tipe,
                        ($item->Tipe === 'Masuk' ? '+' : '-') . $item->Kuantitas,
                        $item->Keterangan,
                        ($item->user->name ?? 'Sistem') . ' (' . $item->user_id . ')'
                    ];
                }
            } else {
                return back()->with('error', 'Tipe laporan tidak didukung.');
            }

            $pdf = Pdf::loadView('pdf.laporan', compact('title', 'period', 'headers', 'data', 'summary'));
            return $pdf->stream("Laporan_{$type}.pdf");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencetak PDF: ' . $e->getMessage());
        }
    }
}
