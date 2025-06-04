<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\BookServiceInterface;
use App\Http\Requests\BookValidator;

class BookController extends Controller
{
    protected $service;

    public function __construct(BookServiceInterface $service)
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
        $validator = BookValidator::validate($request->all());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $book = $this->service->create($request->all());
        return response()->json($book, 201);
    }

    public function update($id, Request $request)
    {
        $validator = BookValidator::validate($request->all());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return response()->json($this->service->update($id, $request->all()));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
