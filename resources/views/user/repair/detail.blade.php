@extends('user.layout.default')

@section('css')
<style type="text/css">
    dt, dd {
        margin-bottom: 5px;
    }
</style>
@endsection

@section('content')
    <div class="row text-center" style="margin-bottom: 20px;">
        <div class="col-xs-8 col-xs-offset-2"><h3>当前状态：{{ $detail->status }}</h3></div>
    </div>
    <div class="row">

        @if($detail->status_id == 1)

            <div class="col-md-6 col-md-offset-2">
                <form class="form-horizontal" method="post" action="{{ url('/user/repair/update') }}">
                    <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                        <label for="user_id" class="col-sm-4 control-label">报障人学号</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="user_id" id="user_id" value="{{ old('user_id') ?: $detail->user_id ?: session('user.id') }}" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                        <label for="user_name" class="col-sm-4 control-label">报障人姓名</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="user_name" id="user_name" value="{{ old('user_name') ?: $detail->user_name ?: session('user.name') }}" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('user_mobile') ? ' has-error' : '' }}">
                        <label for="user_mobile" class="col-sm-4 control-label">报障人手机号码</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="user_mobile" id="user_mobile" value="{{ old('user_mobile') ?: $detail->user_mobile }}" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('type_id') ? ' has-error' : '' }}">
                        <label for="type_id" class="col-sm-4 control-label">报障分类</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="type_id" id="type_id"></select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('location_id') ? ' has-error' : '' }}">
                        <label for="location_id" class="col-sm-4 control-label">报障地区</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="location_id" id="location_id">
                                <option value="0">请选择报障地区</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('user_room') ? ' has-error' : '' }}">
                        <label for="user_room" class="col-sm-4 control-label">故障房间号</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="user_room" id="user_room" value="{{ old('user_room') ?: $detail->user_room }}" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('user_description') ? ' has-error' : '' }}">
                        <label for="user_description" class="col-sm-4 control-label">报障描述</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="user_description" id="user_description" rows="3">{{ old('user_description') ?: $detail->user_description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <input type="hidden" name="id" value="{{ $detail->id }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary btn-block">修改</button>
                        </div>
                    </div>
                </form>
            </div>

        @endif

        @if($detail->status_id >= 2)

            <div class="col-md-4 col-md-offset-4">
                <dl class="dl-horizontal">
                    <dt>报障人学号</dt><dd>{{ $detail->user_id }}</dd>
                    <dt>报障人姓名</dt><dd>{{ $detail->user_name }}</dd>
                    <dt>报障人手机号码</dt><dd>{{ $detail->user_mobile }}</dd>
                    <dt>报障分类</dt><dd>{{ $detail->type->name }}</dd>
                    <dt>报障地区</dt><dd>{{ $detail->location->first }} {{ $detail->location->second }}</dd>
                    <dt>报障房间号</dt><dd>{{ $detail->user_room }}</dd>
                    <dt>报障描述</dt><dd>{{ $detail->user_description }}</dd>
                    @if($detail->user_star)<dt>用户评星</dt><dd>{{ $detail->user_star }}</dd>@endif
                    @if($detail->user_evaluation)<dt>用户评价</dt><dd>{{ $detail->user_evaluation }}</dd>@endif
                    @if($detail->created_at)<dt>创建时间</dt><dd>{{ $detail->created_at }}</dd>@endif
                    @if($detail->accepted_at)<dt>开始维修时间</dt><dd>{{ $detail->accepted_at }}</dd>@endif
                    @if($detail->repaired_at)<dt>维修完成时间</dt><dd>{{ $detail->repaired_at }}</dd>@endif
                    @if($detail->completed_at)<dt>评价时间</dt><dd>{{ $detail->completed_at }}</dd>@endif
                </dl>
            </div>

        @endif

        @if($detail->status_id == 3)

            <div class="col-md-6 col-md-offset-2">
                <form class="form-horizontal" method="post" action="{{ url('/user/repair/description') }}">
                    <div class="form-group{{ $errors->has('user_star') ? ' has-error' : '' }}">
                        <label for="user_star" class="col-sm-4 control-label">用户评星</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="user_star" id="user_star">
                                <option value="1">一星</option>
                                <option value="2">二星</option>
                                <option value="3">三星</option>
                                <option value="4">四星</option>
                                <option value="5">五星</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('user_evaluation') ? ' has-error' : '' }}">
                        <label for="user_evaluation" class="col-sm-4 control-label">用户评价</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="user_evaluation" id="user_evaluation" rows="3">{{ old('user_evaluation') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <input type="hidden" name="id" value="{{ $detail->id }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary btn-block">添加评价</button>
                        </div>
                    </div>
                </form>
            </div>

        @endif

    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(function () {
            var types = @json($types);
            var type_id = '{{ old('type_id') ?: $detail->type_id }}';
            var location_id = '{{ old('location_id') ?: $detail->location_id }}';

            $('#type_id').append('<option value="0">请选择报障分类</option>');
            types.forEach(function (item) {
                $('#type_id').append('<option value="' + item.id + '">' + item.name + '</option>');
            });

            if (parseInt(location_id) > 0) {
                $('#type_id').val(type_id)
                changeLocation(type_id);
                $('#location_id').val(location_id);
            }

            $('#type_id').on('change', function () {
                changeLocation($('#type_id').val());
            });

            function changeLocation(type_id) {
                $('#location_id').empty();
                $('#location_id').append('<option value="0">请选择报障地区</option>');
                types.forEach(function (item) {
                    if (parseInt(type_id) === item.id) {
                        item.locations.forEach(function (location) {
                            console.log(location);
                            $('#location_id').append('<option value="' + location.id + '">' + location.name + '</option>');
                        });
                    }
                });
            }
        });
    </script>
@endsection
