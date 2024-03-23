@extends('layouts.app')
@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
    <div class="container p-[1.875rem] mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <form class="grid grid-cols-1 md:grid-cols-12 gap-8">
            <div class="mb-6 md:col-span-12">
                <div class="flex gap-4">
                    <div class="w-full">
                        <label class="block text-sm  mb-4">
                            <span class="text-black">Featured Artist Title</span>
                            <input
                                class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee]  focus:outline-none dark:focus:shadow-outline-gray form-input"
                                placeholder="Page Title" type="text" name="page_title"
                                value=""
                            />
                            <input type="hidden" name="page_id" value=""/>
                        </label>
                    </div>
                    <div class="w-full">
                        <label class="block text-sm  mb-4">
                            <span class="text-black">Video Link (Youtube, Vimeo)</span>
                            <input
                                class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee]  focus:outline-none dark:focus:shadow-outline-gray form-input"
                                placeholder="Video Link" type="text" name="video_link"
                                value=""
                            />
                        </label>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-full">
                        <div class="form-group">
                            <label for="description">Page Description</label>
                            <textarea class="mt-1"  name="page_desc" id="page_description">

                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between w-full px-3">
                    <div class="md:flex md:items-center">
                        <label class="block text-gray-500 font-bold">
                            <input class="mr-2 leading-tight" type="checkbox">
                            <span class="text-sm">
                                Send me your newsletter!
                            </span>
                        </label>
                    </div>
                    <button
                        class="shadow bg-indigo-600 hover:bg-indigo-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-6 rounded"
                        type="submit">
                        Send Message
                    </button>
                </div>
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
        selector: '#page_description',
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
        setup: function (page_description) {
            page_description.on('init', function () {
                console.log('Editor was initialized', page_description);
                if (page_description.id === 'page_description') {
                    editorDescription = page_description;
                }
            });
        }
    });
 });
</script>
@endsection
