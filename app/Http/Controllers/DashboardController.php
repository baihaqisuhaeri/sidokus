<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        // Total dokumen
        $totalDocuments = Dokumentasi::count();
        $normalDocuments = Dokumentasi::where('jenis_surat_suara', 'normal')->count();
        $tunanetraDocuments = Dokumentasi::where('jenis_surat_suara', 'tunanetra')->count();
    
        
        // Dokumen bulan ini
        $documentsThisMonth = Dokumentasi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        // Jenis pemilu yang ada (distinct)
        $totalTypes = Dokumentasi::distinct('jenis_pemilu')->count();
        
        // Tahun terakhir
        $latestYear = Dokumentasi::max('tahun') ?? 2024;
        
        // Dokumen per jenis
        $documentsByType = [
            'President' => Dokumentasi::where('jenis_pemilu', 'President')->count(),
            'DPR' => Dokumentasi::where('jenis_pemilu', 'DPR')->count(),
            'DPD' => Dokumentasi::where('jenis_pemilu', 'DPD')->count(),
            'Provinsi' => Dokumentasi::where('jenis_pemilu', 'Provinsi')->count(),
            'Kabupaten/Kota' => Dokumentasi::where('jenis_pemilu', 'Kabupaten/Kota')->count(),
        ];
        
        return view('dashboard', compact(
            'totalDocuments',
            'normalDocuments',
            'tunanetraDocuments',
            'documentsThisMonth',
            'totalTypes',
            'latestYear',
            'documentsByType'
        ));
    }
}