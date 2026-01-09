@extends('layouts.main')

@section('content')
<h1 class="edittitle">Forum Anwort editieren</h1>

<form action="{{ route('forumanswer.update', ['id' => $answer->id]) }}" 
      method="POST" 
      class="forumpostsform">
    @csrf
    @method('put')

    <div class="formGroup">
        <label class="label">Forum Answer</label>

        @include('quill.container', ['field' => 'answer_body'])

        <input type="hidden" name="answer_body" id="answer_body">
        <input type="hidden" name="parent_id" value="{{ request('parent_id') }}">
    </div>

    <button type="submit" class="sendBtn">Store</button>

    {{-- Pre-fill Quill --}}
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.dispatchEvent(new CustomEvent('quill-set-content-global', {
                detail: {
                    field: 'answer_body',
                    value: @json($answer->answer_body)
                }
            }));
        });
    </script>

    {{-- Submit handler --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('.forumpostsform');

            form.addEventListener('submit', () => {
                const content = window.quill.getContents();
                document.querySelector('#answer_body').value = JSON.stringify(content);
            });
        });
    </script>

</form>
@endsection
