@extends('layouts.app')
@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
    @if(Session::has('success'))
        <div class="p-4 mb-2 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-semibold">Success: </span> {{session('success')}}
        </div>
    @endif
    <div class="container p-[1.875rem] mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <form method="post" id="download-form" action="{{route('save-page')}}" enctype="multipart/form-data">
             @csrf
            <div class="flex gap-4">
                <div class="w-[43%] bg-container">
                    <label class="block text-sm  mb-4">
                        <span class="text-black">Uplaod Background Image</span>
                        <div class="mt-1 p-2 upload_new_build bg-[#eeeeee] dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">
                            <span class="bg-white px-2 py-1 rounded file-label">Choose File</span>
                            <input class="hidden file-input" name="background_image" type="file">
                            {{isset($download->background_image) ? $download->background_image : ''}}
                        </div>
                    </label>
                </div>
            </div>

            <div class="dynamic-fields-container">
                @if(isset($download->plateform_name))
                @foreach($download->plateform_name as $key => $plateform)
                <div class="flex mb-4 gap-4 dynamic-field items-center" id="dynamic-field-{{$key}}">
                    <div class="w-[43%]">
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
                    <div class="w-[43%]">
                        <label class="block text-sm">
                            <span class="text-black">Upload New Build</span>
                            <div class="mt-1 p-2 bg-[#eeeeee] upload_new_build dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">

                                    <span class="bg-white px-2 py-1 rounded file-label">Choose File</span>
                                    <input class="hidden file-input build-file-upload" name="plateform_file_{{$key}}" type="file">
                                    <span class="db_file_name"> {{isset($download->plateform_file[$key]) ? $download->plateform_file[$key] : ''}} </span>

                                <div class="progress mt-2 ml-0">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar-percenatge"></div>
                                </div>
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
                            <div class="mt-1 p-2 upload_new_build bg-[#eeeeee] dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">

                                    <span class="bg-white px-2 py-1 rounded file-label">Choose File</span>
                                    <input class="hidden file-input build-file-upload" name="plateform_file_{{$key}}" type="file">
                                    <span class="db_file_name"> {{isset($download->plateform_file[$key]) ? $download->plateform_file[$key] : ''}} </span>

                                <div class="progress mt-2 ml-0">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar-percenatge"></div>
                                </div>
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

            <div class="form-group mb-4">
                <label for="editor" class="mb-1 block text-sm">Page Title</label>
                <textarea class=""  name="page_title" id="page_title_editor">
                    {{isset($download->title) ? $download->title : ''}}
                </textarea>
                <input type="hidden" name="page_id" value="{{isset($download->id) ? $download->id : ''}}"/>
            </div>

            <div class="form-group mb-4">
                <label for="editor" class="mb-1 block text-sm">Disclaimers</label>
                <textarea class="mt-1" name="content" id="editor">
                    {{isset($download->disclaimers) ? $download->disclaimers : ''}}
                </textarea>
            </div>

            <div class="flex justify-end items-center mt-4 gap-2">
                <div id="loader" style="display:none;"><img class="h-27 w-10" src="{{asset('assets/img/loader.gif')}}" alt="GlobalNation"></div>
                <input type="button" id="download-btn" class="cursor-pointer float-right text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]" value="Save">
            </div>
        </form>
    </div>
</main>
@endsection

@section('script')
<!-- Javascript code -->
<script>
$(document).ready(function () {
    var container = $(".dynamic-fields-container");
    var bgContainer = $(".bg-container");
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

    let titleeditorInstance ;
    let editorInstance ;

    tinymce.init({
        selector: '#editor, #page_title_editor',
        plugins: 'textcolor colorpicker anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',

        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor | backcolor | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
        ],
        color_picker_callback: function(callback, value) {
            callback('#FF00FF');
        },
        setup: function (editor) {
            editor.on('init', function () {
                console.log('Editor was initialized', editor);
                if (editor.id === 'editor') {
                    editorInstance = editor; // Assign editor for disclaimers
                } else if (editor.id === 'page_title_editor') {
                    titleeditorInstance = editor; // Assign editor for page title
                }
            });
        }
    });


    $('#download-btn').on('click', function(e) {
        e.preventDefault();
        let myform = document.getElementById("download-form");
        let fd = new FormData(myform);
        if (editorInstance) {
            var textContent = editorInstance.getContent();
        }

        if (titleeditorInstance) {
            var titleContent = titleeditorInstance.getContent();
        }

        fd.append("status", 1);
        fd.append("disclaimers", textContent);
        fd.append("page_title", titleContent);
            var numItems = $('.dynamic-fields-container .dynamic-field').length;
            console.log('numItems' + numItems);
            for (i = 0; i < numItems; i++){
                fd.set("plateform_file_"+i, '');
            }
            $.ajax({
                url: "{{ route('save-page') }}",
                type: "POST",
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(data) {
                    console.log(data);
                    Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Record updated successfully",
                    showConfirmButton: false,
                    timer: 2500
                    });
                },
                complete: function() {
                    $('#loader').hide();
                }
            });
    });

    $('#downloads-preview-btn').on('click', function(e) {
        e.preventDefault();
        let myform = document.getElementById("download-form");
        let fd = new FormData(myform);
        if (editorInstance) {
            var textContent = editorInstance.getContent();
        }

        if (titleeditorInstance) {
            var titleContent = titleeditorInstance.getContent();
        }

        fd.append("status", 2);
        fd.append("disclaimers", textContent);
        fd.append("page_title", titleContent);
        var numItems = $('.dynamic-fields-container .dynamic-field').length;
        console.log('numItems' + numItems);
        for (i = 0; i < numItems; i++){
            fd.set("plateform_file_"+i, '');
        }

            $.ajax({
                url: "{{ route('save-page') }}",
                type: "POST",
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(data) {
                    console.log(data);
                    window.open("https://globalnation.tv/downloads/preview");
                },
                complete: function() {
                    $('#loader').hide();
                }
            });
    });

    function disableButtonRemove() {
        container.find(".dynamic-field .remove-button").prop("disabled", container.find(".dynamic-field").length === 1);
    }

    container.on("input", "input[type=text]", function () {
        enableButtonAdd();
    });

    function enableButtonAdd() {
        container.find(".dynamic-field:last .add-button").prop("disabled", false);
    }

    $(".dynamic-fields-container").on('change', '.file-input', function () {
        var progressBar = $(this).siblings('.progress').find('.progress-bar');
        var progressPercenatge = $(this).siblings('.progress').find('.progress-bar-percenatge');
        var fileNameLabel = $(this).siblings('.file-label');
        var fileName = this.files[0].name;
        var hiddenInput = $(this).parent().parent().parent().parent();
        hiddenInput.find('.plateform_file_hidden').val(fileName);

        if (this.files.length > 0) {
            fileNameLabel.text(this.files[0].name);
            $(this).siblings('.db_file_name').hide();
            progressBar.parent().show();
            uploadBgFile(this.files[0], progressBar, progressPercenatge);
        } else {
            $('.db_file_name').show();
            fileNameLabel.text('Choose File');
            progressBar.parent().hide();
        }
    });

    bgContainer.on('change', '.file-input', function () {
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


    function uploadBgFile(file, progressBar, progressPercenatge) {
        var formData = new FormData();
        formData.append('background_image', file);

        $.ajax({
            url: "{{ route('save-file-with-progress') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        progressBar.width(percentComplete + '%').attr('aria-valuenow', percentComplete);
                        progressPercenatge.text(percentComplete.toFixed() + '%');
                        if(percentComplete == 100){
                            progressBar.parent().hide();
                        }
                    }
                }, false);
                return xhr;
            },
            success: function (data) {
                if(data.status == "success"){
                   console.log('My file name ' + data.file);
                }
            },
            error: function (xhr, status, error) {
                // Handle error
                console.error('Error uploading file:', error);
            }
        });
    }
</script>

@endsection
