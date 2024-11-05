<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Services\TicketImageService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AntrianController extends Controller
{
    protected $ticketService;

    public function __construct(TicketImageService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function ambil(Request $request)
    {
        $request->validate([
            'no_rm' => 'required|string|max:10',
        ]);

        $lastAntrian = Antrian::whereDate('created_at', now())->latest('no_antrian')->first();
        $nomorAntrian = $lastAntrian ? $lastAntrian->no_antrian + 1 : 1;

        $antrian = Antrian::create([
            'no_rm' => $request->no_rm,
            'no_antrian' => $nomorAntrian,
            'status' => 'menunggu',
            'tanggal_kunjungan' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $ticketImageUrl = $this->ticketService->generateTicketImage($antrian);

        return response()->json([
            'success' => true,
            'message' => 'Nomor antrian berhasil dibuat',
            'data' => $antrian,
            'ticket_image' => $ticketImageUrl
        ]);
    }

    public function panggilAntrian($no_antrian)
    {
        $antrian = Antrian::findOrFail($no_antrian);
        $antrian->status = 'called';
        $antrian->save();

        return response()->json([
            'success' => true,
            'message' => 'Antrian dipanggil',
            'data' => $antrian
        ]);
    }

    public function selesaiAntrian($no_antrian)
    {
        $antrian = Antrian::findOrFail($no_antrian);
        $antrian->status = 'completed';
        $antrian->save();

        return response()->json([
            'success' => true,
            'message' => 'Antrian selesai',
            'data' => $antrian
        ]);
    }

    public function getData()
    {
        return DataTables::of(Antrian::query())
            ->addIndexColumn()
            ->make(true);
    }
}

