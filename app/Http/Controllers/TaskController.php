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
            ], $e->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
