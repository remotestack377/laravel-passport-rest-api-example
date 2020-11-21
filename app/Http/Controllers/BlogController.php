<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blog = auth()->user()->blog;
 
        return response()->json([
            'success' => true,
            'data' => $blog
        ]);
    }
 
    public function show($id)
    {
        $blog = auth()->user()->blog()->find($id);
 
        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog is not available! '
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $blog->toArray()
        ], 400);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'detail' => 'required'
        ]);
 
        $blog = new Blog();
        $blog->name = $request->name;
        $blog->detail = $request->detail;
 
        if (auth()->user()->blog()->save($blog))
            return response()->json([
                'success' => true,
                'data' => $blog->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Blog could not be added!'
            ], 500);
    }
 
    public function update(Request $request, $id)
    {
        $blog = auth()->user()->blog()->find($id);
 
        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog could not be found!'
            ], 400);
        }
 
        $updated = $blog->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Blog could not be updated!'
            ], 500);
    }
 
    public function destroy($id)
    {
        $blog = auth()->user()->blog()->find($id);
 
        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog could not be found!'
            ], 400);
        }
 
        if ($blog->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Blog could not be deleted!'
            ], 500);
        }
    }
}
