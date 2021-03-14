
@extends('layout')

@section('content')
<div style="margin-top: 60px;"></div>
<div class="alerts pt-2 pb-2 pl-5 pr-5">
    @if(session('ok'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('ok') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
       </div>
       
    @endif
    @error('error')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
       </div>
    @enderror
</div>
<div class="container-fluid">
    <div style="display: flex; align-items: flex-start; justify-content: space-between;" class="mb-2 mt-1">
        <div style="display: flex;">
            <input type="text" class="form-control mr-2" style="max-width: 300px;" name="daterange" value="" readonly/>
            <button class="btn btn-primary mr-1" type="submit" onclick="searchAcessUser()">Search</button>
            <a class="btn btn-secondary" href="/access-activity/{{Request::segment(2)}}" type="submit">Clear</a>
        </div>
    </div>
    <table class="table table-sm table-bordered">
        <thead>
            <tr class="table-secondary">
                <th scope="col">#</th>
                <th scope="col">Administrator ID</th>
                <th scope="col">Administrator</th>
                <th scope="col">User access ID</th>
                <th scope="col">User access</th>
                <th scope="col">Created At</th>
                <th scope="col">Confirmed</th>
            </tr>
        </thead>
        <tbody>
            @foreach($access as $item)
            <tr>
                <th scope="row">{{ $item->id }}</th>
                <td>{{ $item->users_admin_all->id }} </td>
                <td>{{ $item->users_admin_all->firstname }} {{ $item->users_admin_all->middlename }} {{ $item->users_admin_all->lastname }}</td>
                <td>{{ $item->users_access_all->id }}</td>
                <td>{{ $item->users_access_all->firstname }} {{ $item->users_access_all->middlename }} {{ $item->users_access_all->lastname }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->confirmed ? 'TRUE' : 'FALSE' }}</td>
            </tr>

            @endforeach
        </tbody>
    </table>
    
    <input type="hidden" name="user_id" id="user_id" value="{{Request::segment(2)}}">
    
    <div class="d-flex justify-content-center">
        {!! $access->links() !!}
    </div>    
</div>

@endsection

@section('scripts')
    <script>
        let date_init = ''
        let date_end= ''

        function searchAcessUser() {
            let user_id = $('#user_id').val()
            if (user_id && date_init && date_end) {
                window.location = `/search-access-user/${user_id}?date_init=${date_init}&date_end=${date_end}`
            }else{
                alert('User identification or dates is empty')
            }
        }

        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            autoUpdateInput: false,
        }, function(start, end, label) {
            //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            date_init = start.format('YYYY-MM-DD')
            date_end = end.format('YYYY-MM-DD')
            
        });

        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    </script>
@endsection
