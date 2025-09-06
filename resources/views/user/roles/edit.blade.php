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
                        <input type="hidden" id="roleId" value="{{ $role->id }}">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="Nameinput" class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ $role->name }}" class="form-control"
                                        placeholder="Enter Name" id="Nameinput">
                                    <div class="invalid-feedback" id="nameError"></div>
                                </div>
                            </div>





                            <div class="col-lg-4 col-md-6">
                                <div class="mb-3">
                                    <label for="permissionSelect" class="form-label text-muted">Permissions</label>

                                    <select id="permissionSelect"
                                            name="permissions[]"
                                            class="form-control"
                                            data-choices
                                            data-choices-removeItem
                                            multiple
                                            required>
                                        <option disabled>Choose Permission</option>
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->name }}"
                                                {{ in_array($permission->name, $selectedPermission) ? 'selected' : '' }}>
                                                {{ $permission->name }}
                                            </option>

                                        @endforeach
                                    </select>

                                    <div class="invalid-feedback" id="permissionError"></div>
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


                $('#guardSelect').on('change', function () {
                let guard = $(this).val();
                let $select = $('#permissionSelect');

                // Destroy existing Choices instance if it exists
                if ($select[0].choicesInstance) {
                    $select[0].choicesInstance.destroy();
                    $select[0].choicesInstance = null;
                }

                $select.empty().append('<option value="">Choose Permission</option>');

                if (guard) {
                    $.ajax({
                        url: "{{ route('user.roles') }}",
                        type: 'GET',
                        data: { guard: guard },
                        success: function (response) {
                            response.permissions.forEach(function (permission) {
                                $select.append(
                                    '<option value="' + permission.name + '">' + permission.name + '</option>'
                                );
                            });

                            // Reinitialize Choices and store the instance
                            const instance = new Choices($select[0], {
                                removeItemButton: true
                            });
                            $select[0].choicesInstance = instance;
                        }
                    });
                }
            });


            $('#roleForm').on('submit', function(e) {
                e.preventDefault();

                $('#nameError').text('');
                $('#guardError').text('');
                $('#permissionError').text('');
                $('#Nameinput').removeClass('is-invalid');
                $('#guardSelect').removeClass('is-invalid');
                $('#permissionSelect').removeClass('is-invalid');

                let formData = {
                    name: $('#Nameinput').val(),
                    guard_name: $('#guardSelect').val(),
                    permissions: $('#permissionSelect').val(),
                    _token: $('input[name="_token"]').val(),
                };

                let roleId = $('#roleId').val();

                $.ajax({
                    url: "{{ route('user.role.update', [':id']) }}".replace(':id', roleId),
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
                                location.reload();
                            }, 1000);
                        }
                    },

                });
            });
        });
    </script>
@endsection
