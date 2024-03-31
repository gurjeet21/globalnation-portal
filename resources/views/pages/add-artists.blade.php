@extends('layouts.app')

@section('content')

    <main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
    <div class="container p-[1.875rem] mx-auto bg-white rounded-[5px] mt-[1.875rem]">
        <form method="post" id="add-featured" action="" enctype="multipart/form-data">
            <div class="flex gap-4 mb-4">
                <div class="w-2/4 bg-container flex gap-5">
                    <div class="profile-pic">
                        <img  id="filePreviewImage" class="h-[6.25rem] w-[6.25rem] rounded-full bg-gray-50" src="" alt="">
                    </div>
                    <div class="flex flex-col gap-2.5">
                        <input type="file" name="img" id="fileUploadInput" hidden />
                        <label for="fileUploadInput" class="text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]">Change your photo</label>

                        <input type="hidden" id="is_remove" name="is_remove" value="0">

                        <button id="remove_photo" type="button" class="text-black p-2.5 rounded border border-[#D1D5DB] hover:bg-[#EEEEEE] text-sm flex gap-1.5 focus:outline-none">
                            <img src="{{asset('assets/img/remove.png')}}"> Remove photo
                        </button>
                    </div>
                </div>

                <div class="w-2/4 bg-container">
                </div>
            </div>

            <div class="flex mb-4 gap-4 dynamic-field items-center">
                <div class="w-2/4">
                    <label class="block text-sm">
                        <span class="text-black">First Name</span>
                        <input
                            class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                            placeholder="First Name" type="text" name="first_name"
                        />
                    </label>
                </div>
                <div class="w-2/4">
                    <label class="block text-sm">
                        <span class="text-black">Last Name</span>
                        <input
                            class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee]  focus:outline-none dark:focus:shadow-outline-gray form-input"
                            placeholder="Last Name" type="text" name="last_name"
                            value=""
                        />
                    </label>
                </div>
            </div>

            <div class="flex mb-4 gap-4 dynamic-field items-center">
                <div class="w-2/4">
                    <label class="block text-sm">
                        <span class="text-black">Email Address</span>
                        <input
                            class="block w-full mt-1 text-sm bg-[#eeeeee] dark:border-gray-600 dark:bg-[#eeeeee] focus:outline-none form-input"
                            placeholder="Email" type="text" name="email_add"
                        />
                    </label>
                </div>
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
<script type="text/javascript">
$("#fileUploadInput").change(function(event){
    $("#filePreviewImage").attr('src',URL.createObjectURL(event.target.files[0]));
});

$(document).on('click', '.iti__country', function () {
    var dial_code = $(this).attr('data-dial-code');
    $('#dial_code').val(dial_code);
});

$("#remove_photo").click(function(event){
    $("#filePreviewImage").attr('src','');
    $('#is_remove').val(1);
});
</script>
<script>
  const input = document.querySelector("#phone");
  window.intlTelInput(input, {
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.4.0/build/js/utils.js",
    separateDialCode: true,
    initialCountry: "IN",

  });
</script>
@endsection
