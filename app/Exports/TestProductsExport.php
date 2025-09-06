<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromGenerator;

class TestProductsExport implements WithHeadings, FromGenerator, ShouldQueue
{
    public function generator(): \Generator
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 100000; $i++) {
            yield [
                $i,
                $faker->word,
                $faker->sentence(3),
                1,
                $faker->randomFloat(2, 10, 9999),
                $faker->numberBetween(1, 500),
            ];
        }
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Category ID',
            'Price',
            'Stock',
        ];
    }
}
