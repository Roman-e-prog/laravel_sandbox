<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post; 
use App\Models\PostReactions; 
use Illuminate\Support\Facades\Log;

class ForumController extends Controller
{
    public function showPosts($ressort)
{
    // Filter posts by ressort
    $posts = Post::where('ressort', $ressort)->get();

    return view('forumposts', [
        'ressort' => $ressort,
        'posts' => $posts
    ]);
}
//controller to render the form
    public function create($ressort)
{
    return view('forumposts.create', compact('ressort'));
}
//api create function
public function store(Request $request, $ressort)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'blog_post_body' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'slug' => 'string',
    ]);
    $path = null;
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('posts', 'public');
    }
    $post = Post::create([
        'title' => $validated['title'],
        'username'=>auth()->user()->username,
        'blog_post_body' => $validated['blog_post_body'],
        'ressort' => $ressort,
        'user_id' => auth()->user()->id,
        'images_path'=> $path,
        'published_at' => now(),
        'slug'=>$request->slug,
        'status' => 'draft',
        'is_admin'=> auth()->user()->role === 'admin' ? true : false,
    ]);
     if ($request->expectsJson()) {
        return response()->json($post, 201);
    }

    return redirect()->route('forumposts.show', $ressort)
        ->with('success', 'Post created successfully!');
}
//details page loads with answers and by passing .answers also with the answers on answers
public function showPostDetail($ressort, $id)
{
    $post = Post::with([
            'reactions.user',             // post reactions + users
            'answers.reactions.user',     // direct answers + reactions + users
            'answers.children.reactions',  // nested answers + reactions
            'answers.children.children.reactions', // answers on answers on answers + reactions
    ])->where('ressort', $ressort)->findOrFail($id);
    $post->increment('views');
    return view('forumposts.detail', compact('ressort', 'post'),[
        'ressort'=>$ressort,
        'post'=>$post,
        'answers' => $post->answers,
    ]);
}
//edit form
public function edit($ressort, $id)
{
    $post = Post::where('ressort', $ressort)->findOrFail($id);
    return view('forumposts.edit', compact('ressort', 'post'));
}
//edit store
public function update(Request $request, $ressort, $id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'blog_post_body' => 'required|string',
        'images_path'=> 'nullable|string',
        'slug'=>'nullable|string',
    ]);
    if ($request->hasFile('image')) { 
        $validated['images_path'] = $request->file('image')->store('posts', 'public'); }
    $post = Post::where('ressort', $ressort)->findOrFail($id);
    $post->update($validated);

    return redirect()->route('forumposts.detail', [$ressort, $id])
        ->with('success', 'Post updated successfully!');
}
//edit likes
public function likes(Post $post)
{
    $user = auth()->user();
    if($user->id === $post->user_id){
        return response()->json("You cannot like you own post");
    }
    $existingLike = $post->likes()->where('user_id', $user->id)->first();

    // Check if user already disliked
    $existingDislike = $post->dislikes()->where('user_id', $user->id)->first(); 
    if ($existingLike || $existingDislike) {
        return response()->json(['error' => 'You already evaluated this post'], 403);
    }
  PostReaction::create([
    'post_id' => $post->id,
    'user_id' => auth()->id(),
    'type' => 'like',
]);
  return response()->json($post);
}
public function dislikes(Post $post)
{
    $user = auth()->user();
    if($user->id === $post->user_id){
        return response()->json("You cannot dislike you own post");
    }
    $existingLike = $post->likes()->where('user_id', $user->id)->first();

    // Check if user already disliked
    $existingDislike = $post->dislikes()->where('user_id', $user->id)->first(); 
    if ($existingLike || $existingDislike) {
        return response()->json(['error' => 'You already evaluated this post'], 403);
    }
  PostReaction::create([
    'post_id' => $post->id,
    'user_id' => auth()->id(),
    'type' => 'dislike',
]);
  return response()->json($post);
}
//delete
public function destroy($ressort, $id)
{
    $post = Post::where('ressort', $ressort)->findOrFail($id);
    $post->delete();

    return redirect()->route('forumposts.show', $ressort)
        ->with('status', 'Post deleted successfully!');
}

}