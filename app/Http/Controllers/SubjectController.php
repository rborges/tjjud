<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\SubjectServiceInterface;
use App\Helpers\ValidatorHelper;

class SubjectController extends Controller
{
    protected $service;

    public function __construct(SubjectServiceInterface $service)
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
        $validator = ValidatorHelper::validate($request->all(), [
            'description' => 'required|string|max:20',
            'book_ids' => 'array',
            'book_ids.*' => 'integer|exists:books,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return response()->json($this->service->create($request->all()), 201);
    }

    public function update($id, Request $request)
    {
        $validator = ValidatorHelper::validate($request->all(), [
            'description' => 'required|string|max:20',
            'book_ids' => 'array',
            'book_ids.*' => 'integer|exists:books,id'
        ]);

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
