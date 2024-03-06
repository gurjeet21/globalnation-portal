@extends('layouts.app')
@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
    <div class="breandcrumb-top">Pages | Downloads</div>
    @if(Session::has('success'))
        <div class="p-4 mb-2 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-semibold">Success: </span> {{session('success')}}
        </div>
    @endif
    <div class="container p-[1.875rem] mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <form method="post" id="download-form" action="{{route('save-page')}}" enctype="multipart/form-data">
             @csrf
            <div class="flex gap-4">
                <div class="flex-1 max-w-[45.5%]">
                    <label class="block text-sm  mb-4">
                        <span class="text-black">Page Title</span>
                        <input
                            class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee]  focus:outline-none dark:focus:shadow-outline-gray form-input"
                            placeholder="Downloads" type="text" name="page_title"
                            value="{{isset($download->title) ? $download->title : ''}}"
                        />
                    </label>
                </div>
            </div>

            <div class="dynamic-fields-container">
                @if(isset($download->plateform_name))
                @foreach($download->plateform_name as $key => $plateform)
                <div class="flex mb-4 gap-4 dynamic-field items-center" id="dynamic-field-1">
                    <div class="flex-1">
                        <label class="block text-sm">
                            <span class="text-black">Platform</span>
                            <input
                                class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                                placeholder="Downloads" type="text"
                                name="plateform_name[]"
                                value="{{$plateform}}"
                            />
                        </label>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm">
                            <span class="text-black">Upload New Build</span>
                            <div class="mt-1 p-2 bg-[#eeeeee] dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">
                                <span class="bg-white px-2 py-1 rounded file-label">Choose File</span>
                                <input class="hidden file-input" name="plateform_file_{{$key}}" type="file">
                                {{isset($download->plateform_file[$key]) ? $download->plateform_file[$key] : ''}}
                            </div>
                        </label>
                    </div>
                    <input class="plateform_file_hidden" type="hidden" name="plateform_file_hidden[]" value="{{isset($download->plateform_file[$key]) ? $download->plateform_file[$key] : ''}}" />
                    <input class="plateform_status" type="hidden" name="plateform_status[]" value="{{$download->plateform_status[$key]}}" />

                    <div class="flex align-center flex-shrink-0 mt-6 icon-section">
                        <div class="btn btn-secondary text-uppercase focus:outline-none add-button"><i class="fa fa-plus fa-fw"></i></div>

                        <div class="btn btn-secondary text-uppercase focus:outline-none ml-1 remove-button" disabled><i class="fa fa-minus fa-fw"></i></div>

                        <div class='downImage ml-1'><i class="fa fa-caret-down" style="font-size:20px"></i></div>
                        <div class='plate_form_status ml-1'>
                            <span class="plate_form_show" style="display: {{$download->plateform_status[$key] == '1' ? 'block' : 'none'}}"><i class="fa fa-eye" style="font-size:10px"></i></span>
                            <span class="plate_form_hide" style="display: {{$download->plateform_status[$key] == '0' ? 'block' : 'none'}}"><i class="fa fa-eye-slash" style="font-size:10px"></i></span>
                        </div>
                    </div>
                </div>
                @endforeach

                @else
                <div class="flex mb-4 gap-4 dynamic-field items-center" id="dynamic-field-1">
                    <div class="flex-1">
                        <label class="block text-sm">
                            <span class="text-black">Plateform</span>
                            <input
                                class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                                placeholder="Downloads" type="text"
                                name="plateform_name[]"
                            />
                        </label>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm">
                            <span class="text-black">Upload New Build</span>
                            <div class="mt-1 p-2 bg-[#eeeeee] dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">
                                <span class="bg-white px-2 py-1 rounded file-label">Choose File</span>
                                <input class="hidden file-input" name="plateform_file[]" type="file">
                            </div>
                        </label>
                    </div>
                    <input class="plateform_status" type="hidden" name="plateform_status[]" value="1" />

                    <div class="flex align-center flex-shrink-0 mt-6 icon-section">
                        <div class="btn btn-secondary text-uppercase focus:outline-none add-button"><i class="fa fa-plus fa-fw"></i></div>

                        <div class="btn btn-secondary text-uppercase focus:outline-none ml-1 remove-button" disabled><i class="fa fa-minus fa-fw"></i></div>

                        <div class='downImage ml-1'><i class="fa fa-caret-down" style="font-size:20px"></i></div>
                        <div class='plate_form_status ml-1'><i class="fa fa-eye" style="font-size:20px"></i></div>
                    </div>
                </div>
                @endif
            </div>

            <div class="form-group">
                <label for="editor">Disclaimers</label>
                <textarea class="mt-1"  name="content" id="editor">
                    {{isset($download->disclaimers) ? $download->disclaimers : ''}}
                </textarea>
            </div>
            <input type="button" id="download-btn" class="mt-4 float-right text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]" value="Save">
        </form>
    </div>
</main>
@endsection

@section('script')
<!-- Javascript code -->
<script>
 $(document).ready(function () {
    var container = $(".dynamic-fields-container");
    var dynamicFieldCount = 1;

    container.on("click", ".add-button", function () {
        var field = $(this).closest(".dynamic-field");
        var clone = field.clone();

        // Increment the dynamicFieldCount for unique IDs
        dynamicFieldCount++;
        clone.attr("id", "dynamic-field-" + dynamicFieldCount);

        // Clear the uploaded file name in the cloned row
        clone.find('.file-label').text('Choose File');
        clone.find('.file-input').val(''); // Clear the input value

        field.after(clone);
        disableButtonRemove();
    });

    container.on("click", ".remove-button", function () {
        var field = $(this).closest(".dynamic-field");
        field.remove();
        disableButtonRemove();
    });

    // Initialize CKEditor on the specified textarea
    let editorInstance ;
    ClassicEditor
    .create(document.querySelector('#editor'))
    .then( newEditor => {
        console.log('Editor was initialized', editor);
        editorInstance  = newEditor; // Store the editor instance in the variable
    } )
    .catch(error => {
        console.error(error);
    });

    $('#download-btn').on('click', function(e) {
            e.preventDefault();
            let myform = document.getElementById("download-form");
            let fd = new FormData(myform);
            var textContent = editorInstance.getData();           
            fd.append("disclaimers", textContent);
                $.ajax({
                    url: "{{ route('save-page') }}",
                    type: "POST",
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Record updated successfully",
                        showConfirmButton: false,
                        timer: 2500
                        });
                    }
                });


        })

    function disableButtonRemove() {
        container.find(".dynamic-field .remove-button").prop("disabled", container.find(".dynamic-field").length === 1);
    }

    container.on("input", "input[type=text]", function () {
        enableButtonAdd();
    });

    function enableButtonAdd() {
        container.find(".dynamic-field:last .add-button").prop("disabled", false);
    }

    container.on('change', '.file-input', function () {
        var fileNameLabel = $(this).siblings('.file-label');

        if (this.files.length > 0) {
            fileNameLabel.text(this.files[0].name);
        } else {
            fileNameLabel.text('Choose File');
        }
    });

    $('.dynamic-fields-container').on('click', '.downImage', function () {
        var downParent = $(this).closest('div.dynamic-field').next();
        if (downParent.length > 0) {
            var sel = $(this).closest('div.dynamic-field').detach();
            sel.insertAfter(downParent);
        }
    });

    $('.plate_form_show').on('click', function () {
        $(this).parent().parent().parent().find('.plateform_status').val('0');
        $(this).hide();
        $(this).parent().parent().parent().find('.plate_form_hide').show();
    });

    $('.plate_form_hide').on('click', function () {
        $(this).parent().parent().parent().find('.plateform_status').val('1');
        $(this).hide();
        $(this).parent().parent().parent().find('.plate_form_show').show();
    });  

    $('#editor').find('.ck-editor__editable').css('min-height', '300px');

});
</script>

@endsection
