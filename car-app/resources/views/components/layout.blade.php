<!DOCTYPE html>
<html>
  <head>
    <title>{{$title}}</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link href="{{ asset('css/style.css') }}?v={{ time() }}" type="text/css" rel="stylesheet" />
  </head>
  <body>
  <nav class="navbar">
    <ul class="nav-links">
        <li><a href="/cars">Garage</a></li>
        <li><a href="/cars/create">New Purchase</a></li>
        <li><a href="/cars/about">History</a></li>
    </ul>
    <div class="search">
      <form method="GET" action="/cars">
          <input type="text" placeholder="Search..." name="search" id="search" value="{{ request('search') }}">
          <button type="submit">Go</button>
      </form>
    </div>
</nav>
    <main>
    {{$slot}}
    </main>
  </body>
</html>