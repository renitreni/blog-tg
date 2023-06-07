<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $post = Post::query()
                ->when($request->get('query'), function ($query) use ($request) {
                    $query->orderBy('title', 'LIKE',  "%{$request->get('query')}%");
                })
                ->when($request->get('sort_by') && $request->get('sort_column'), function ($query) use ($request) {
                    $query->orderBy($request->get('sort_column'), $request->get('sort_by'));
                })
                ->paginate($request->get('limit', 10));

            return PostResource::collection($post);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            $post = Post::create([
                'title' => $request->get('title'),
                'publication_date' => now(),
                'content' => $request->get('content')
            ]);

            $post->category()->create([
                'category_id' => $request->get('category_id')
            ]);

            return response()->json(['message' => 'succes']);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        try {
            $post->update([
                'title' => $request->get('title'),
                'publication_date' => $request->get('publication_date'),
                'content' => $request->get('content')
            ]);

            $post->category()->update([
                'category_id' => $request->get('category_id')
            ]);

            return response()->json(['message' => 'succes']);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
