<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductsImport implements 
    ToModel, 
    WithHeadingRow, 
    WithChunkReading, 
    WithValidation, 
    ShouldQueue, 
    SkipsOnError, 
    SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    public function model(array $row)
    {
        try {
            return new Product([
                'name'        => $row['name'] ?? null,
                'description' => $row['description'] ?? null,
                'price'       => $row['price'] ?? 0,
                'stock'       => $row['stock'] ?? 0,
                'category_id' => $row['category_id'] ?? null,
                'image'       => !empty($row['image']) ? $row['image'] : 'products/test_product.png',
                'added_by'    => 1,
                'type'        => 'test',
            ]);
        } catch (\Throwable $e) {
            Log::error('Row failed: ' . json_encode($row) . ' | Error: ' . $e->getMessage());
        }
    }

    public function chunkSize(): int
    {
        return 300;
    }

    public function rules(): array
    {
        return [
            '*.name'        => ['required', 'string', 'max:255'],
            '*.description' => ['nullable', 'string'],
            '*.price'       => ['required', 'numeric', 'min:0'],
            '*.stock'       => ['required', 'integer', 'min:0'],
            '*.category_id' => ['required', 'exists:categories,id'],
            '*.image'       => ['nullable', 'string'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.name.required'        => 'Product name is required.',
            '*.price.required'       => 'Price is required.',
            '*.stock.required'       => 'Stock is required.',
            '*.category_id.required' => 'Category is required.',
            '*.category_id.exists'   => 'Category ID is invalid.',
        ];
    }
}
