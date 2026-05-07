<?php

namespace App\Services\Tools\Contracts;

interface AIToolInterface
{
    /**
     * Nama fungsi yang akan dikirim ke Gemini.
     */
    public function getName(): string;

    /**
     * Deskripsi fungsi untuk Gemini.
     */
    public function getDescription(): string;

    /**
     * Skema parameter dalam format Gemini JSON Schema.
     */
    public function getParametersSchema(): array;

    /**
     * Eksekusi fungsi dan return hasil.
     */
    public function execute(array $args, $user): array;
}
