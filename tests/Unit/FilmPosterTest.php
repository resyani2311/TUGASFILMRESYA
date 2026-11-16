<?php

namespace Tests\Unit;

use App\Models\Film;
use Tests\TestCase;

class FilmPosterTest extends TestCase
{
    public function test_legacy_seeded_poster_path_uses_the_bundled_image(): void
    {
        $film = new Film(['poster' => 'storage/images/c1.jpg']);

        $this->assertSame('template/images/c1.jpg', $film->poster);
    }

    public function test_uploaded_poster_path_is_preserved(): void
    {
        $film = new Film(['poster' => 'storage/images/film-example.jpg']);

        $this->assertSame('storage/images/film-example.jpg', $film->poster);
    }
}
