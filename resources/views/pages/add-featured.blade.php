@extends('layouts.app')
@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
    <div class="container p-[1.875rem] mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <form method="post" id="add-featured" action="" enctype="multipart/form-data">
            <div class="flex gap-4">
                <div class="w-2/4 bg-container">
                    <label class="block text-sm  mb-4">
                        <span class="text-black">Select Artist</span>
                        <div class="mt-1 p-2 upload_new_build bg-[#eeeeee] dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">
                            <select name="user_role" class="block w-full mt-1 text-sm form-select focus:outline-none  dark:focus:shadow-outline-gray" >
                                    <option value="abc">ABC</option>
                                    <option value="xyx">XYZ</option>
                            </select>
                        </div>
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
                            placeholder="Page Title" type="text" name="page_title"
                        />
                    </label>
                </div>
                <div class="w-2/4">
                    <label class="block text-sm">
                        <span class="text-black">Video Link (Youtube, Vimeo)</span>
                        <input
                            class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee]  focus:outline-none dark:focus:shadow-outline-gray form-input"
                            placeholder="Video Link" type="text" name="video_link"
                            value=""
                        />
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="block text-sm mb-1">Featured Description</label>
                <textarea class="mt-1"  name="page_desc" id="featured_description">

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
        setup: function (featured_description) {
            featured_description.on('init', function () {
                console.log('Editor was initialized', featured_description);
                if (featured_description.id === 'featured_description') {
                    editorDescription = featured_description;
                }
            });
        }
    });
 });
</script>
@endsection
