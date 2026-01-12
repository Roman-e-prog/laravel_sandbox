<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Answer;

class ForumAnswerController extends Controller
{
    //controller to render the form
    public function create(Post $post)
{
    return view('forumanswer.create', compact('post'));
}
//api create function
public function store(Request $request, Post $post)
{
    $validated = $request->validate([
        'answer_body' => 'required|string',
    ]);
    $id = $post->id;
    $ressort = $post->ressort;
    $postanswer = Answer::create([
        'post_id'=>$post->id,
        'parent_id'=>$request->input('parent_id'),
        'questioner_id'=>$post->user_id,
        'questioner_name'=>$post->username,
        'username'=>auth()->user()->username,
        'answer_body' => $validated['answer_body'],
        'user_id' => auth()->user()->id,
        'published_at' => now(),
        'is_admin'=> auth()->user()->role === 'admin' ? true : false,
    ]);
     if ($request->expectsJson()) {
        return response()->json($postanswer, 201);
    }

    return redirect()
    ->route('forumposts.detail', [
        'ressort' => $ressort,
        'id'      => $id,
    ])
    ->with('success', 'Your Answer was successfully stored');

}
//edit form
public function edit($id)
{
    
    $answer = Answer::findOrFail($id);
    return view('forumanswer.edit', compact('answer'));
}
//edit store
public function update(Request $request, $id)
{
    
    $validated = $request->validate([
        'answer_body' => 'required|string',
    ]);

    $answer = Answer::findOrFail($id);
    $post = $answer->post;
    $answer->update($validated);

    return redirect()->route('forumposts.detail', [
        'ressort'=>$post->ressort,
        'id'=>$post->id
    ])
        ->with('success', 'Post updated successfully!');
}
//delete
public function destroy($id)
{
    $answer = Answer::findOrFail($id);
    $post = $answer->post;
    $answer->delete();

    return redirect()->route('forumposts.detail', [
        'ressort'=>$post->ressort,
        'id'=>$post->id,
    ])
        ->with('status', 'Post deleted successfully!');
}

}
