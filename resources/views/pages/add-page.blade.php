@extends('layouts.app')

@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
    @if(Session::has('success'))
        <div class="p-4 mb-2 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-semibold">Success: </span> {{ session('success') }}
        </div>
    @endif
    <div class="container p-[1.875rem] mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <div class="flex gap-4">
            <div class="w-full bg-container">
                <label class="block text-sm  mb-4">
                    <span class="text-black">Select Page Template</span>
                    <div class="w-[43%] mt-1 p-2 add_new_page bg-[#eeeeee] dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">
                        <select
                            id="pageSelect"
                            name="select_template"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        >
                            <option value="page-text-template" selected>Add Page Text</option>
                            <option value="download-template">Add Download template</option>
                            <option value="video-template">Add Video Template</option>
                        </select>
                    </div>


                    <div id="pageContent">
                        <!-- Content will be loaded here -->
                    </div>
                </label>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<!-- JavaScript code -->
<script>
$(document).ready(function() {
    $(window).on('load', function() {
        $('#pageSelect').trigger('change');
    });
    //$('#pageSelect').trigger('change');

    $(document).on('change', '#pageSelect', function(e) {
        e.preventDefault();

        var selectedPage = $(this).val();
        $.ajax({
            url: "{{ route('load-page') }}",
            type: "POST",
            data: { page: selectedPage, "_token": "{{ csrf_token() }}" },
            cache: false,
            success: function(data) {
                $('#pageContent').html(data);
                if (typeof tinymce !== 'undefined') {
                    tinymce.remove();
                }
            },
            complete: function() {
                $('#loader').hide();
            }
        });
    });
});
</script>
@endsection
