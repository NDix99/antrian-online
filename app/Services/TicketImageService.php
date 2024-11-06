<?php

namespace App\Services;

use App\Models\Antrian;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TicketImageService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function generateTicketImage(Antrian $antrian)
    {
        // Pastikan direktori exists
        if (!file_exists(storage_path('app/public/tickets'))) {
            mkdir(storage_path('app/public/tickets'), 0755, true);
        }

        try {
            // Buat canvas dengan cara yang benar untuk v3
            $img = $this->manager->create(width: 800, height: 400);
            $img->fill('#ffffff');
            
            // Gunakan font default jika arial.ttf tidak ada
            $fontPath = file_exists(public_path('fonts/arial.ttf')) 
                ? public_path('fonts/arial.ttf')
                : 5;

            // Header - Perbaikan sintaks text untuk v3
            $img->text('NOMOR ANTRIAN', 400, 50, function($font) use ($fontPath) {
                $font->filename($fontPath);  // gunakan filename(), bukan file()
                $font->size(40);
                $font->color('#000000');
                $font->align('center');
            });

            // Nomor Antrian
            $img->text($antrian->no_antrian, 400, 150, function($font) use ($fontPath) {
                $font->filename($fontPath);  // gunakan filename(), bukan file()
                $font->size(80);
                $font->color('#000000');
                $font->align('center');
            });

            // No RM
            $img->text('No. RM: ' . $antrian->no_rm, 400, 250, function($font) use ($fontPath) {
                $font->filename($fontPath);
                $font->size(30);
                $font->color('#000000');
                $font->align('center');
            });

            // Tanggal
            $img->text('Tanggal: ' . $antrian->tanggal_kunjungan, 400, 300, function($font) use ($fontPath) {
                $font->filename($fontPath);
                $font->size(30);
                $font->color('#000000');
                $font->align('center');
            });

            $fileName = 'antrian_' . $antrian->no_antrian . '.png';
            // Gunakan encode() dan save() yang benar untuk v3
            $img->save(storage_path('app/public/tickets/' . $fileName), 'png');

            return asset('storage/tickets/' . $fileName);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error generating ticket image: ' . $e->getMessage());
            throw $e;
        }
    }
}
