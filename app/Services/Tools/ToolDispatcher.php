<?php

namespace App\Services\Tools;

use App\Services\Tools\Contracts\AIToolInterface;

class ToolDispatcher
{
    /**
     * @var array<string, AIToolInterface>
     */
    protected array $tools = [];

    public function __construct()
    {
        // 1. Whitelist Tools Registration
        // Hanya tool yang didaftarkan di sini yang bisa dieksekusi oleh AI.
        $this->register(new \App\Services\Tools\Actions\CheckAvailability());
        $this->register(new \App\Services\Tools\Actions\GetBillingDetails());
        $this->register(new \App\Services\Tools\Actions\CancelBooking());
        $this->register(new \App\Services\Tools\Actions\CreateBooking());
    }

    /**
     * Mendaftarkan tool ke dalam sistem.
     */
    public function register(AIToolInterface $tool): void
    {
        $this->tools[$tool->getName()] = $tool;
    }

    /**
     * Mengambil skema dari semua tool yang terdaftar untuk dikirim ke Gemini API.
     */
    public function getDefinitions(): array
    {
        return array_map(function ($tool) {
            return [
                'name' => $tool->getName(),
                'description' => $tool->getDescription(),
                'parameters' => $tool->getParametersSchema()
            ];
        }, array_values($this->tools));
    }

    /**
     * Mengeksekusi tool berdasarkan nama functionCall dari AI.
     */
    public function dispatch(string $name, array $args, $user): array
    {
        // Pencegahan Hallucination Function Call
        if (!array_key_exists($name, $this->tools)) {
            return ['error' => "Fungsi {$name} tidak dikenali sistem. Dilarang mengarang nama fungsi."];
        }

        try {
            // Eksekusi logic di dalam masing-masing Tool Action
            return $this->tools[$name]->execute($args, $user);
        } catch (\Exception $e) {
            \Log::error("Tool [{$name}] failed: " . $e->getMessage());
            return ['error' => 'Terjadi kesalahan internal pada server saat mengeksekusi fungsi ini.'];
        }
    }
}
