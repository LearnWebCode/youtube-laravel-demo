<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>

  @auth

  <div style="border: 3px solid black;">
    <h1>Welcome {{auth()->user()->name}}</h1>
    <form action="/logout" method="POST">
      @csrf
      <button>Logout</button>
    </form>
  </div>

  <div style="border: 3px solid black;">
    <h1>Create New Post</h1>
    <form action="/create-post" method="POST">
      @csrf
      <input type="text" name="title" placeholder="title">
      <textarea name="body" style="display: block; width: 100%;" placeholder="Body content"></textarea>
      <button>Create Post</button>
    </form>
  </div>

  <div style="border: 3px solid black;">
    <h1>My Posts</h1>
    @if(count($posts))
    @foreach ($posts as $post)
    <div style="background-color: #DEDEDE; padding: 10px; margin: 10px;">
      <h3>{{$post['title']}} (by {{$post->user->name}})</h3>
      {{$post['body']}}
      <p><a href="/edit-post/{{$post->id}}">Edit</a></p>
      <form action="/delete-post/{{$post->id}}" method="POST">
        @csrf
        @method('DELETE')
        <button>Delete</button>
      </form>
    </div>
    @endforeach
    @endif
  </div>

  @else

  <div style="border: 3px solid black;">
    <h1>Register</h1>
    <form action="/register" method="POST">
      @csrf
      <input type="text" name="name" placeholder="name">
      <input type="text" name="email" placeholder="email">
      <input type="password" name="password" placeholder="password">
      <button>Register</button>
    </form>
  </div>
  <div style="border: 3px solid black;">
    <h1>Login</h1>
    <form action="/login" method="POST">
      @csrf
      <input type="text" name="loginname" placeholder="name">
      <input type="password" name="loginpassword" placeholder="password">
      <button>Log In</button>
    </form>
  </div>
  @endauth

</body>
</html>