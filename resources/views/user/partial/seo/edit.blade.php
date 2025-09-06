<div class="seo-edit-form mb-3">
    <form id="editSeoForm{{ $seo->id }}" method="POST" action="{{ route('user.seo.update', [$seo->id]) }}">
        @csrf
        <div class="row">
            <!-- Display language name (read-only) -->
            <div class="col-md-12">
                <div class="form-group">
                    <label>Language</label>
                    <input type="text" class="form-control" value="{{ $seo->language->name }}" readonly>
                </div>
            </div>
            <!-- Meta Title -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="edit_seo_meta_title_{{ $seo->id }}">Meta Title</label>
                    <input type="text" name="meta_title" id="edit_seo_meta_title_{{ $seo->id }}" class="form-control"
                        value="{{ $seo->meta_title }}">
                    <div class="invalid-feedback" id="editSeoMetaTitleError_{{ $seo->id }}"></div>
                </div>
            </div>
            <!-- Meta Keyword -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="edit_seo_meta_keyword_{{ $seo->id }}">Meta Keyword</label>
                    <input type="text" name="meta_keyword" id="edit_seo_meta_keyword_{{ $seo->id }}"
                        class="form-control" value="{{ $seo->meta_keyword }}">
                    <div class="invalid-feedback" id="editSeoMetaKeywordError_{{ $seo->id }}"></div>
                </div>
            </div>
            <!-- Meta Description -->
            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <label for="edit_seo_meta_description_{{ $seo->id }}">Meta Description</label>
                    <textarea name="meta_description" id="edit_seo_meta_description_{{ $seo->id }}" class="form-control"
                        rows="4">{{ $seo->meta_description }}</textarea>
                    <div class="invalid-feedback" id="editSeoMetaDescriptionError_{{ $seo->id }}"></div>
                </div>
            </div>
            <!-- Submit Button -->
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-success">Update SEO</button>
            </div>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
    $('#editSeoForm{{ $seo->id }}').on('submit', function(e) {
        e.preventDefault();
        // Clear previous error messages and invalid classes
        $('#editSeoMetaTitleError_{{ $seo->id }}').text('');
        $('#editSeoMetaKeywordError_{{ $seo->id }}').text('');
        $('#editSeoMetaDescriptionError_{{ $seo->id }}').text('');
        $('#edit_seo_meta_title_{{ $seo->id }}').removeClass('is-invalid');
        $('#edit_seo_meta_keyword_{{ $seo->id }}').removeClass('is-invalid');
        $('#edit_seo_meta_description_{{ $seo->id }}').removeClass('is-invalid');

        let formData = new FormData(this);
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
                if(errors.meta_title) {
                    $('#editSeoMetaTitleError_{{ $seo->id }}').text(errors.meta_title[0]);
                    $('#edit_seo_meta_title_{{ $seo->id }}').addClass('is-invalid');
                }
                if(errors.meta_keyword) {
                    $('#editSeoMetaKeywordError_{{ $seo->id }}').text(errors.meta_keyword[0]);
                    $('#edit_seo_meta_keyword_{{ $seo->id }}').addClass('is-invalid');
                }
                if(errors.meta_description) {
                    $('#editSeoMetaDescriptionError_{{ $seo->id }}').text(errors.meta_description[0]);
                    $('#edit_seo_meta_description_{{ $seo->id }}').addClass('is-invalid');
                }
            }
        });
    });
});
</script>
