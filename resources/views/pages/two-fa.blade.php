@extends('layouts.app')

@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
	<form method="post" class="" action="{{route('complete_registration')}}">
	@csrf

<div class="block max-w-md rounded-lg bg-white p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
	@if(Session::has('success'))
		<div id="success_session" class="w-full text-center p-4 mb-1 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
              <span class="font-semibold">Success: </span> {{ Session::get('success') }}
        </div>
	@endif

	<p id="qr_code_msg"></p>
	@if(Session::has('error'))
		<div id="error_session" class="p-4 mb-4 text-center text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
		  <span class="font-semibold">Error : </span> {{session('error')}}
		</div>
	@endif
	<?php if($check_2fa->is_2fa_enable != 1){ // when user not enabled 2FA ?>
		
			<div class="w-full mb-6 text-center" role="alert">
				<h2 class="text-black text-center font-semibold text-xl">Enable Two-Factor Authentication</h2>
				<span class="text-[10px] text-center" id="alter_id">Alternatively, you can either generate a new QR code or enter a code directly.</span>
			</div>


			<div id="qr_img" class="text-center" style="text-align:-webkit-center">

			</div>
			<!-- <img src="" id="qrCodeUrl" alt="" class="m-auto"> -->
			<div class="w-full mb-6 mt-6" role="alert">
				<button type="button" id="generate_qr_code" class="mt-1 text-white p-2.5 rounded-[5px] bg-[#4F46E5] hover:bg-[#F8F6F6] text-sm cursor-pointer inline-block w-full rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase  shadow-[0_4px_9px_-4px_#3b71ca] " data-te-ripple-init data-te-ripple-color="light">
					Generate QR code
				</button>
				<div class="mt-3">

						<div class="row text-center mb-2" id="or_row">
							OR
						</div>
						<input type="text" value="" name="code" placeholder="Enter Code" id="code" class="outline-0 rounded-md border-0 py-[8.5px] text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-[#9CA3AF] px-2.5 text-sm w-full">

						@if($errors->has('code'))
						<div class="text-red-600">{{ $errors->first('code') }}</div>
						@endif
						<button type="button" id="enable_fa" class="mt-1 text-white p-2.5 rounded-[5px] bg-[#4F46E5] hover:bg-[#F8F6F6] text-sm cursor-pointer inline-block w-full rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase  shadow-[0_4px_9px_-4px_#3b71ca] " data-te-ripple-init data-te-ripple-color="light">Enable</button>
				</div>
			</div>
	<?php }else{ // when user already enabled 2FA ?>

			<div class="w-full mb-6 text-center" role="alert">
				<h2 class="text-black text-center font-semibold text-xl">Disable Two-Factor Authentication</h2>
				<span class="text-[10px] text-center">Please enter password to disable two factor authentication</span>
			</div>

			<input type="password" value="" name="password" placeholder="Enter Your Login Password" id="code" class="outline-0 rounded-md border-0 py-[8.5px] text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-[#9CA3AF] px-2.5 text-sm w-full">
			@if($errors->has('password'))
			<div class="text-red-600">{{ $errors->first('password') }}</div>
			@endif
			<input type="hidden" name="is_disble" value="1">
			<div class="relative mb-6 mt-3" data-te-input-wrapper-init>
				<button type="submit" class="mt-1 text-white p-2.5 rounded-[5px] bg-[#4F46E5] hover:bg-[#F8F6F6] text-sm cursor-pointer inline-block w-full rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase  shadow-[0_4px_9px_-4px_#3b71ca] " data-te-ripple-init data-te-ripple-color="light">
					Disable
				</button>
			</div>
		
	<?php } ?>
</div>
	</form>
</main>
@endsection


@section('script')
<script>
	$(document).on('click','#generate_qr_code',function(){
		$('#success_session').hide('');
		$('#error_session').hide('');
		$('#or_row').hide('');
		$('#alter_id').hide('');
		$('#qr_img').html('<div role="status"><svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg></div>');
		generate_qr_code();
	});


	$(document).on('click','#enable_fa',function(){
		$('#success_session').hide('');
		$('#error_session').hide('');
		enable_fa()
	});

	function enable_fa(){
		var code = $('#code').val();
		$.ajax({
			url: "{{route('complete_registration')}}",
			method: "POST",
			data : {code : code,"_token": "{{ csrf_token() }}",},
			success: function(data) {
				console.log(data);
				var html = '';
				if(data.status == '201'){
					html = '<div class="p-4 mb-4 text-center text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert"><span class="font-semibold">Error: </span> '+data.msg+'</div>';
				}else{
					html = '<div class="w-full text-center p-4 mb-1 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert"><span class="font-semibold">Success: </span> '+data.msg+'</div>';

					setTimeout(function(){
						window.location.reload();
					}, 1000);
				}

				$('#qr_code_msg').html(html);
			},
			error: function(xhr, status, error) {
				console.error("Request failed: " + status + ", Error: " + error);
			}
		});
	}

	function generate_qr_code(){
		$.ajax({
			url: "{{route('generate_qr')}}",
			method: "GET",
			success: function(data) {
				var img = '';
				if(data.qrCodeUrl){
					img = '<img style="display:none;"  src="'+data.qrCodeUrl+'" id="qrCodeUrl" alt="" class="m-auto">';
					
					$('#display_enable').css('display','block');
					$('#generate_qr_code').css('display','none');
				}else{
					$('#display_enable').css('display','none');
					$('#generate_qr_code').css('display','block');
					return false;
				}

				setTimeout(function(){
					$('#qr_img').html('<span class="text-[10px] text-center">Please scan and enter autentication code to enable two factor authentication</span><br><br>'+img);
					$('#qr_img>img').css('display','block');
				}, 1000);
			},
			error: function(xhr, status, error) {
				console.error("Request failed: " + status + ", Error: " + error);
			}
		});
	}
</script>
@endsection


