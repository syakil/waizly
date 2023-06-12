<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function getTask(){
        try {
            $task = Task::with('users')->get();
            $response = $task;
            return response()->json([
                'message' => 'Get Task Success',
                'data' => $response
            ],200);
        }catch (\Exception $er){
            log::debug($er);
            log::error($er->getMessage());
            return response()->json([
                'message' => 'Get Task Failed',
                'response_dev' => $er->getMessage()
            ],500);
        }
    }

    public function getTaskById($id){
        try {
            $task = Task::with('users')->where('tasks.id',$id)->first();
            $response = $task;
            return response()->json([
                'message' => 'Get Task Success',
                'data' => $response
            ],200);
        }catch (\Exception $er){
            log::debug($er);
            log::error($er->getMessage());
            return response()->json([
                'message' => 'Get Task Failed',
                'response_dev' => $er->getMessage()
            ],500);
        }
    }

    public function store(StoreRequest $request){
        Log::info('Create New Task User : ' . Auth::user() );
        try {
            $validate = $request->validated();
            $task_name = $request->task_name;
            $desc = $request->description;
            $due_date = $request->due_date;
            DB::beginTransaction();

            $task = new Task();
            $task->task_name = $task_name;
            $task->description = $desc;
            $task->due_date = $due_date;
            $task->user_id = Auth::user()->id;
            $task->save();

            DB::commit();

            Log::info('Create Task Success');

            return response()->json([
                'message'=>'Create Task Success',
                'data' => $task
            ],201);


        }catch (\Exception $er){
            DB::rollBack();
            Log::error($er->getMessage());
            Log::info('Failed Create New Task User : ' . Auth::user());
            return response()->json([
                'message' => 'Create Task Failed',
                'response_dev' => $er->getMessage()
            ]);
        }


    }

    public function update_selesai($id){

        try {
            DB::beginTransaction();
            Log::info('Update Task User : ' . Auth::user());

            $task = Task::find($id);
            $task->task_status = 'selesai';
            $task->update();


            DB::commit();
            Log::info('Update Task Success , Uset : ' . Auth::user());

            return response()->json([
                'message'=>'Update Task Success',
                'data' =>$task
            ]);

        }catch (\Exception $er){
            DB::rollBack();
            Log::info('Failed Update Task User : ' . Auth::user());
            Log::error($er->getMessage());
            Log::debug($er);

            return response([
                'message' => 'Failed Update Task',
                'response_dev' => $er->getMessage()
            ]);

        }
    }
    public function update_belumselesai($id){

        try {
            DB::beginTransaction();
            Log::info('Update Task User : ' . Auth::user());

            $task = Task::find($id);
            $task->task_status = 'belum_selesai';
            $task->update();


            DB::commit();
            Log::info('Update Task Success , Uset : ' . Auth::user());

            return response()->json([
                'message'=>'Update Task Success',
                'data' =>$task
            ]);

        }catch (\Exception $er){
            DB::rollBack();
            Log::info('Failed Update Task User : ' . Auth::user());
            Log::error($er->getMessage());
            Log::debug($er);

            return response([
                'message' => 'Failed Update Task',
                'response_dev' => $er->getMessage()
            ]);

        }
    }

    public function update(UpdateRequest $request,$id){
        try {
            Log::info('Update Status task_id : '.$id);
            $validate = $request->validated();
            $task_name = $request->task_name;
            $desc = $request->description;
            $due_date = $request->due_date;
            $task_status = $request->task_status;
            DB::beginTransaction();

            $task = Task::find($id);
            $task->task_name = $task_name;
            $task->description = $desc;
            $task->due_date = $due_date;
            $task->task_status = $task_status;
            $task->update();
            DB::commit();

            Log::info('Update Task Success');

            return response()->json([
                'message'=>'Update Task Success',
                'data' => $task
            ],200);

        }catch(\Exception $er){
            DB::rollBack();
            Log::error($er->getMessage());
            Log::info('Failed Update Task id : ' . $id);
            return response()->json([
                'message' => 'Update Task Failed',
                'response_dev' => $er->getMessage()
            ]);
        }
    }

    public function delete($id){
        try {
            Log::info('Delete Task task_id : '.$id);

            DB::beginTransaction();

            $task = Task::find($id);
            $task->delete();
            DB::commit();

            Log::info('Delete Task Success');

            return response()->json([
                'message'=>'Delete Task Success'
            ],200);

        }catch(\Exception $er){
            DB::rollBack();
            Log::error($er->getMessage());
            Log::info('Failed Delete Task id : ' . $id);
            return response()->json([
                'message' => 'Delete Task Failed',
                'response_dev' => $er->getMessage()
            ]);
        }
    }
}
