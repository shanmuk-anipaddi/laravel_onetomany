<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Post;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/user/{name}/{email}/{password}', function (
    $name,
    $email,
    $password
) {
    $user = new User([
        'name' => $name,
        'email' => $email,
        'password' => bcrypt($password),
    ]);
    $user->save();
});

Route::get('/create/{id}/{name}/{body}', function ($id, $name, $body) {
    $user = User::findorFail($id);
    $post = new Post(['name' => $name, 'body' => $body]);
    //$post = new Post(['name' => 'Ttitle ', 'body' => 'This is body']);
    $user->posts()->save($post);
});

Route::get('/read/{id}', function ($id) {
    $user = User::findorFail($id);
    $post = $user->posts($user);
    //dd($user);
    foreach ($user->posts as $post) {
        //dd($post);
        echo 'User Name :' . $user->name . '<br>';
        echo 'Post Name : ' . $post->name . '<br>';
        echo 'Body : ' . $post->body . '<br>';
    }
});

Route::get('/delete/{uid}/{id}', function ($uid, $id) {
    $user = User::findorFail($uid);
    $post = Post::findorFail($id);
    $user
        ->posts()
        ->where('id', '=', $id)
        ->delete();
    //$post->delete();
    return 'Done !';
});
