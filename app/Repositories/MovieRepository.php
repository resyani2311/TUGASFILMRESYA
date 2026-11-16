<?php

namespace App\Repositories;
use App\Models\{
    Film,
};
use App\Interfaces\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return Film::all();
    }
}
