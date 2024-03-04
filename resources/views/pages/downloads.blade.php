@extends('layouts.app')
@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
    <div class="container p-[1.875rem] mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <form action="">

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm  mb-4">
                        <span class="text-black">Page Title</span>
                        <input
                            class="block mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee]  focus:outline-none dark:focus:shadow-outline-gray form-input"
                            placeholder="Downloads" type="text"
                        />
                    </label>
                </div>
            </div>

            <div class="dynamic-fields-container">
                <div class="flex mb-4 gap-4 dynamic-field items-center" id="dynamic-field-1">
                    <div class="flex-1">
                        <label class="block text-sm">
                            <span class="text-black">Plateform</span>
                            <input
                                class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                                placeholder="Downloads" type="text"
                            />
                        </label>
                    </div>

                    <div class="flex-1">
                        <label class="block text-sm">
                            <span class="text-black">Upload New Build</span>
                            <div class="mt-1 p-2 bg-[#eeeeee] dark:border-gray-600 cursor-pointer rounded border border-solid border-secondary-600 relative">
                                <span class="bg-white px-2 py-1 rounded file-label">Choose File</span>
                                <input class="hidden file-input" type="file">
                            </div>
                        </label>
                    </div>

                    <div class="flex align-center flex-shrink-0 mt-6 icon-section">
                        <div class="btn btn-secondary text-uppercase focus:outline-none add-button"><i class="fa fa-plus fa-fw"></i></div>

                        <div class="btn btn-secondary text-uppercase focus:outline-none ml-1 remove-button" disabled><i class="fa fa-minus fa-fw"></i></div>

                        <div class='downImage ml-1'><i class="fa fa-caret-down" style="font-size:20px"></i></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="editor">Disclaimers</label>
                <div class="mt-1" id="editor"></div>
            </div>

            <button type="submit" class="mt-4 float-right text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]">Save</button>
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

    // Initialize CKEditor on the specified textarea
    ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });

    $('#editor').find('.ck-editor__editable').css('min-height', '300px');

});
</script>

@endsection
