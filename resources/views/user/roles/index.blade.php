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
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="live-preview">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <a href="{{ route('user.role.add') }}" class="btn btn-success add-btn"
                                    id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Add</a>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control search" id="searchInput"
                                        placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="role_table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Permissions</th>

                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('user.roles.list')
                            </tbody>
                        </table>
                    </div>
                </div>
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
            // Handle the delete button click
            $('.deleteRole').on('click', function() {
                var roleId = $(this).data('id');
                var token = $('meta[name="csrf-token"]').attr(
                    'content');

                if (confirm("Are you sure you want to delete this department?")) {
                    $.ajax({
                        url: "{{ route('user.role.delete', [':id']) }}".replace(':id',
                            roleId),
                        type: 'DELETE',
                        data: {
                            _token: token,
                        },
                        success: function(response) {
                            if (response.success) {
                                Toastify({
                                    text: response.message,
                                    duration: 2000,
                                    close: true,
                                    className: "success",
                                }).showToast();
                                $('#roleRow' + roleId)
                                    .remove(); // Remove the user row from the table
                            }
                        },
                        error: function(xhr) {
                            Toastify({
                                text: 'Something went wrong. Please try again.',
                                duration: 2000,
                                close: true,
                                className: "danger",
                            }).showToast();
                        }
                    });
                }
            });
        });
</script>
<script>
    $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                let searchQuery = $(this).val();
                loadRoles(searchQuery);
            });

            function loadRoles(searchQuery = '') {
                $.ajax({
                    url: "{{ route('user.roles') }}",
                    type: 'GET',
                    data: {
                        search: searchQuery
                    },
                    success: function(response) {
                        $('tbody').html(response);
                    },
                    error: function(xhr) {
                        Toastify({
                            text: 'Something went wrong. Please try again.',
                            duration: 2000,
                            close: true,
                            className: "danger",
                        }).showToast();
                    }
                });
            }
        });
</script>
<script>
    $(document).ready(function() {
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#role_table tbody').html(data);
                    }
                });
            });
        });
</script>
@endsection
