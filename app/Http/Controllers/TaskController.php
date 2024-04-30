<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service)
    {   
        
    }
    
    public function index() {
        try 
        {
            return response()->json($this->service->getAllTasks());
        }
        catch(Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function store(Request $request) {
        try 
        {
            return response()->json($this->service->setTask($request->all()), Response::HTTP_CREATED);
        }
        catch(Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Request $request) {
        try 
        {
            return response()->json($this->service->getTask($request->id));
        }
        catch(Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, int $id) {
        try 
        {
            return response()->json($this->service->updateTask($request->all(), $id));
        }
        catch(Exception $e) 
        {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id) {
        try 
        {
            return response()->json($this->service->deleteTask($id));
        }
        catch(Exception $e) 
        {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
