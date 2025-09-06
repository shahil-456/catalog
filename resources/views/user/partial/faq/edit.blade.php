<div class="faq-edit-form mb-3">
    <form id="editFaqForm{{ $faq->id }}" method="POST" action="{{ route('user.faq.update', [$faq->id]) }}">
        @csrf
        <div class="row">
            <!-- Question -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="edit_faq_question_{{ $faq->id }}">Question</label>
                    <textarea name="question" id="edit_faq_question_{{ $faq->id }}" class="form-control"
                        rows="2">{{ $faq->question }}</textarea>
                    <div class="invalid-feedback" id="editFaqQuestionError_{{ $faq->id }}"></div>
                </div>
            </div>
            <!-- Answer -->
            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <label for="edit_faq_answer_{{ $faq->id }}">Answer</label>
                    <textarea name="answer" id="edit_faq_answer_{{ $faq->id }}" class="form-control"
                        rows="4">{{ $faq->answer }}</textarea>
                    <div class="invalid-feedback" id="editFaqAnswerError_{{ $faq->id }}"></div>
                </div>
            </div>
            <!-- Submit Button -->
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-success">Update FAQ</button>
            </div>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('#editFaqForm{{ $faq->id }}').on('submit', function(e) {
            e.preventDefault();
            // Clear previous error messages and invalid classes
            $('#editFaqQuestionError_{{ $faq->id }}').text('');
            $('#editFaqAnswerError_{{ $faq->id }}').text('');
            $('#edit_faq_question_{{ $faq->id }}').removeClass('is-invalid');
            $('#edit_faq_answer_{{ $faq->id }}').removeClass('is-invalid');

            let formData = new FormData(this);
            formData.append('id', '{{ $faq->id }}');
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
                    if(errors.question) {
                        $('#editFaqQuestionError_{{ $faq->id }}').text(errors.question[0]);
                        $('#edit_faq_question_{{ $faq->id }}').addClass('is-invalid');
                    }
                    if(errors.answer) {
                        $('#editFaqAnswerError_{{ $faq->id }}').text(errors.answer[0]);
                        $('#edit_faq_answer_{{ $faq->id }}').addClass('is-invalid');
                    }
                }
            });
        });
    });
</script>
