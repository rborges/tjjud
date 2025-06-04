<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\Contracts\AuthorServiceInterface;

class AuthorController extends Controller
{
    protected $service;

    public function __construct(AuthorServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function show($id)
    {
        return response()->json($this->service->get($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:20',
            // Opcional: permitir books no momento da criação
            'book_ids' => 'array',
            'book_ids.*' => 'integer|exists:books,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Criação via service
        $author = $this->service->create($data);

        return response()->json($author, 201);
    }

    public function update($id, Request $request)
    {
        $request->validate(['name' => 'required|string|max:40']);
        return response()->json($this->service->update($id, $request->all()));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
