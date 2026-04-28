<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreMovieRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MovieController extends Controller
{
    /**
     * @var MovieService
     */
    protected MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(): View
    {
        $movies = $this->movieService->getAll(request('search'));
        return view('homepage', compact('movies'));
    }

    // DETAIL
    public function detail(String $id): View
    {
        $movie = $this->movieService->getById($id);
        return view('detail', compact('movie'));
    }

    // FORM CREATE
    public function create(): View
    {
        $categories = Category::all();
        return view('input', compact('categories'));
    }

    // STORE
    public function store(StoreMovieRequest $request): RedirectResponse
    {
        $this->movieService->store(
            $request->validated(),
            $request->file('foto_sampul')
        );

        return redirect('/')->with('success', 'Film berhasil ditambahkan.');
    }

    // DATA MOVIES
    public function data(): View
    {
        $movies = $this->movieService->getAll();
        return view('data-movies', compact('movies'));
    }

    // FORM EDIT
    public function form_edit(int $id): View
    {
        $movie = $this->movieService->getById($id);
        $categories = Category::all();

        return view('form-edit', compact('movie', 'categories'));
    }

    // UPDATE
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->movieService->update(
            $id,
            $request->all(),
            $request->file('foto_sampul')
        );

        return redirect('/movies/data')->with('success', 'Data berhasil diperbarui');
    }

    // DELETE
    public function delete(int $id): RedirectResponse
    {
        $this->movieService->delete($id);

        return redirect('/movies/data')->with('success', 'Data berhasil dihapus');
    }
}
