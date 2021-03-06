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
        <div style="text-align: center;padding-top: 50px;">
            <img src="/statics/img/logo.png" style="width: 95%;max-width: 420px;">
        </div>
    </header>
    <main>
        <div class="container">

            @if($errors->isNotEmpty())
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    </div>
                </div>
            @endif

            <div class="login-form">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <form class="form-horizontal" method="post" action="{{ url('/user/auth/login') }}">
                            <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                                <label for="user_id" class="col-sm-2 control-label">学号</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="user_id" id="user_id" value="{{ old('user_id') }}" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('user_pass') ? ' has-error' : '' }}">
                                <label for="user_pass" class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="user_pass" id="user_pass" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary btn-block">登录</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p>版权所有，保留一切权利！</p>
        <p>Copyright © {{ date('Y') }} <b>江苏科技大学 张家港校区/苏州理工学院</b></p>
    </footer>
</div>
<script src="/statics/user/js/jquery.min.js"></script>
<script src="/statics/user/js/bootstrap.min.js"></script>

@yield('js')

</body>
</html>
