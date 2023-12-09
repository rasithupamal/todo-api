<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Repositories\TodoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TodoController extends Controller
{
    private $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $todos = $this->todoRepository->getAllActive();
            // return response()->json($todos, 200);
            return TodoResource::collection($todos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TodoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        try {
            $todo = $this->todoRepository->create($request->validated());
            // return response()->json($todo, 201);
            // return new TodoResource($todo);
            return (new TodoResource($todo))->response()->setStatusCode(201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try {
            $todo = $this->todoRepository->findOrFail($uuid);
            // return response()->json($todo, 200);
            return new TodoResource($todo);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Todo not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TodoRequest  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, $uuid)
    {
        try {
            $todo = $this->todoRepository->findOrFail($uuid);
            $this->todoRepository->update($todo, $request->validated());
            // return response()->json($todo, 200);
            return new TodoResource($todo);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Todo not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $todo = $this->todoRepository->findOrFail($uuid);
            $this->todoRepository->delete($todo);
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Todo not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Archive the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function archive($uuid)
    {
        try {
            $todo = $this->todoRepository->findOrFail($uuid);
            $this->todoRepository->archive($todo);
            // return response()->json($todo, 200);
            return new TodoResource($todo);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Todo not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Unarchived the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function unarchive($uuid)
    {
        try {
            $todo = $this->todoRepository->findOrFail($uuid);
            $this->todoRepository->unarchive($todo);
            // return response()->json($todo, 200);
            return new TodoResource($todo);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Todo not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display a listing of the archived resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archived()
    {
        try {
            $todos = $this->todoRepository->getAllArchived();
            // return response()->json($todos, 200);
            return TodoResource::collection($todos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
