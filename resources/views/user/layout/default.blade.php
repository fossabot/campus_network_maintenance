<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="/statics/user/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB", "Microsoft YaHei", Arial, sans-serif;
            font-size: 14px;
            width: 100%;
            height: 100%;
        }

        #app {
            top: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
        }

        header {
            margin-bottom: 100px;
        }

        footer {
            text-align: center;
            font-size: 12px;
            margin-top: 100px;
        }
    </style>

    @yield('css')

</head>
<body>
<div id="app">
    <header>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                        <span class="sr-only">菜单</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('user') }}">校园网络运维系统</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('user/repair/list') }}">报障单列表</a></li>
                        <li><a href="{{ url('user/repair/create') }}">新增报障单</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">{{ session('user.name') }} {{ session('user.id') }}</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">

            @if($errors->isNotEmpty())
                <div class="row" style="margin-top: 100px;">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    </div>
                </div>
            @endif
            @yield('content')

        </div>
    </main>
    <footer>
        <p>版权所有，保留一切权利！</p>
        <p>Copyright © {{ date('Y') }} <b>江苏科技大学 张家港校区/苏州理工学院</b></p>
    </footer>
</div>
<script src="/statics/user/js/jquery.min.js"></script>
<script src="/statics/user/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#navbar').find('li').each(function () {
            if ($(this).find('a')[0].getAttribute('href') === window.location.origin + window.location.pathname) {
                $(this).addClass('active')
            } else {
                $(this).removeClass('active')
            }
        })
    })
</script>

@yield('js')

</body>
</html>
