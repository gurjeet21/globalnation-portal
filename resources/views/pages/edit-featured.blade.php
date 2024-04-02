@extends('layouts.app')
@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
    <div class="container p-[1.875rem] mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <form method="post" id="update-featured-form" action="" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="featured_id" value="{{$artistFeatureds->id}}"/>
            <div class="flex gap-4">
                <div class="w-2/4 bg-container">
                    <label class="block text-sm  mb-4">
                        <span class="text-black">Select Artist</span>
                        <div class="mt-1 p-2 upload_new_build bg-[#eeeeee] dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">
                            <select name="artist_id" class="block w-full mt-1 text-sm form-select focus:outline-none  dark:focus:shadow-outline-gray" >
                                    <option value="">--Please select the Artist --</option>
                                    @foreach($artists as $artist)
                                    <option value="{{$artist->id}}" {{ ($artistFeatureds->artist_id) ===  $artist->id  ? 'selected' : ''}}>{{$artist->first_name}} {{$artist->last_name}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <span class="error error_artist_id"></span>
                    </label>
                </div>
                <div class="w-2/4 bg-container">
                </div>
            </div>

            <div class="flex mb-4 gap-4 dynamic-field items-center">
                <div class="w-2/4">
                    <label class="block text-sm">
                        <span class="text-black">Featured Title</span>
                        <input
                            class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                            placeholder="Page Title" type="text" name="featured_title" value="{{$artistFeatureds->title}}"
                        />
                    </label>
                    <span class="error error_featured_title"></span>
                </div>
                <div class="w-2/4">
                    <label class="block text-sm">
                        <span class="text-black">Video Link (Youtube, Vimeo)</span>
                        <input
                            class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee]  focus:outline-none dark:focus:shadow-outline-gray form-input"
                            placeholder="Video Link" type="text" name="video_link"
                            value="{{$artistFeatureds->video_url}}"
                        />
                    </label>
                    <span class="error error_video_link"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="block text-sm mb-1">Featured Description</label>
                <textarea class="mt-1" name="featured_description" id="featured_description">
                    {{$artistFeatureds->description}}
                </textarea>
                <span class="error error_featured_description"></span>
            </div>

            <div class="flex justify-end items-center mt-4 gap-2">
                <div id="loader" style="display:none;"><img class="h-27 w-10" src="{{asset('assets/img/loader.gif')}}" alt="GlobalNation"></div>
                <input type="button" id="featured-btn" class="cursor-pointer float-right text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]" value="Save">
            </div>
        </form>
    </div>
</main>
@endsection
@section('script')
<!-- Javascript code -->
<script>
 $(document).ready(function () {
    let editorDescription ;
    tinymce.init({
        selector: '#featured_description',
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
                if (editor.id === 'featured_description') {
                    editorDescription = editor;
                }
            });
        }
    });

    $('#featured-btn').on('click', function(e) {
        e.preventDefault();
        $(".error").html('');
        if(editorDescription) {
            var textContent = editorDescription.getContent();
        }
        let myform = document.getElementById("update-featured-form");
        let fd = new FormData(myform);
        fd.set("featured_description", textContent);
        fd.append("is_preview", 0);
        $.ajax({
            url: "{{route('artist.featured.update',['id'=>$artistFeatureds->id])}}",
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
                title: "Featured updated successfully",
                showConfirmButton: false,
                timer: 2500
                });
                setTimeout( function(){
                    window.location.replace("/pages/manage-featured");
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
    })

    $('#featured-preview-btn').on('click', function(e) {
        e.preventDefault();
        $(".error").html('');
        if(editorDescription) {
            var textContent = editorDescription.getContent();
        }
        let myform = document.getElementById("update-featured-form");
        let fd = new FormData(myform);
        fd.set("featured_description", textContent);
        fd.append("is_preview", 1);
        $.ajax({
            url: "{{route('artist.featured.update',['id'=>$artistFeatureds->id])}}",
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
                title: "Featured updated successfully",
                showConfirmButton: false,
                timer: 2500
                });
                setTimeout( function(){
                    window.open("https://globalnation.tv/featured/preview");
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
    })

});
</script>
@endsection
