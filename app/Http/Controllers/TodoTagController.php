<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\TagTodo;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoTagController extends Controller
{
    /**
     * Add tags to a Todo after creating it
     * @param Request $request
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTagsToTodo(Request $request, Todo $todo)
    {
        $request->validate(
            [
                'tag_id' => 'required|array|max:3',
                'tag_id.*' => 'integer|distinct|exists:tags,id',
            ],
            [
                'tag_id.*.exists' => "The selected tag id does not exist"
            ]

        );

        foreach ($request->tag_id as $tag) {
            $tagTodo = new TagTodo();
            $tagTodo->tag_id = $tag;
            $tagTodo->todo_id = $todo->id;

            $tagTodo->save();
        }

        return $this->okResponse("Tags added to Todo Successfully", $todo);
    }

    /**
     * Get the Tags of a Todo resource
     * @param Todo $todo
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTagsOfTodo(Todo $todo)
    {
        $tags = $todo->tags;

        return $this->okResponse("Showing tags of Todo '$todo->title'", $tags);
    }

    /**
     * Store a Tag Resource
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTag(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20|unique:tags,name'
        ]);

        Tag::create(array_merge($request->only(['name']), ['user_id' => auth()->user()->id]));

        return $this->createdResponse("Tag created successfully");
    }

    /**
     * Display a specified Tag
     * @param Tag $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function showTag(Tag $tag)
    {
        return $this->okResponse("Showing tag '$tag->name'", $tag);
    }

    /**
     * Index of all Tags resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllTags()
    {
        $tags = Tag::all();

        return $this->okResponse("Showing all available tags", $tags);
    }
}
