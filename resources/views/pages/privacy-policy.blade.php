@extends('layouts.app')

@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
    @if(Session::has('success'))
        <div class="p-4 mb-2 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-semibold">Success: </span> {{ session('success') }}
        </div>
    @endif
    <div class="container p-[1.875rem] mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <form method="post" id="update-privacy-policy" action="#" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4 page-title-main">
                <label for="page_title_editor" class="mb-1 block text-sm">Page Title</label>
                <textarea class="" name="page_title" id="page_title_editor">{{ isset($privacyPolicy[0]->page_title) ? $privacyPolicy[0]->page_title : '' }}</textarea>
            </div>

            <div class="form-group mb-4">
                <label for="editor" class="mb-1 block text-sm">Page Description</label>
                <textarea class="mt-1" name="description" id="editor">{{ isset($privacyPolicy[0]->description) ? $privacyPolicy[0]->description : '' }}</textarea>
            </div>

            <div class="flex justify-end items-center mt-4 gap-2">
                <div id="loader" style="display:none;"><img class="h-27 w-10" src="{{ asset('assets/img/loader.gif') }}" alt="GlobalNation"></div>
                <input type="button" id="update_privacy_policy" class="cursor-pointer float-right text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]" value="Save">
            </div>
        </form>
    </div>
</main>
@endsection

@section('script')
<!-- JavaScript code -->
<script>
$(document).ready(function () {
    let titleeditorInstance;
    let editorInstance;

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
                if (editor.id === 'editor') {
                    editorInstance = editor; // Assign editor for disclaimers
                } else if (editor.id === 'page_title_editor') {
                    titleeditorInstance = editor; // Assign editor for page title
                }
            });
        },
        height: '400px',
    });

    $('#update_privacy_policy').on('click', function(e) {
        e.preventDefault();
        let url = window.location.pathname;
        let slug = url.split('/').pop();

        let myform = document.getElementById("update-privacy-policy");
        let fd = new FormData(myform);
        if (editorInstance) {
            var textContent = editorInstance.getContent();
        }

        if (titleeditorInstance) {
            var titleContent = titleeditorInstance.getContent();
        }

        fd.append("description", textContent);
        fd.append("page_title", titleContent);
        fd.append("page_slug", slug);
        fd.append("status", 1);
        fd.append("is_preview", 0);

        $.ajax({
            url: "{{ route('save-privacy-policy') }}",
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

    $('#privacypolicy-preview-btn').on('click', function(e) {
        e.preventDefault();
        let url = window.location.pathname;
        let slug = url.split('/').pop();

        let myform = document.getElementById("update-privacy-policy");
        let fd = new FormData(myform);
        if (editorInstance) {
            var textContent = editorInstance.getContent();
        }

        if (titleeditorInstance) {
            var titleContent = titleeditorInstance.getContent();
        }

        fd.append("description", textContent);
        fd.append("page_title", titleContent);
        fd.append("page_slug", slug);
        fd.append("status", 1);
        fd.append("is_preview", 1);

        $.ajax({
            url: "{{ route('save-privacy-policy') }}",
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
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Record updated successfully",
                    showConfirmButton: false,
                    timer: 2500
                });
                setTimeout( function(){
                    window.open("https://globalnation.tv/privacy-policy-test/preview");
                }  , 2500 );
            },
            error: function (xhr) {
                $.each(xhr.responseJSON.errors, function (key, value) {
                    console.log(key +'valuevalue' + value)
                    $(".error_"+key).text(value);
                });
            },
            complete: function() {
                $('#loader').hide();
            }
        });
    });
});
</script>
@endsection
