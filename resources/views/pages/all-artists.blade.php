@extends('layouts.app')

@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
		<div class="flex align-center justify-between">
			<h2 class="text-black font-semibold text-xl">List of Artists</h2>
		</div>

		<div class="flex align-center justify-between mt-2">
			@if(Session::has('succ_msg'))
				<div class="w-full text-center p-4 mb-1 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
	                  <span class="font-semibold">Success: </span> {{ Session::get('succ_msg') }}
	            </div>
			@endif
	    </div>

		<div class="container grid grow p-[1.875rem] mx-auto bg-white rounded-[5px] mt-[1.875rem]">
			<div class="w-full overflow-hidden flex flex-1 flex-col rounded-lg shadow-xs">
				<div class="w-full overflow-x-auto">
					<!-- New Table -->
					<table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">Name</th>
                      <th class="px-4 py-3">Email</th>
                      @if(\Auth::user()->role == 'Super Admin')
                      <th class="px-4 py-3">Action</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800" >
                    @forelse($allartists as $key=>$allartist)
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3 text-sm">
                        {{$allartist->first_name ? $allartist->first_name : '-'}}
                      </td>

                      <td class="px-4 py-3 text-sm">
                      {{$allartist->email ? $allartist->email : '-'}}
                      </td>

                    @if(\Auth::user()->role == 'Super Admin')
                        <td class="whitespace-nowrap px-3 py-2.5 text-sm text-center text-black">
                            <a onclick="return confirm('Are you sure to delete this artist?');"
                                href="{{ route('page.artist.delete', ['artist_id' => $allartist['id']]) }}"
                                class="flex items-center justify-between text-sm font-medium leading-5 text-[#FF3939]" aria-label="Delete">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                            </a>
                        </td>
                    @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No record found</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>

				</div>
			</div>
		</div>

	</main>

	<!-- Overlay element -->
		<div id="overlay" class="fixed hidden z-40 w-screen h-screen inset-0 bg-gray-900 bg-opacity-60"></div>

		<!-- The dialog -->
		<div id="dialog" class="hidden fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 bg-white rounded-md px-2 py-2 drop-shadow-lg">
				<header class="flex justify-end">
          <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700 closeA" id="closeA">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
              <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
          </button>
        </header>
				<form method="post" action="{{route('user.add')}}" enctype="multipart/form-data" class="mt-1 p-3">
					@csrf
					<div class="py-2">
						<label for="email" class="text-base font-bold text-black">Email address</label>
						<div class="mt-[10px]">
								<input type="email" value="" name="email" id="email" class="outline-0 rounded-md border-0 py-[8.5px] text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-[#9CA3AF] px-2.5 text-sm w-full">
						</div>


					</div>
					<div class="flex justify-end">
						<!-- This button is used to close the dialog -->
						<button type="submit" id="close" class="closeA text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]">Submit</button>
					</div>
				</form>
		</div>


@endsection


@section('script')
	<!-- Javascript code -->
    <script>
    	$(document).ready(function(){
    		var openButton = document.getElementById('openA');
	        var dialog = document.getElementById('dialog');
	        var closeButton = document.getElementById('closeA');
	        var overlay = document.getElementById('overlay');

	        // show the overlay and the dialog
	        openButton.addEventListener('click', function () {
	            dialog.classList.remove('hidden');
	            overlay.classList.remove('hidden');
	        });

	        // hide the overlay and the dialog
	        closeButton.addEventListener('click', function () {
	            dialog.classList.add('hidden');
	            overlay.classList.add('hidden');
	        });
    	});

    </script>

    @endsection
