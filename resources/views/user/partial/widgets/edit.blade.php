<div class="widget-edit-form mb-3">
    <form id="editWidgetForm{{ $widget->id }}" method="POST" action="{{ route('user.widget.update', [$widget->id]) }}">
        @csrf
        <div class="row">
            <!-- Title -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="edit_widget_title_{{ $widget->id }}">Title</label>
                    <textarea name="title" id="edit_widget_title_{{ $widget->id }}" class="form-control"
                        rows="2">{{ $widget->title }}</textarea>
                    <div class="invalid-feedback" id="editWidgetTitleError_{{ $widget->id }}"></div>
                </div>
            </div>
            <!-- Description -->
            <div class="col-md-12 mt-3">
                <div class="mb-3">
                    <label for="edit_widget_description_{{ $widget->id }}" class="form-label">Description</label>
                    <textarea name="description" class="form-control" placeholder="Enter Description"
                        id="edit_widget_description_{{ $widget->id }}" rows="4">{{ $widget->description }}</textarea>
                    <div class="invalid-feedback" id="editWidgetDescriptionError_{{ $widget->id }}"></div>
                </div>
            </div>
            <!-- Submit Button -->
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-success">Update Widget</button>
            </div>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    let descriptionEditor{{ $widget->id }};
    ClassicEditor
        .create(document.querySelector('#edit_widget_description_{{ $widget->id }}'))
        .then(editor => {
            descriptionEditor{{ $widget->id }} = editor;
            editor.ui.view.editable.element.style.height = '200px';
            editor.ui.view.editable.element.style.overflowY = 'auto';
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    $(document).ready(function(){
        $('#editWidgetForm{{ $widget->id }}').on('submit', function(e) {
            e.preventDefault();
            // Clear previous error messages and invalid classes
            $('#editWidgetTitleError_{{ $widget->id }}').text('');
            $('#editWidgetDescriptionError_{{ $widget->id }}').text('');
            $('#edit_widget_title_{{ $widget->id }}').removeClass('is-invalid');
            $('#edit_widget_description_{{ $widget->id }}').removeClass('is-invalid');

            let formData = new FormData(this);
            formData.append('id', '{{ $widget->id }}');
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success) {
                        toastMagic.success("Success!", response.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if(errors.title) {
                        $('#editWidgetTitleError_{{ $widget->id }}').text(errors.title[0]);
                        $('#edit_widget_title_{{ $widget->id }}').addClass('is-invalid');
                    }
                    if(errors.description) {
                        $('#editWidgetDescriptionError_{{ $widget->id }}').text(errors.description[0]);
                        $('#edit_widget_description_{{ $widget->id }}').addClass('is-invalid');
                    }
                }
            });
        });
    });
</script>
