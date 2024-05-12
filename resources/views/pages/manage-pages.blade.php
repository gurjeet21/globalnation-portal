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
                    @php
                        $encountered_slugs = []; // Array to keep track of encountered slugs
                    @endphp

                    @foreach($pages as $page)
                        @if(!in_array($page['page_slug'], $encountered_slugs) && !empty($page['page_slug']) && $page['page_slug'] !== '-')
                            @php $encountered_slugs[] = $page['page_slug']; @endphp

                            {{-- Your existing code to display the page --}}
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm">
                                    {{$page['page_title'] ? strip_tags($page['page_title']) : '-'}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{$page['page_slug'] ? $page['page_slug'] : '-'}}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <a target="_blank" href="https://globalnation.tv/{{$page['custom_slug']}}/{{$page['page_slug']}}">https://globalnation.tv/{{$page['custom_slug']}}/{{$page['page_slug']}}</a>
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
                                            <a onclick="showConfirmationModal('{{ route('page.dynamic.delete', ['page_slug' => $page['page_slug'], 'table' => $page['table_name']]) }}')"
                                            class="{{$page['table_name']}} flex items-center justify-between text-sm font-medium leading-5 text-[#FF3939]" aria-label="Delete">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            </a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                  </tbody>
                </table>

				</div>
			</div>
		</div>


<!-- Modal -->
<div id="confirmationModal" class="fixed inset-0 z-10 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- Modal content -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <img
                            aria-hidden="true"
                            class="object-cover w-full h-full dark:hidden"
                            src="../assets/img/circle-exclamation.svg"
                            alt="Office"
                        />
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Are you sure?
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete this page? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button id="cancelDelete" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
                <button id="confirmDelete" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Yes
                </button>
            </div>
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


    function showConfirmationModal(deleteUrl) {
        // Show the modal
        $('#confirmationModal').removeClass('hidden');

        // Store the delete URL in a data attribute
        $('#confirmDelete').data('delete-url', deleteUrl);
    }

    function hideConfirmationModal() {
        // Hide the modal
        $('#confirmationModal').addClass('hidden');
    }

    $(document).ready(function() {
        // Handle delete confirmation
        $(document).on('click', '#confirmDelete', function() {
            // Retrieve the delete URL from the data attribute
            var deleteUrl = $(this).data('delete-url');

            // Redirect to the delete URL
            window.location.href = deleteUrl;
        });

        // Handle cancel delete
        $('#cancelDelete').click(function() {
            // Hide the modal
            hideConfirmationModal();
        });
    });

    </script>

    @endsection
