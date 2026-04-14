<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Ideas;
use App\Models\Post;

Route::view('/', 'welcome', [
    'greeting' => 'Hello, World!',
    'name' => 'John Doe',
    'age' => 30,
    'tasks' => [
        'Learn Laravel',
        'Build a project',
        'Deploy to production',
    ],
]);

Route::view('/about', 'about');
Route::view('/contact', 'contact');

Route::get('/formtest', function(){
    $posts = Post::all();

    return view('formtest',[
        'posts' => $posts,
    ]);
});

Route::post('/formtest', function(){
    Post::create([
        'description' => request('description'),
    ]);

    return redirect('/formtest');
});

Route::delete('/formtest/{id}', function ($id) {
    Post::findOrFail($id)->delete();

    return redirect('/formtest');
});

Route::get('/delete', function(){
    Post::truncate();  

    return redirect('/formtest');
});


//index
Route::get('/posts', function(){
    $posts = Post::all();

    return view('posts.index', [
        'posts' => $posts,
    ]);
});

//show
Route::get('/posts/{post}', function (Post $post) {
    return view('posts.show', [
        'post' => $post,
    ]);
});

//edit
Route::get('/posts/{post}/edit', function (Post $post) {
    return view('posts.edit', [
        'post' => $post,
    ]);
}
);

//update
Route::patch('/posts/{post}', function (Post $post) {
    $post->update([
        'description' => request('description'),
        'updated_at' => now(),
    ]);

    return redirect('/posts' . '/' . $post->id);
}
);

// GET: show the form + list of saved emails
Route::get('/emails', function () {
    $emails = session()->get('emails', []);
    return view('emails', compact('emails'));
});

// POST: receive submitted email
Route::post('/emails', function () {
    $email = request()->input('email');

    $emails = session()->get('emails', []);
    $emails[] = $email;
    session()->put('emails', $emails);

    return redirect('/emails');
});

// DELETE: remove an email by index
Route::post('/emails/delete/{index}', function ($index) {
    $emails = session()->get('emails', []);
    array_splice($emails, $index, 1);
    session()->put('emails', $emails);
    return redirect('/emails');
});

// EDIT: update an email by index
Route::post('/emails/edit/{index}', function ($index) {
    request()->validate([
        'email' => 'required|email',
    ]);
    $emails = session()->get('emails', []);
    $emails[$index] = request()->input('email');
    session()->put('emails', $emails);
    return redirect('/emails');
});
// Temporary: clears all session emails
Route::get('/emails/clear', function () {
    session()->forget('emails');
    return redirect('/emails');
});