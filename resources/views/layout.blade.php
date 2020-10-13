<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>簡易見積りサービス</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    @if(Auth::check())
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary mb-2">
        <span class="navbar-brand text-white">〇△販売 簡易見積もりサービス</span>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="#">TOPページ</a>
                <a class="nav-item nav-link" href="{{route('search.index')}}">見積り検索</a>
                <a class="nav-item nav-link" href="{{route('create.index')}}">見積り新規作成</a>
            </div>
            <div class="navbar-text ml-auto">
                {{ Auth::user()->name }}さんでログイン中
            </div>
            <div class="navbar-nav ml-2">
                <a class="nav-item nav-link" href="#" id="logout">ログアウト</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </div>
    </nav>
    <main>
        <div id="app">
            @yield('content')
        </div>
    </main>
    @yield('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
      document.getElementById('logout').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('logout-form').submit();
      });
    </script>

    @else
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary mb-2">
        <span class="navbar-brand text-white">〇△販売 簡易見積もりサービス</span>
    </nav>
    @yield('content')

    @endif

</body>
</html>
