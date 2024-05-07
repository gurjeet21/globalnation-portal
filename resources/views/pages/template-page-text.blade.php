<main class="flex flex-1 flex-col grow overflow-y-auto">
    @if(Session::has('success'))
        <div class="p-4 mb-2 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-semibold">Success: </span> {{ session('success') }}
        </div>
    @endif
    <div class="container mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <form method="post" id="template-page-text" action="{{ route('template-page-text') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex gap-4">
                <div class="w-[43%] bg-container">
                    <label class="block text-sm  mb-4">
                        <span class="text-black">Uplaod Background Image</span>
                        <div class="mt-1 p-2 upload_new_build bg-[#eeeeee] dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">
                            <span class="bg-white px-2 py-1 rounded file-label">Choose File</span>
                            <input required class="hidden file-input" name="background_image" type="file">
                            <span class="bg-file-name"></span>
                        </div>
                    </label>
                </div>

                <div class="w-[43%] bg-container">
                    <label class="block text-sm">
                        <span class="text-black">Slug</span>
                        <input
                            class="block page_slug w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                            placeholder="Slug"
                            type="text"
                            name="page_slug"
                        />
                    </label>
                </div>
            </div>

            <div class="form-group mb-4 page-title-main">
                <label for="page_title_editor" class="mb-1 block text-sm">Page Title</label>
                <textarea class="" name="page_title" id="page_title_editor"></textarea>
            </div>

            <div class="form-group mb-4">
                <label for="editor" class="mb-1 block text-sm">Page Description</label>
                <textarea class="mt-1" name="description" id="editor"></textarea>
            </div>

            <div class="flex justify-end items-center mt-4 gap-2">
                <div id="loader" style="display:none;"><img class="h-27 w-10" src="{{ asset('assets/img/loader.gif') }}" alt="GlobalNation"></div>
                <input type="button" id="add_new_page" class="cursor-pointer float-right text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]" value="Save">
            </div>
        </form>
    </div>
</main>

<script>
$(document).ready(function () {
    let titleeditorInstance;
    let editorInstance;

    tinymce.init({
        selector: '#editor, #page_title_editor',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',

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
        height: '800px',
    });

    $('#add_new_page').on('click', function(e) {
        e.preventDefault();

        let myform = document.getElementById("template-page-text");
        let fd = new FormData(myform);
        if (editorInstance) {
            var textContent = editorInstance.getContent();
        }

        if (titleeditorInstance) {
            var titleContent = titleeditorInstance.getContent();
        }

        var page_slug = $('.page_slug').val();
        var slug = page_slug.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');

        fd.append("description", textContent);
        fd.append("page_title", titleContent);
        fd.append("page_slug", slug);
        fd.append("status", 1);
        fd.append("is_preview", 0);

        $.ajax({
            url: "{{ route('save-template-page-text') }}",
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
                    title: "Page Added successfully",
                    showConfirmButton: false,
                    timer: 2500
                });
                setTimeout( function(){
                    window.location.replace("/pages/manage-pages");
                }  , 2500 );
            },
            complete: function() {
                $('#loader').hide();
            }
        });
    });
});
</script>
