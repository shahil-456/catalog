<div class="card mb-3 p-3">
    <div class="bg-smoke mb-3">
        <div class="col-md-12">
            <form id="pageSectionForm" method="POST" action="{{ route('user.page.section.create') }}"
                class="row align-items-end" enctype="multipart/form-data">
                @csrf
                <h4>Choose Theme</h4>
                <div class="row">
                    @if(!empty($sections) && count($sections) > 0)
                    @foreach($sections as $index => $section)
                    <div class="col-md-3">
                        <div class="section-box">
                            <input type="radio" id="section-{{ $section->id ?? $section['id'] }}" name="section_id"
                                value="{{ $section->id ?? $section['id'] }}" @if(old('section', $selectedSection ?? ''
                                )==($section->id ?? $section['id'])) checked @endif>
                            <label for="section-{{ $section->id ?? $section['id'] }}">
                                <img src="{{ asset('images/section_template_images/' . $section->sample_view) }}"
                                    class="img-fluid" />
                            </label>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="col-md-12 text-muted">No sections available.</div>
                    @endif
                </div>
                <div class="col-md-12 p-3 text-right">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
            <div id="sectionFormMessage"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Heading</th>
                        <th>Sample View</th>
                        <th>Sort Order</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($pageSections) && count($pageSections) > 0)
                    @foreach($pageSections as $index => $pageSection)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pageSection->heading }}</td>
                        <td>
                            <img src="{{ asset($pageSection->section->sample_view ?? '') }}" style="max-width: 500px;">
                        </td>
                        <td>{{ $pageSection->sort_order }}</td>
                        <td>{{ $pageSection->created_at }}</td>
                        <td class="space-evenly">
                            <a href="{{ route('user.page-section.edit', $pageSection->id) }}"
                                class="btn btn-sm btn-dark" title="Edit">
                                <i class="fi fi-rr-file-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('user.page-section.delete', $pageSection->id) }}"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Delete"
                                    onclick="return confirm('Are you sure?')">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="6" class="text-center">No Page Sections</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('#faqForm').on('submit', function(e) {
            e.preventDefault();

            // Clear previous error messages and classes
            $('#questionError').text('');
            $('#answerError').text('');
            $('#exampleInputQuestion').removeClass('is-invalid');
            $('#exampleInputAnswer').removeClass('is-invalid');

            // Create FormData object from the form
            let formData = new FormData(this);
            formData.append('page', '{{ $page }}');
            formData.append('page_id', '{{ $page_id }}');

            $.ajax({
                url: "{{ route('user.faq.add') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastMagic.success("Success!", response.message);
                        $('#faqForm')[0].reset();
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.question) {
                        $('#questionError').text(errors.question[0]);
                        $('#exampleInputQuestion').addClass('is-invalid');
                    }
                    if (errors.answer) {
                        $('#answerError').text(errors.answer[0]);
                        $('#exampleInputAnswer').addClass('is-invalid');
                    }
                }
            });
        });
    });

    function deleteFaq(button) {
        const faqId = $(button).data('id');

        $.ajax({
            url: `{{ route('user.faq.delete', '') }}/${faqId}`,
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
                toastMagic.success("Success!", "Failed to delete FAQ.");
            }
        });
    }
</script>
<script>
    $(document).ready(function(){
    $('#pageSectionForm').on('submit', function(e) {
        e.preventDefault();

        $('#sectionFormMessage').html('');

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function(response) {
                $('#sectionFormMessage').html('<div class="alert alert-success">Section added successfully.</div>');
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            },
            error: function(xhr) {
                let msg = 'An error occurred!';
                if(xhr.responseJSON && xhr.responseJSON.errors){
                    msg = Object.values(xhr.responseJSON.errors).join('&lt;br&gt;');
                }
                $('#sectionFormMessage').html('<div class="alert alert-danger">' + msg + '</div>');
            }
        });
    });
});
</script>
