@extends('layouts.app')

@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
		<div class="flex align-center justify-between">
			<h2 class="text-black font-semibold text-xl">Manage Pages</h2>
			<button id="openA" class="text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]"><a href="/pages/add-page">Add user</a></button>
		</div>

		<div class="flex align-center justify-between mt-2">
			@if(Session::has('succ_msg'))
				<div class="w-full text-center p-4 mb-1 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
	                  <span class="font-semibold">Success: </span> {{ Session::get('succ_msg') }}
	            </div>
			@endif

			@if($errors->has('email'))
			<div class="w-full bg-red-100 border border-red-400 text-center text-red-700 px-4 py-3 rounded relative " role="alert">
				  <strong class="font-bold">Error : </strong>
				  <span class="block sm:inline">{{ $errors->first('email') }}</span>
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
                     
                      <th class="px-4 py-3">Page Title</th>
                      <th class="px-4 py-3">Slug</th>
                      <th class="px-4 py-3">Created At</th>
                      <th class="px-4 py-3">Action</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800" >
                    @forelse($pages as $key=>$page)
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3 text-sm">
                      {{$page['page_title'] ? strip_tags($page['page_title']) : '-'}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                      {{$page['page_slug'] ? $page['page_slug'] : '-'}}
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{$page['created_at'] ? $page['created_at'] : '-'}}
                      </td>                   
                        @if(\Auth::user()->role == 'Super Admin')
                        <td class="whitespace-nowrap px-3 py-2.5 text-sm text-center text-black">
                            <div class="flex items-center space-x-4 text-sm justify-center">
                                <a href="/pages/{{($page['is_dynamic']) == 1 ? 'dynamic/' : ''}}{{$page['page_slug']}}" class="flex items-center justify-between text-sm font-medium leading-5 text-[#125EF6]" aria-label="Edit">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                </a>
                                @if($page['is_dynamic'] == 1)
                                <a onclick="return confirm('Are you sure to delete this page?');" href="{{route('page.dynamic.delete',['id'=>$page['id']])}}" class="flex items-center justify-between text-sm font-medium leading-5 text-[#FF3939]" aria-label="Delete">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </a> 
                                @endif                              
                            </div>
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
