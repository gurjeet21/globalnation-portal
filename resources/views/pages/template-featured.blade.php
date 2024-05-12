<main class="flex flex-1 flex-col grow overflow-y-auto">
    @if(Session::has('success'))
        <div class="p-4 mb-2 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-semibold">Success: </span> {{session('success')}}
        </div>
    @endif
    <div class="container mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <form method="post" id="add-artist-form" action="{{ route('save-template-video') }}" enctype="multipart/form-data">
             @csrf
            <div class="flex gap-4">
                <div class="w-[30%] bg-container">
                    <label class="block text-sm">
                        <span class="text-black">Add Video Type<strong> | </strong> <a href="{{route('video-types')}}" style="color:blue;">All Video Type</a></span>
                        <input
                            class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                            placeholder="Video Type" type="text"
                            name="first_name"
                            value=""
                        />
                    </label>
                    <span class="error error_artist_name"></span>
                </div>
                <div class="w-[30%] bg-container">
                    <div class="flex items-center mt-6 gap-2">
                        <div id="loader" style="display:none;"><img class="h-27 w-10" src="{{asset('assets/img/loader.gif')}}" alt="GlobalNation"></div>
                        <input type="button" id="artist-btn" class="cursor-pointer float-right text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]" value="Save">
                    </div>
                </div>
            </div>
        </form>
        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">


        <form method="post" id="artist-featured-form" action="#" enctype="multipart/form-data">
             @csrf
            <div class="flex gap-4">
                <div class="w-[30%] bg-container">
                    <label class="block text-sm  mb-4">
                        <span class="text-black">Uplaod Background Image</span>
                        <div class="mt-1 p-2 upload_new_build bg-[#eeeeee] dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">
                            <span class="bg-white px-2 py-1 rounded file-label">Choose File</span>
                            <input class="hidden file-input" name="background_image" type="file">
                            <span class="bg-file-name"></span>
                        </div>
                    </label>
                </div>
                <div class="w-[30%] bg-container">
                    <label class="block text-sm">
                        <span class="text-black">Page Title</span>
                        <input
                            class="block page_title w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                            placeholder="Page Title" type="text"
                            name="page_title"
                        />
                    </label>
                </div>
                <div class="w-[30%] bg-container">
                    <label class="block text-sm">
                        <span class="text-black">Page Slug <span class="show_slug"></span></span>
                        <input
                            class="block page_slug w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                            placeholder="Page Slug" type="text"
                            name="page_slug"
                        />
                    </label>
                </div>
                <div class="w-[10%]">
                </div>
            </div>
            <div class="dynamic-fields-container">
                <div class="flex mb-4 gap-4 dynamic-field items-center" id="dynamic-field-1">
                    <div class="w-[30%]">
                        <label class="block text-sm">
                            <span class="text-black">Add Type of Video</span>
                            <select name="artist_id[]" class="block artist_ids w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <option value="">--Select Type of Video --</option>
                                @foreach($artists as $artist)
                                    <option value="{{ $artist->id }}">{{ $artist->first_name }} {{ $artist->last_name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="w-[30%]">
                        <label class="block text-sm">
                            <span class="text-black">Name of Show</span>
                            <input
                                class="block featured_title w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                                placeholder="Name of Show" type="text"
                                name="featured_title[]"
                                value=""
                            />
                        </label>
                    </div>

                    <div class="w-[30%]">
                        <label class="block text-sm">
                            <span class="text-black">URL of Show <span class="text-[#a0a0a0]">(Vimeo or YouTube)</span></span>
                            <input
                                class="block video_link w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                                placeholder="Video Url" type="text"
                                name="video_link[]"
                                value=""
                            />
                        </label>
                    </div>

                    <div class="flex align-center flex-shrink-0 mt-6 icon-section w-[10%]">
                        <input class="featured_status" type="hidden" name="featured_status[]" value="1" />
                        <div class="btn btn-secondary text-uppercase focus:outline-none add-button"><i class="fa fa-plus fa-fw"></i></div>

                        <div class="btn btn-secondary text-uppercase focus:outline-none ml-1 remove-button" disabled><i class="fa fa-minus fa-fw"></i></div>

                        <div class='downImage ml-1'><i class="fa fa-caret-down" style="font-size:20px"></i></div>
                        <div class='plate_form_status ml-1'>
                            <span class="plate_form_show" style=""><i class="fa fa-eye" style="font-size:10px"></i></span>
                            <span class="plate_form_hide" style="display:none;"><i class="fa fa-eye-slash" style="font-size:10px"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dynamic-disclaimers-container">
                <div class="form-group mb-4 disc-dynamic-field" id="disclaimers-dynamic-field-1">
                    <label for="editor-1" class="mb-1 block  text-sm">Disclaimers</label>
                    <textarea class="mt-1 disclaimer-text" name="content[]" id="editor-1">
                    </textarea>
                </div>
            </div>

            <div class="flex justify-end items-center mt-4 gap-2">
                <div id="loader" style="display:none;"><img class="h-27 w-10" src="{{asset('assets/img/loader.gif')}}" alt="GlobalNation"></div>
                <input type="button" id="featured-submit-btn" class="cursor-pointer float-right text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]" value="Save">
            </div>
        </form>
    </div>
</main>

<script>
$(document).ready(function () {
    var container = $(".dynamic-fields-container");
    var disclaimersContainer = $("#disclaimers-dynamic-field");
    var bgContainer = $(".bg-container");
    var dylength =  $('.dynamic-field').length;
    var dynamicFieldCount = dylength;
    initTinyMCE("editor");
    container.on("click", ".add-button", function () {

        var field = $(this).closest(".dynamic-field");
        var clone = field.clone();
        // Increment the dynamicFieldCount for unique IDs
        dynamicFieldCount++;
        clone.attr("id", "dynamic-field-" + dynamicFieldCount);
        // Clear the uploaded file name in the cloned row
        clone.find('.featured_title').val('');
        clone.find('.video_link').val('');
        clone.find('.artist_ids').val(''); // Clear the input value
        field.after(clone);
        disableButtonRemove();

        var disfield = $(disclaimersContainer);
        var disclone = '<div class="form-group mb-4 disc-dynamic-field" id="disclaimers-dynamic-field-'+ dynamicFieldCount+'"><label for="editor" class="mb-1 block  text-sm">Disclaimers</label><textarea class="mt-1 disclaimer-text" name="content[]" id="editor-'+dynamicFieldCount+'"></textarea></div>';
        var filedId = "disc-dynamic-field-" + dynamicFieldCount;
        $(".dynamic-disclaimers-container").append(disclone);
        initTinyMCE("editor-"+dynamicFieldCount);
    });

    container.on("click", ".remove-button", function () {
        var field = $(this).closest(".dynamic-field");
        var id = $(this).closest(".dynamic-field").attr('id');
        id = id.replace('dynamic-field-', '');
        field.remove();
        $("#disclaimers-dynamic-field-"+id).remove();
        disableButtonRemove();
    });

    $(".disc-dynamic-field").each(function(){
        var getId = $(this).find('.disclaimer-text').attr('id');
        initTinyMCE(getId);
    });

    function initTinyMCE(textareaId) {
        tinymce.init({
        selector: `#${textareaId}`,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor | backcolor | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        height : "250",
        });
    }

    // Remove TinyMCE instance
    function removeTinyMCE(textareaId) {
            tinymce.get(textareaId).remove();
    }

    $('#artist-btn').on('click', function(e) {
        e.preventDefault();
        let myform = document.getElementById("add-artist-form");
        let fd = new FormData(myform);
        $.ajax({
            url: "{{ route('save-artist') }}",
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
                title: "Artist added successfully",
                showConfirmButton: false,
                timer: 2500
                });
                setTimeout( function(){
                    location.reload();
                }  , 2500 );
            },
            complete: function() {
                $('#loader').hide();
            }
        });
    });

    $('#featured-submit-btn').on('click', function(e) {
        e.preventDefault();
        let myform = document.getElementById("artist-featured-form");
        if (!myform.checkValidity()) {
            myform.reportValidity();
            return;
        }

        let fd = new FormData(myform);
        var page_title = $('.page_title').val();
        var slug = $('.page_slug').val();
        var page_slug = slug.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');

        var disclaimer = [];
        $(".disc-dynamic-field").each(function(index){
            var getId = $(this).find('.disclaimer-text').attr('id');
            var content = tinymce.get(getId).getContent();
            fd.append("disclaimer[]", content);
        });
        fd.append("status", 1);
        fd.append("page_title", page_title);
        fd.append("page_slug", page_slug);
        $.ajax({
            url: "{{ route('save-template-video') }}",
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
                title: "Record Added successfully",
                showConfirmButton: false,
                timer: 2500
                });
                setTimeout( function(){
                    location.reload();
                }  , 2500 );
            },
            complete: function() {
                $('#loader').hide();
            }
        });
    });

    $('#downloads-preview-btn').on('click', function(e) {
        e.preventDefault();
        let myform = document.getElementById("artist-featured-form");
        let fd = new FormData(myform);
        var disclaimer = [];
        $(".disc-dynamic-field").each(function(){
            var getId = $(this).find('.disclaimer-text').attr('id');
            var content = tinymce.get(getId).getContent();
            fd.append("disclaimer[]", content);
        });
        fd.append("status", 2);
        $.ajax({
            url: "{{ route('save-template-video') }}",
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
                title: "Featured Preview updated successfully",
                showConfirmButton: false,
                timer: 2500
                });
                setTimeout( function(){
                    window.open("https://globalnation.tv/featured/preview");
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

    $('.dynamic-fields-container').on('click', '.downImage', function () {
        var downParent = $(this).closest('div.dynamic-field').next();
        if (downParent.length > 0) {
            var sel = $(this).closest('div.dynamic-field').detach();
            sel.insertAfter(downParent);
        }
    });


    $(document).on('click', '.plate_form_show', function(){
        $(this).parent().parent().find('.featured_status').val('0');
        $(this).hide();
        $(this).parent().parent().find('.plate_form_hide').show();
    });

    $(document).on('click', '.plate_form_hide', function(){
        $(this).parent().parent().find('.featured_status').val('1');
        $(this).hide();
        $(this).parent().parent().find('.plate_form_show').show();
    });

    $(document).on('change', '.file-input', function () {
        var fileName = this.files[0].name;
       $('.bg-file-name').text(fileName);
    });

    $('#editor').find('.ck-editor__editable').css('min-height', '300px');

    $('.page_slug').keyup(function() {
        var value = $(this).val();
        var baseUrl = 'https://globalnation.tv/pages/';
        var add_slash = '| '
        if (value.trim() === '') {
            $('.show_slug').text('');
        } else {
            $('.show_slug').text(add_slash + baseUrl + value);
        }
    });

});
</script>
