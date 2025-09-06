<div class="card mb-3 p-3">
    <form id="faqForm" method="POST" action="{{ route('user.faq.add') }}" class="faq-form">
        @csrf
        <h3 class="edit-title">
            Add FAQ <i class="fi fi-rr-layer-plus"></i>
        </h3>
        <hr>
        <div class="row">
            <div class="row align-items-center p-3">
                <div class="col-md-5 form-group mb-0">
                    <textarea name="question" placeholder="Enter Question" id="exampleInputQuestion"
                        class="form-control">{{ old('question') }}</textarea>
                </div>
                <div class="col-md-5 form-group mb-0">
                    <textarea name="answer" placeholder="Enter Answer" id="exampleInputAnswer"
                        class="form-control">{{ old('answer') }}</textarea>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Add FAQ</button>
                </div>
            </div>
        </div>
    </form>
    <!-- Existing FAQ Contents Accordion (optional) -->
    <div class="col-md-12">
        @if(isset($faq) && $faq->count() > 0)
        <div class="accordion" id="faqAccordion">
            @foreach($faq as $index => $faqEntry)
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqHeading{{ $index }}">
                    <div class="d-flex justify-content-between align-items-center w-100 pe-2">
                        <button class="accordion-button collapsed flex-grow-1 text-start" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $index }}" aria-expanded="false"
                            aria-controls="faqCollapse{{ $index }}">
                            {{ $faqEntry->question }}
                        </button>
                        <button type="button" class="btn btn-sm btn-danger ms-2" data-id="{{ $faqEntry->id }}"
                            onclick="if(confirm('Are you sure you want to delete this FAQ?')) deleteFaq(this);">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </h2>
                <div id="faqCollapse{{ $index }}" class="accordion-collapse collapse"
                    aria-labelledby="faqHeading{{ $index }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {{-- Optionally include a partial to allow editing/deleting of this FAQ record --}}
                        @include('user.partial.faq.edit', ['faq' => $faqEntry])
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p>No FAQ contents added yet.</p>
        @endif
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
