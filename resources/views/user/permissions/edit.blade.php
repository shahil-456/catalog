@extends('layouts.user.master')
@section('title')
    @lang('translation.analytics')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('user.components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Roles
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Update Role</h4>
                </div>
                <div class="card-body">
                    <form id="roleForm">
                        @csrf
                        <input type="hidden" id="permissionId" value="{{ $permission->id }}">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="Nameinput" class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ $permission->name }}" class="form-control"
                                        placeholder="Enter Name" id="Nameinput">
                                    <div class="invalid-feedback" id="nameError"></div>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            const $select = $('#permissionSelect');


            $('#roleForm').on('submit', function(e) {
                e.preventDefault();

                $('#nameError').text('');
                $('#guardError').text('');
                $('#permissionError').text('');
                $('#Nameinput').removeClass('is-invalid');

                let formData = {
                    name: $('#Nameinput').val(),
                    _token: $('input[name="_token"]').val(),
                };

                let permissionId = $('#permissionId').val();

                $.ajax({
                     url: "{{ route('user.permission.update', [':id']) }}".replace(':id', permissionId),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Toastify({
                                text: response.message,
                                duration: 1000,
                                close: true,
                                className: "success",
                            }).showToast();
                           setTimeout(function() {
                                window.location.href =
                                    "{{ route('user.permissions') }}";
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#nameError').text(errors.name[0]);
                            $('#Nameinput').addClass('is-invalid');
                        }
                        if (errors.guard_name) {
                            $('#guardError').text(errors.guard_name[0]);
                            $('#guardSelect').addClass('is-invalid');
                        }
                        if (errors.permissions) {
                            $('#permissionError').text(errors.permissions[0]);
                            $('#permissionSelect').addClass('is-invalid');
                        }
                    }
                });
            });
        });
    </script>
@endsection
