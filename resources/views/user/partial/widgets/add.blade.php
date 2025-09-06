<div class="card mb-3 p-3">
    <form id="widgetForm" method="POST" action="{{ route('user.widget.add') }}" class="widget-form">
        @csrf
        <h3 class="edit-title">
            Add Widget <i class="fi fi-rr-layer-plus"></i>
        </h3>
        <hr>
        <div class="row">
            <div class="row align-items-center p-3">
                <div class="col-md-12 form-group mb-0">
                    <textarea name="title" placeholder="Enter Title" id="exampleInputTitle"
                        class="form-control">{{ old('title') }}</textarea>
                    <div class="invalid-feedback" id="titleError"></div>
                </div>
                <div class="col-md-12 form-group mb-0">
                    <div class="mb-3">
                        <label for="exampleInputDescription" class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Enter Description"
                            id="exampleInputDescription" rows="4"></textarea>
                        <div class="invalid-feedback" id="descriptionError"></div>
                    </div>

                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Add Widget</button>
                </div>
            </div>
        </div>
    </form>
    <hr />
    <!-- Existing Widget Contents Accordion (optional) -->
    <div class="col-md-12">
        @if(isset($widgets) && $widgets->count() > 0)
        <div class="accordion" id="widgetAccordion">
            @foreach($widgets as $index => $widgetEntry)
            <div class="accordion-item">
                <h2 class="accordion-header" id="widgetHeading{{ $index }}">
                    <div class="d-flex justify-content-between align-items-center w-100 pe-2">
                        <button class="accordion-button collapsed flex-grow-1 text-start" type="button"
                            data-bs-toggle="collapse" data-bs-target="#widgetCollapse{{ $index }}" aria-expanded="false"
                            aria-controls="widgetCollapse{{ $index }}">
                            {{ $widgetEntry->title }}
                        </button>
                        <button type="button" class="btn btn-sm btn-danger ms-2" data-id="{{ $widgetEntry->id }}"
                            onclick="if(confirm('Are you sure you want to delete this Widget?')) deleteWidget(this);">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </h2>
                <div id="widgetCollapse{{ $index }}" class="accordion-collapse collapse"
                    aria-labelledby="widgetHeading{{ $index }}" data-bs-parent="#widgetAccordion">
                    <div class="accordion-body">
                        {{-- Optionally include a partial to allow editing/deleting of this Widget record --}}
                        @include('user.partial.widgets.edit', ['widget' => $widgetEntry])
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p>No Widget contents added yet.</p>
        @endif
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#exampleInputDescription'))
        .then(editor => {
            editor.ui.view.editable.element.style.height = '200px';
            editor.ui.view.editable.element.style.overflowY = 'auto';
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    $(document).ready(function(){
        $('#widgetForm').on('submit', function(e) {
            e.preventDefault();

            // Clear previous error messages and classes
            $('#titleError').text('');
            $('#descriptionError').text('');
            $('#exampleInputTitle').removeClass('is-invalid');
            $('#exampleInputDescription').removeClass('is-invalid');

            // Create FormData object from the form
            let formData = new FormData(this);
            formData.append('page', '{{ $page }}');
            formData.append('page_id', '{{ $page_id }}');

            $.ajax({
                url: "{{ route('user.widget.add') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastMagic.success("Success!", response.message);
                        $('#widgetForm')[0].reset();
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.title) {
                        $('#titleError').text(errors.title[0]);
                        $('#exampleInputTitle').addClass('is-invalid');
                    }
                    if (errors.description) {
                        $('#descriptionError').text(errors.description[0]);
                        $('#exampleInputDescription').addClass('is-invalid');
                    }
                }
            });
        });
    });

    function deleteWidget(button) {
        const widgetId = $(button).data('id');

        $.ajax({
            url: `{{ route('user.widget.delete', '') }}/${widgetId}`,
            type: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    toastMagic.success("Success!", response.message);

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                toastMagic.success("Success!", "Failed to delete Widget.");
            }
        });
    }
</script>
