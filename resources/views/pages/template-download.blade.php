<main class="flex flex-1 flex-col grow overflow-y-auto download-temp">
    @if(Session::has('success'))
        <div class="p-4 mb-2 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-semibold">Success: </span> {{session('success')}}
        </div>
    @endif
    <div class="container mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <form method="post" id="template-download-form" action="{{route('save-download-template-new-item')}}" enctype="multipart/form-data">
             @csrf
            <div class="flex gap-4">
                <div class="w-[43%] bg-container">
                    <label class="block text-sm  mb-4">
                        <span class="text-black">Uplaod Background Image</span>
                        <div class="mt-1 p-2 upload_new_build bg-[#eeeeee] dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">
                            <span class="bg-white px-2 py-1 rounded file-label">Choose File</span>
                            <input class="hidden file-input" name="background_image" type="file">
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

            <div class="dynamic-fields-container">
                <div class="flex mb-4 gap-4 dynamic-field items-center" id="dynamic-field">
                    <div class="w-[43%]">
                        <label class="block text-sm">
                            <span class="text-black">Label</span>
                            <input
                                class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                                placeholder="Downloads" type="text"
                                name="plateform_name[]"
                                value=""
                            />
                        </label>
                    </div>
                    <div class="w-[43%]">
                        <label class="block text-sm">
                            <span class="text-black">Upload File</span>
                            <div class="mt-1 p-2 bg-[#eeeeee] upload_new_build dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">
                                <div class="choose_main_sec">
                                    <span class="bg-white px-2 py-1 rounded file-label">Choose File</span>
                                    <input class="hidden file-input build-file-upload" name="plateform_file_1" type="file">
                                </div>
                                <div class="progress mt-2 ml-0">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar-percenatge"></div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <input class="plateform_file_hidden" type="hidden" name="plateform_file_hidden[]" value="" />

                    <input class="plateform_status" type="hidden" name="plateform_status[]" value="1" />

                    <div class="flex align-center flex-shrink-0 mt-6 icon-section">
                        <div class="btn btn-secondary text-uppercase focus:outline-none add-button"><i class="fa fa-plus fa-fw"></i></div>

                        <div class="btn btn-secondary text-uppercase focus:outline-none ml-1 remove-button" disabled><i class="fa fa-minus fa-fw"></i></div>

                        <div class='downImage ml-1'><i class="fa fa-caret-down" style="font-size:10px"></i></div>
                        <div class='plate_form_status ml-1'><i class="fa fa-eye" style="font-size:10px"></i></div>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4 page-title-main">
                <label for="download_page_title_editor" class="mb-1 block text-sm">Page Title</label>
                <textarea class=""  name="page_title" id="download_page_title_editor">
                </textarea>
            </div>

            <div class="form-group mb-4">
                <label for="download_description_editor" class="mb-1 block  text-sm">Disclaimers</label>
                <textarea class="mt-1" name="content" id="download_description_editor">
                </textarea>
            </div>

            <div class="flex justify-end items-center mt-4 gap-2">
                <div id="loader" style="display:none;"><img class="h-27 w-10" src="{{asset('assets/img/loader.gif')}}" alt="GlobalNation"></div>
                <input type="button" id="download-btn" class="cursor-pointer float-right text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]" value="Save">
            </div>
        </form>
    </div>
</main>

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
        clone.find('.form-input').val(''); // Clear the input value
        clone.find('.file-input').val('');
        clone.find('.build-file-upload').attr('name', "plateform_file_" + dynamicFieldCount);

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
        selector: '#download_description_editor, #download_page_title_editor',
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
                console.log('Editor was initialized', editor);
                if (editor.id === 'download_description_editor') {
                    editorInstance = editor; // Assign editor for disclaimers
                } else if (editor.id === 'download_page_title_editor') {
                    titleeditorInstance = editor; // Assign editor for page title
                }
            });
        }
    });


    $('#download-btn').on('click', function(e) {
        e.preventDefault();
        let myform = document.getElementById("template-download-form");
        let fd = new FormData(myform);
        if (editorInstance) {
            var textContent = editorInstance.getContent();
        }

        if (titleeditorInstance) {
            var titleContent = titleeditorInstance.getContent();
        }

        var page_slug = $('.page_slug').val();
        var slug = page_slug.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');

        fd.append("status", 1);
        fd.append("disclaimers", textContent);
        fd.append("page_title", titleContent);
        fd.append("page_slug", slug);
        var numItems = $('.dynamic-fields-container .dynamic-field').length;

        for (i = 0; i < numItems; i++){
            fd.set("plateform_file_"+i, '');
        }

            var numItems = $('.dynamic-fields-container .dynamic-field').length;
            $.ajax({
                url: "{{ route('save-download-template-new-item') }}",
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
        var progress = $(this).closest('.upload_new_build').find('.progress');
        var progressBar = progress.find('.progress-bar');
        var progressPercentage = progress.find('.progress-bar-percenatge');
        var fileNameLabel = $(this).siblings('.file-label');
        var db_file_name = $(this).siblings('.db_file_name');
        var fileName = this.files[0].name;
        var parentContainer = $(this).closest('.upload_new_build');
        var hiddenInput = $(this).parent().parent().parent().parent().parent();
        hiddenInput.find('.plateform_file_hidden').val(fileName);

        if (this.files.length > 0) {
            db_file_name.text(this.files[0].name);
            progressBar.parent().show();
            uploadBgFile(this.files[0], progressBar, progressPercentage);
            parentContainer.addClass(' flex gap-1 flex-col');
        } else {
            $('.db_file_name').show();
            progressBar.parent().hide();
            parentContainer.addClass(' flex gap-1 flex-col');
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

    $('#download_description_editor').find('.ck-editor__editable').css('min-height', '300px');

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
