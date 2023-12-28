<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Task, Category};
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //

    public function list(){
        $tasks = Task::orderBy('id', 'desc')->get();
        return response()->json(['success' => 1, 'statusCode' => 200, 'msg' => 'Success', 'data' => $tasks]);
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title' => 'required',
            'date' => 'required|date_format:Y-m-d',
        ],[
            'category_id.required' => 'Category Id is required',
            'title.required' => 'Task Title is required',
            'date.required' => 'Date is required',
            'date.date_format' => 'Date must be in the format YYYY-MM-DD',
        ]);
        if ($validator->fails()) {
            $responseArr['message'] = $validator->messages()->first();
            return response()->json(['success' => 0, 'msg' => $responseArr]);
        }

        $task = Task::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json(['success' => 1, 'msg' => 'Success', 'data' => $task]);
    }

    public function edit(Request $request){
        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'date' => 'required|date_format:Y-m-d',
        ],[
            'task_id.required' => 'Task Id is required',
            'category_id.required' => 'Category Id is required',
            'title.required' => 'Task Title is required',
            'date.required' => 'Date is required',
            'date.date_format' => 'Date must be in the format YYYY-MM-DD',
        ]);
        if ($validator->fails()) {
            $responseArr['message'] = $validator->messages()->first();
            return response()->json(['success' => 0, 'msg' => $responseArr]);
        }

        Task::whereId($request->task_id)->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return response()->json(['success' => 1, 'msg' => 'Success']);
    }
    
    public function delete($task_id){
        Task::find($task_id)->delete();
        return response()->json(['success' => 1, 'msg' => 'Deleted Successfully']);
    }
}
