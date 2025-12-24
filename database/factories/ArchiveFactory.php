<?php

namespace Database\Factories;

use App\Models\Archive;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArchiveFactory extends Factory
{
    protected $model = Archive::class;

    public function definition()
    {
        $jenis = $this->faker->randomElement(['masuk', 'keluar']);
        $status = $this->faker->randomElement(['aktif', 'arsip']);

        return [
            'nomor_surat' => strtoupper($this->faker->bothify('SUR-####-??')),
            'tanggal_surat' => $this->faker->date(),
            'jenis' => $jenis,
            'pengirim' => $this->faker->company(),
            'penerima' => $this->faker->name(),
            'perihal' => $this->faker->sentence(4),
            'ringkasan' => $this->faker->paragraph(),
            'file_path' => null,
            'storage_disk' => $this->faker->randomElement(['public', 'gdrive']),
            'original_filename' => $this->faker->optional()->word() . '.pdf',
            'file_mime' => 'application/pdf',
            'file_size' => $this->faker->numberBetween(1000, 5000000),
            'drive_file_id' => $this->faker->optional(0.3)->uuid(),
            'drive_web_view_link' => null,
            'folder' => $this->faker->randomElement(['Umum', 'Keuangan', 'Personalia', 'Teknis']),
            'tags' => implode(', ', $this->faker->words(3)),
            'status' => $status,
        ];
    }
}
