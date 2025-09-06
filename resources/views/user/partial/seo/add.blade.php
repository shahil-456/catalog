<div class="card mb-3 p-3">
    <!-- SEO Add Form -->
    <div class="col-md-12 mb-4">
        <form id="seoForm" method="POST" action="{{ route('user.seo.add') }}" class="service-form">
            @csrf
            <h3 class="edit-title">
                Add SEO Contents <i class="fi fi-rr-layer-plus"></i>
            </h3>
            <hr>
            <input type="hidden" name="entity_type" value="{{ $entity_type }}" />
            <input type="hidden" name="page_id" value="{{ $page_id }}" />
            <div class="row">
                <!-- Language Selection -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="seo_language_id">Language</label>
                        <select name="lang_id" id="seo_language_id" class="form-control">
                            <option value="">Choose Language</option>
                            @foreach($languages as $language)
                            <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="seoLanguageError"></div>
                    </div>
                </div>
                <!-- Meta Title -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="seo_meta_title">Meta Title</label>
                        <input type="text" name="meta_title" id="seo_meta_title" class="form-control"
                            placeholder="Enter Meta Title">
                        <div class="invalid-feedback" id="seoMetaTitleError"></div>
                    </div>
                </div>
                <!-- Meta Keyword -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="seo_meta_keyword">Meta Keyword</label>
                        <input type="text" name="meta_keyword" id="seo_meta_keyword" class="form-control"
                            placeholder="Enter Meta Keyword">
                        <div class="invalid-feedback" id="seoMetaKeywordError"></div>
                    </div>
                </div>
                <!-- Meta Description -->
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="seo_meta_description">Meta Description</label>
                        <textarea name="meta_description" id="seo_meta_description" class="form-control" rows="4"
                            placeholder="Enter Meta Description"></textarea>
                        <div class="invalid-feedback" id="seoMetaDescriptionError"></div>
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fi fi-rr-layer-plus"></i> Add
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Existing SEO Contents Accordion (optional) -->
    <div class="col-md-12">
        @if(isset($seo) && $seo->count() > 0)
        <div class="accordion" id="seoAccordion">
            @foreach($seo as $index => $seoEntry)
            <div class="accordion-item">
                <h2 class="accordion-header" id="seoHeading{{ $index }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#seoCollapse{{ $index }}" aria-expanded="false"
                        aria-controls="collapse{{ $index }}">
                        {{ $seoEntry->language->name }}
                    </button>
                </h2>
                <div id="seoCollapse{{ $index }}" class="accordion-collapse collapse"
                    aria-labelledby="seoHeading{{ $index }}" data-bs-parent="#seoAccordion">
                    <div class="accordion-body">
                        {{-- Optionally include a partial to allow editing/deleting of this SEO record --}}
                        @include('user.partial.seo.edit', ['seo' => $seoEntry])
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p>No SEO contents added yet.</p>
        @endif
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('#seoForm').on('submit', function(e) {
            e.preventDefault();

            // Clear previous error messages and classes
            $('#seoLanguageError').text('');
            $('#seoMetaTitleError').text('');
            $('#seoMetaKeywordError').text('');
            $('#seoMetaDescriptionError').text('');
            $('#seo_language_id').removeClass('is-invalid');
            $('#seo_meta_title').removeClass('is-invalid');
            $('#seo_meta_keyword').removeClass('is-invalid');
            $('#seo_meta_description').removeClass('is-invalid');

            // Create FormData object from the form
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
                        // Optionally, clear the form or refresh the SEO list on the page
                        $('#seoForm')[0].reset();
                        setTimeout(function() {
                            window.location.reload();
                                }, 1000);
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if(errors.lang_id) {
                        $('#seoLanguageError').text(errors.language_id[0]);
                        $('#seo_language_id').addClass('is-invalid');
                    }
                    if(errors.meta_title) {
                        $('#seoMetaTitleError').text(errors.meta_title[0]);
                        $('#seo_meta_title').addClass('is-invalid');
                    }
                    if(errors.meta_keyword) {
                        $('#seoMetaKeywordError').text(errors.meta_keyword[0]);
                        $('#seo_meta_keyword').addClass('is-invalid');
                    }
                    if(errors.meta_description) {
                        $('#seoMetaDescriptionError').text(errors.meta_description[0]);
                        $('#seo_meta_description').addClass('is-invalid');
                    }
                }
            });
        });
    });
</script>
