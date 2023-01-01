<?php

namespace App\Kodesign;

use App\Models\Movie;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ExcelImport implements ToCollection, WithCalculatedFormulas, WithStartRow
{
    /* @var Collection $headings */
    protected $headings;

    public function __construct($headings)
    {
        $this->headings = $headings;
    }

    /**
     * @param Collection $rows
     * @return null
     */
    public function collection(Collection $rows)
    {
        $relation_collection = [];
        foreach ($rows as $row_index => $row) {

            foreach ($this->headings as $heading_index => $person) {

                $movie_name = isset($row[$heading_index]) ? correctArabicLetters($row[$heading_index]) : null;

                if (empty($movie_name)) continue;

                $person_id = $heading_index + 1;

                $movie = Movie::firstOrCreate(
                    ['title' => $movie_name],
                    ['title' => $movie_name, 'slug' => 'mv' . uniqid()]
                );

                $relation_collection[] = [
                    'person_id' => $person_id,
                    'movie_id' => $movie->id,
                    'role' => 'actor'
                ];
            }
        }

        DB::table('movie_person')->insert($relation_collection);
    }

    public function startRow(): int
    {
        return 2;
    }
}
