@extends('user.layout.default')

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>当前状态</th>
                <th>报障人手机</th>
                <th>报障位置</th>
                <th>报障时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>

            @foreach($repairs as $repair)

                <tr>
                    <td>{{ ($repairs->currentPage() - 1) * $repairs->perPage() + $loop->iteration }}</td>
                    <td>{{ $repair->status }}</td>
                    <td>{{ $repair->user_mobile }}</td>
                    <td>{{ $repair->location->first }} {{  $repair->location->second }} {{ $repair->user_room }}</td>
                    <td>{{ $repair->created_at->format('Y-m-d H:i') }}</td>
                    <td width="80"><a href="{{ url('user/repair/detail/' . $repair->id) }}" class="btn btn-xs btn-primary">查看详情</a></td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
    <div class="text-center">
        {{ $repairs->links() }}
    </div>
@endsection
