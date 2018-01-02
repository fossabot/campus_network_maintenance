@extends('user.layout.default')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <form class="form-horizontal" method="post" action="{{ url('/user/repair/create') }}">
                <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                    <label for="user_id" class="col-sm-4 control-label">报障人学号</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="user_id" id="user_id" value="{{ old('user_id') ?: session('user.id') }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                    <label for="user_name" class="col-sm-4 control-label">报障人姓名</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="user_name" id="user_name" value="{{ old('user_name') ?: session('user.name') }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('user_mobile') ? ' has-error' : '' }}">
                    <label for="user_mobile" class="col-sm-4 control-label">报障人手机号码</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="user_mobile" id="user_mobile" value="{{ old('user_mobile') }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('type_id') ? ' has-error' : '' }}">
                    <label for="type_id" class="col-sm-4 control-label">报障分类</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="type_id" id="type_id"></select>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('location_id') ? ' has-error' : '' }}">
                    <label for="location_id" class="col-sm-4 control-label">报障区域</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="location_id" id="location_id">
                            <option value="0">请选择报障区域</option>
                        </select>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('user_room') ? ' has-error' : '' }}">
                    <label for="user_room" class="col-sm-4 control-label">故障房间号</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="user_room" id="user_room" value="{{ old('user_room') }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('user_description') ? ' has-error' : '' }}">
                    <label for="user_description" class="col-sm-4 control-label">报障描述</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="user_description" id="user_description" rows="3">{{ old('user_description') }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary btn-block">创建</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
    $(function () {
        var types = @json($types);
        var type_id = '{{ old('type_id') }}';
        var location_id = '{{ old('location_id') }}';

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
            $('#location_id').append('<option value="0">请选择报障区域</option>');
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
