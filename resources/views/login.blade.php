<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div id="app" class="container">
        <h1>Login</h1>
       
           
            <form id="login-form" method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">

                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                </div>
            
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
              </form>
             
              <p class="mt-3">
                Don't have an account? <a href="{{ url('register') }}">Register here</a>
            </p>
     
        @if(session('message'))
            <p>{{ session('message') }}</p>
        @endif
    </div>
</body>
</html>
