<?php

namespace App\Http\Controllers;

use App\Models\TagTodo;
use App\Models\Todo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TodoController extends Controller
{
    /**
     * Store Todo resource in the database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTodo(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100|unique:todos,title',
            'details' => 'required|max:500',
            'deadline_date' => 'required|after:today',
        ]);

        Todo::create(array_merge(
            $request->only(
                ['title', 'details', 'deadline_date']
            ),
            ['user_id' => auth()->user()->id]
        ));

        return $this->createdResponse("Todo Created Successfully");
    }

    /**
     * Show Todo resource from Database only created by User
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function showTodo(Todo $todo)
    {
        if ($todo->user_id != auth()->user()->id) return;

        return $this->okResponse("Todo '$todo->title' showing", $todo);
    }

    /**
     * Get all the currently authenticated User's todo
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyTodo()
    {
        $todos = Todo::whereUserId(auth()->user()->id)->get();

        return $this->okResponse("Showing all My Todo", $todos);
    }

    /**
     * Update Todo resource in Database
     * @param Request $request
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTodo(Request $request, Todo $todo)
    {
        if ($todo->user_id != auth()->user()->id) return;

        $request->validate([
            'title' => 'required|max:100|unique:todos,title',
            'details' => 'required|max:500',
            'deadline_date' => 'required|after:today',
        ]);

        $todo->update($request->only(['title', 'details', 'deadline_date']));

        return $this->okResponse("Todo '$todo->title' updated", $todo);
    }

    /**
     * Set Todo to complete and Soft delete
     * from Database
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteTodo(Todo $todo)
    {
        if ($todo->user_id != auth()->user()->id) return;

        $todo->update(['status' => 'completed']);

        $todo->delete();

        return $this->okResponse("Todo Deleted Successfully");
    }

    /**
     * Mark Todo as Complete if Pending
     * Mark Todo as Pending if Complete
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function markTodoAsCompleteOrPending(Todo $todo)
    {
        if ($todo->user_id != auth()->user()->id) return;

        $status = $todo->markTodoAsCompleteOrPending();

        return $this->okResponse("Todo '$todo->title' set to $status", $todo);
    }

    /**
     * Get all current User Completed Todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllCompletedTodo()
    {
        $todos = Todo::whereUserId(auth()->user()->id)->whereStatus('completed')->get();

        return $this->okResponse("Showing all Completed Todo", $todos);
    }

    /**
     * Get all current User Pending Todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPendingTodo()
    {
        $todos = Todo::whereUserId(auth()->user()->id)->whereStatus('pending')->get();

        return $this->okResponse("Showing all Pending Todo", $todos);
    }

}
