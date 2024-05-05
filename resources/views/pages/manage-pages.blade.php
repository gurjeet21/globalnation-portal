@extends('layouts.app')

@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
		<div class="flex align-center justify-between">
			<h2 class="text-black font-semibold text-xl">Manage Pages</h2>
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
			<div class="w-full overflow-hidden flex flex-1 flex-col rounded-lg shadow-xs p-3">
				<div class="w-full overflow-x-auto">
					<!-- New Table -->
					<table id="all_pages_tbl" class="w-full whitespace-no-wrap" style="width: 100%;">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >

                      <th class="px-4 py-3">Page Title</th>
                      <th class="px-4 py-3">Slug</th>
                      <th class="px-4 py-3">Url</th>
                      <th class="px-4 py-3">Created At</th>
                      <th class="px-4 py-3">Action</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800" >
                    @forelse($pages as $page)
                        @if(!empty($page['page_slug']))
                            <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                            {{$page['page_title'] ? strip_tags($page['page_title']) : '-'}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                            {{$page['page_slug'] ? $page['page_slug'] : '-'}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                            <a target="_blank" href="https://globalnation.tv/pages/{{$page['page_slug']}}">https://globalnation.tv/pages/{{$page['page_slug']}}</a>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$page['created_at'] ? $page['created_at'] : '-'}}
                            </td>
                                @if(\Auth::user()->role == 'Super Admin')
                                <td class="whitespace-nowrap px-3 py-2.5 text-sm text-center text-black">
                                    <div class="flex items-center space-x-4 text-sm justify-center">
                                        <a href="/pages/{{$page['page_slug']}}" class="flex items-center justify-between text-sm font-medium leading-5 text-[#125EF6]" aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                        <a onclick="return confirm('Are you sure to delete this page?');"
                                            href="{{ route('page.dynamic.delete', ['id' => $page['id'], 'table' => $page['table_name']]) }}"
                                            class="flex items-center justify-between text-sm font-medium leading-5 text-[#FF3939]" aria-label="Delete">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                        </a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @endif
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
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script>
        $(document).ready(function(){
        $('#all_pages_tbl').DataTable({
            "lengthMenu": [5, 10, 25, 50, 75, 100],
            "pageLength": 10, // Default number of rows per page
            "searching": true, // Enable search feature
            "ordering": true, // Enable ordering (sorting) of columns
            "info": true, // Display information about the table (e.g., "Showing 1 to 10 of 25 entries")
            "paging": true, // Enable pagination
            "responsive": true // Make the table responsive
        });
    });
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
