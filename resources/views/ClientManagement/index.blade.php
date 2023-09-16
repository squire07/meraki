@extends('adminlte::page')

@section('title', 'Clients')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Client Management</h1>
            </div>
            <div class="col-sm-6 text-right">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-add">Add Client</button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive" style="overflow:auto;width:100%;position:relative;">
                
                <form id="request_date" class="form-horizontal" action="{{ url('client-management') }}" method="get">
                    @csrf
                    <label for="daterange">Request Date</label>
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group form-group-sm">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm float-right" name="daterange" id="daterange" value="{{ Request::get('daterange') }}">

                                    <div class="input-group-append" onclick="document.getElementById('request_date').submit();">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <div class="input-group-append" onclick="window.location.assign('{{ url('client-management') }}')">
                                        <span class="input-group-text"><i class="fas fa-sync-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <table id="dt_clients" class="table table-bordered table-hover table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td class="text-center">{{ $client->name }}</td>
                                <td class="text-center">{{ $client->description }}</td>
                                <td class="text-center"><span class="badge {{ Helper::badge($client->status_id) }}">{{ $client->status->name }}</span></td>
                                <td class="text-center">{{ $client->created_by }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-default btn_show" 
                                    data-toggle="modal"
                                    data-target="#modal-show"
                                    data-uuid="{{ $client->uuid }}"
                                    data-client-name="{{ $client->name }}" 
                                    data-client-description="{{ $client->description }}"
                                    data-client-status_id="{{ $client->status->name}}"
                                    data-client-remarks="{{ $client->remarks }}"
                                    data-client-updated_by="{{ $client->updated_by }}">
                                    <i class="far fa-eye"></i>&nbsp;Show
                                </button>
                                <button type="button" class="btn btn-sm btn-primary btn_edit" 
                                    data-toggle="modal" 
                                    data-target="#modal-edit" 
                                    data-uuid="{{ $client->uuid }}" 
                                    data-client-name="{{ $client->name }}" 
                                    data-client-description="{{ $client->description }}"
                                    data-client-status_id="{{ $client->status->name}}"
                                    data-client-remarks="{{ $client->remarks }}">
                                    <i class="fas fa-pencil-alt"></i>&nbsp;Edit
                                </button>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>


    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Client</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="{{ route('client-management.store') }}" method="POST" id="form_modal_add" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="name">Client Name</label>
                                <input type="text" class="form-control form-control-sm" name="name" maxlength="25"  pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                            <div class="col-12">
                                <label for="name">Description</label>
                                <input type="text" class="form-control form-control-sm" name="description" maxlength="25"  pattern="[a-zA-Z0-9\s]+" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2"><i class="fas fa-save mr-2"></i>Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    {{--  modal for create --}}
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Client</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class="form-horizontal" action="" method="POST" id="form_modal_edit" autocomplete="off">
                    @method('PATCH')
                    @csrf
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="col-12">
                                <label for="name">Client Name</label>
                                <input type="text" class="form-control form-control-sm" maxlength="25" name="name" id="modal_edit_name" required pattern="[a-zA-Z0-9\s]+">
                            </div>
                            <div class="col-12">
                                <label for="code">Description</label>
                                <input type="text" class="form-control form-control-sm" maxlength="255" name="description" id="modal_edit_code" required pattern="[a-zA-Z0-9\s]+">
                            </div><br>
                            <div class="col-12">
                                <label for="">Client Status?</label><br>
                                <input type="radio" id="modal_edit_status_id" name="status" value="8" checked="checked">
                                <label for="">Active</label><br>
                                <input type="radio" id="modal_edit_status_id" name="status" value="9">
                                <label for="">Inactive</label><br>
                            </p>
                            </div>
                            <div class="col-12">
                                <label for="remarks">Remarks</label>
                                <input type="" class="form-control form-control-sm" name="remarks" id="modal_edit_remarks" required oninput="this.value = this.value.toUpperCase()" pattern="[a-zA-Z0-9\s]+">
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm m-2" id="btn_modal_edit_submit"><i class="fas fa-save mr-2"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  modal for show --}}
    <div class="modal fade" id="modal-show">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Client Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="ribbon-wrapper ribbon-lg">
                                    <div class="ribbon text-bold" id="ribbon_bg">
                                        <input type="" class="form-control form-control-sm text-center" name="status" id="modal_show_status_id" style="font-weight: bold;" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    Name: <input type="" class="form-control form-control-sm" name="name" id="modal_show_name" style="font-weight: bold;" disabled>
                                    <br>
                                    Description: <input type="text" class="form-control form-control-sm" name="description" id="modal_show_description" style="font-weight: bold;" disabled>
                                    <br>
                                    {{-- Created By: <input type="text" class="form-control form-control-sm" name="created_by" id="modal_show_created_by" style="font-weight: bold;" disabled> --}}
                                </div>
                            </div>
                        </div> 
                </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm m-2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('adminlte_js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // re-initialize the datatable
        $('#dt_clients').DataTable({
            dom: 'Bfrtip',
            // serverSide: true,
            // processing: true,
            deferRender: true,
            paging: true,
            searching: true,
            lengthMenu: [[10, 25, 50, -1], ['10 rows', '25 rows', '50 rows', "Show All"]],  
            buttons: [
                {
                    extend: 'pageLength',
                    className: 'btn-default btn-sm',
                },
            ],
            language: {
                processing: "<img src='{{ asset('images/spinloader.gif') }}' width='32px'>&nbsp;&nbsp;Loading. Please wait..."
            },
        });
    });

        $('.btn_edit').on('click', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-client-name");
            var code = $(this).attr("data-client-description");
            var remarks = $(this).attr("data-client-remarks");
            var status_id = $(this).attr("data-client-status_id");

            $('#modal_edit_name').val(name); 
            $('#modal_edit_code').val(code);
            $('#modal_show_remarks').val(remarks);
            $('#modal_show_status_id').val(status_id);

            // define the edit form action
            let action = window.location.origin + "/client-management/" + uuid;
            $('#form_modal_edit').attr('action', action);
        });

        $('.btn_show').on('click', function() {
            var uuid = $(this).attr("data-uuid");
            var name = $(this).attr("data-client-name");
            var description = $(this).attr("data-client-description");
            var remarks = $(this).attr("data-client-remarks");
            var status_id = $(this).attr("data-client-status_id");
            var created_by = $(this).attr("data-client-created_by");
            var updated_by = $(this).attr("data-client-updated_by");

            // set multiple attributes
            $('#modal_show_name').val(name);
            $('#modal_show_description').val(description);
            $('#modal_show_remarks').val(remarks);
            $('#modal_show_status_id').val(status_id);
            $('#modal_show_created_by').val(created_by);
            $('#modal_show_updated_by').val(updated_by);
        });
</script>
@endsection

@section('adminlte_js')
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>
@endsection