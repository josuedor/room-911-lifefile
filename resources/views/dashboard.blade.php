
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

            <select class="form-control mr-2" id="search_by" name="search_by">
                <option value="identification">Search By</option>
                <option value="identification">Identification (default)</option>
                <option value="lastname">Last name</option>
                <option value="middlename">Middle name</option>
                <option value="firstname">First name</option>
            </select>
            <input class="form-control mr-2" type="search" name="search" id="search" placeholder="Search" aria-label="Search" value="">
            <select class="form-control mr-2" id="departments_id" name="departments_id">
                <option value="">Select a department</option>
                @foreach($departments as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <input type="text" class="form-control mr-2" style="max-width: 300px;" name="daterange" value="" readonly/>
            <button class="btn btn-primary mr-1" type="submit" onclick="searchUsers()">Search</button>
            
            <a class="btn btn-secondary" href="/dashboard" type="submit">Clear</a>
        </div>
        <div style="display: flex;">
            <button type="button" onclick="openUploadModal()" class="btn btn-primary d-flex mr-2" style="float: right;">Upload masive users</button>
            <button type="submit" onclick="saveOrEditUser()" class="btn btn-primary d-flex" style="float: right;">New employed</button>
        </div>
    </div>
    <table class="table table-sm table-bordered">
        <thead>
            <tr class="table-secondary">
                <th scope="col">#</th>
                <th scope="col">Employed ID</th>
                <th scope="col">Department</th>
                <th scope="col">Last name</th>
                <th scope="col">Middle name</th>
                <th scope="col">First name</th>
                <th scope="col">Last access</th>
                <th scope="col">Total access</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $item)
            <tr>
                <th scope="row">{{ $item->id }}</th>
                <td>{{ $item->identification }}</td>
                <td>{{ $item->deparments->name ?? '' }}</td>
                <td>{{ $item->lastname }}</td>
                <td>{{ $item->middlename }}</td>
                <td>{{ $item->firstname }}</td>
                <td>{{ $item->last_access }}</td>
                <td>{{ $item->total_accesses }}</td>
                <td>
                    <button type="button" onclick="saveOrEditUser({{$item}})" class="btn btn-success"><i class="fas fa-edit" style="color: white;"></i></button>
                    <button type="button" onclick="openModalEnable({{$item}})" class="btn btn-{{ $item->status == 'enabled' ? 'primary' : 'warning' }}" style="color: white;">{{ $item->status == 'enabled' ? 'Disabled access' : 'Enabled access' }}</button>
                    <button type="button" onclick="openModalRemove({{$item}})" class="btn btn-danger" style="color: white;"><i class="far fa-trash-alt"></i></button>
                    <a type="button" class="btn btn-secondary" style="color: white;" href="/access-activity/{{ $item->id }}" target="_blank"><i class="fas fa-history"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {!! $users->links() !!}
    </div>    
</div>

<!-- Modal Enable/disable-->
<div class="modal fade" id="enabledOrDisabledUser" tabindex="-1" aria-labelledby="enabledOrDisabledUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/user-enabled-or-disable" method="post">
            @csrf
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="enabledOrDisabledUserLabel">User Enable/Disable</h5>
            </div>
            <div class="modal-body">
            <div id="text_modal_status">
            </div>
            <input type="hidden" name="user_id" id="user_id" value="">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
            <button type="submit" class="btn btn-primary">Yes</button>
            </div>
        </div>
        </form>
    </div>
  </div>

  <div class="modal fade" id="removeUser" tabindex="-1" aria-labelledby="removeUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/remove-user" method="post">
            @csrf
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="removeUserLabel">Remove User</h5>
            </div>
            <div class="modal-body">
            <div id="text_modal_status_remove">
            </div>
            <input type="hidden" name="user_id" id="user_id_remove" value="">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
            <button type="submit" class="btn btn-primary">Yes</button>
            </div>
        </div>
        </form>
    </div>
  </div>

  <div class="modal fade" id="uploadUsersModal" tabindex="-1" aria-labelledby="uploadUsersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/upload-users" method="post" enctype="multipart/form-data">
            @csrf
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="uploadUsersModalLabel">Upload Users</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="file_user">Select file upload (xlsx format)</label>
                    <input type="file" class="form-control-file" id="file_user" name="file">
                </div>
                <br>
                <a href="/templates/TemplateUsersMasive.xlsx" target="_blank">Dowload template in excel format</a>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
            <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
        </form>
    </div>
  </div>

  <div class="modal fade" id="saveOrEditUser" tabindex="-1" aria-labelledby="saveOrEditUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/save-user" method="post">
            @csrf
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="saveOrEditUserLabel">User</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="firstname">First name *</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Jhon">
                </div>

                <div class="form-group">
                    <label for="middlename">Middle name *</label>
                    <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Fred">
                </div>

                <div class="form-group">
                    <label for="lastname">Last name *</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Doe">
                </div>

                <div class="form-group">
                    <label for="identification">Identification *</label>
                    <input type="number" class="form-control" id="identification" name="identification" placeholder="12345678">
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="jhon.doe@email.com">
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>

                <div class="form-group">
                    <label for="password">Status *</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status1" value="enabled">
                        <label class="form-check-label" for="status1">
                          Enabled
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status2" value="disabled">
                        <label class="form-check-label" for="status2">
                          Disabled
                        </label>
                      </div>
                </div>

                <div class="form-group">
                    <label for="password">Select a department *</label>
                    <select class="form-control mr-2" id="department_user" name="department">
                        @foreach($departments as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Select a role *</label>
                    <select class="form-control mr-2" id="role_user" name="role">
                        @foreach($roles as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="user_id" id="user_id_save_edit" value="">

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        </form>
    </div>
  </div>

@endsection

@section('scripts')
    <script>
        let date_init = ''
        let date_end= ''

        function openModalEnable(item){
            if (item) {
                let message = `Are you sure to ${item.status == 'enabled' ? 'DISABLE': 'ENABLE'} user?`
                $('#text_modal_status').text(message)
                $('#user_id').val(item.id)
                $('#enabledOrDisabledUser').modal({show: true})
                $(".alert").alert('close')
                return;
            }
            alert('Error: User information is not sended')
        }

        function openModalRemove(item){
            if (item) {
                let message = `Are you sure to DELETE user?`
                $('#text_modal_status_remove').text(message)
                $('#user_id_remove').val(item.id)
                $('#removeUser').modal({show: true})
                $(".alert").alert('close')
                return;
            }
            alert('Error: User information is not sended')
        }

        function openUploadModal(){
            $('#uploadUsersModal').modal('show')
            $(".alert").alert('close')
        }

        function closeModal(){
            $('#enabledOrDisabledUser').modal('hide')
            $('#removeUser').modal('hide')
            $('#saveOrEditUser').modal('hide')
            $('#uploadUsersModal').modal('hide')
            $(".alert").alert('close')
        }
        
        function saveOrEditUser(user) {
            $(".alert").alert('close')
            if (user) {
                $('#user_id_save_edit').val(user.id)
                $('#firstname').val(user.firstname)
                $('#middlename').val(user.middlename)
                $('#lastname').val(user.lastname)
                $('#identification').val(user.identification)
                $('#email').val(user.email)
                $('#password').val(user.password)
                $('#department_user').val(user.departments_id)
                $('#role_user').val(user.roles_id)

                if (user.status == 'enabled') {
                    $('#status1').prop('checked', true);
                    $('#status2').prop('checked', false);
                }else{
                    $('#status2').prop('checked', true);
                    $('#status1').prop('checked', false);
                }
                $('#saveOrEditUser').modal({show: true})
            }else{
                $('#user_id_save_edit').val('')
                $('#firstname').val('')
                $('#middlename').val('')
                $('#lastname').val('')
                $('#identification').val('')
                $('#email').val('')
                $('#password').val('')
                $('#status1').prop('checked', true);
                $('#status2').prop('checked', false);
                $('#department_user').val('')
                $('#role_user').val('')
                $('#saveOrEditUser').modal({show: true})
            }
        }

        function searchUsers() {
            let search = $('#search').val()
            let departments = $('#departments_id').val()
            let search_by = $('#search_by').val()
            if (search) {
                window.location = `/search-users?search=${search}&departments=${departments}&date_init=${date_init}&date_end=${date_end}&search_by=${search_by}`
            }else{
                alert('Search is empty')
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
