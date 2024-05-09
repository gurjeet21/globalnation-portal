@extends('layouts.app')

@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
  <div class="flex align-center justify-between">
    <h2 class="text-black font-semibold text-xl">List of Interocitor Members</h2>
  </div>
  <div id="loader" class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
  <!-- Loader with rotating animation -->
  <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-24 w-24 animate-spin"></div>
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
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th class="px-4 py-3">Member ID</th>
              <th class="px-4 py-3">Salutation</th>
              <th class="px-4 py-3">Email</th>
              <th class="px-4 py-3">Moniker</th>
              <th class="px-4 py-3">Registered Devices</th>
              <th class="px-4 py-3">First Time</th>
              <th class="px-4 py-3">Last Time
              <a href="#" class="sort-arrow" data-sort="asc">&#9650;</a> <!-- Up arrow -->
             <a href="#" class="sort-arrow" data-sort="desc">&#9660;</a> <!-- Down arrow -->
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @forelse($members as $key=>$member)
            <tr class="text-gray-700 dark:text-gray-400">
              <td class="px-4 py-3 text-sm">
                {{$member->member_id ? $member->member_id : '-'}}
              </td>
              <td class="px-4 py-3 text-sm">
                {{$member->member_name ? $member->member_name : '-'}}
              </td>
              <td class="px-4 py-3 text-sm">
                {{$member->email ? $member->email : '-'}}
              </td>
              <td class="px-4 py-3 text-sm">
                {{$member->moniker ? $member->moniker : '-'}}
              </td>

              <td class="px-4 py-3 text-xs">
                <select name="" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" style="min-width: 200px;">
                  @foreach($member->devices as $device)
                  <option value="{{ $device->device_name }}">
                    {{ ucfirst($device->device_name) }}
                  </option>
                  @endforeach
                </select>
              </td>
              <td class="px-4 py-3 text-sm">
                {{$member->first_time ? $member->first_time : '-'}}
              </td>
              <td class="px-4 py-3 text-sm">
                {{$member->last_time ? $member->last_time : '-'}}
              </td>

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
  <!-- Form to select items per page -->
  <form method="GET" action="{{ route('interocitormembers') }}" class="mt-4">
    <label for="itemsPerPage">Items Per Page:</label>
    <select name="itemsPerPage" id="itemsPerPage" onchange="this.form.submit()">
      <option value="10" {{ $itemsPerPage == 10 ? 'selected' : '' }}>10</option>
      <option value="25" {{ $itemsPerPage == 25 ? 'selected' : '' }}>25</option>
      <option value="50" {{ $itemsPerPage == 50 ? 'selected' : '' }}>50</option>
      <!-- Add more options as needed -->
    </select>
    <!-- Include current page in the form -->
    @if(request()->has('page'))
    <input type="hidden" name="page" value="{{ request('page') }}">
    @endif
  </form>
  <!-- Pagination links -->
  {{ $members->appends(['itemsPerPage' => $itemsPerPage])->links() }}
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
  $(document).ready(function() {
   
    $('.sort-arrow').click(function(e) {
      
        e.preventDefault();
        var sortDirection = $(this).data('sort');
        var sortBy = 'last_time'; // Column to sort by
        // Show loader
        $('#loader').removeClass('hidden');
        $('#loader').addClass('block');
        // Make AJAX request to get sorted data
        $.ajax({
            url: '/sort-data',
            type: 'GET',
            data: {
                sortBy: sortBy,
                sortDirection: sortDirection
            },
            success: function(response) {
              
                // Update table body with sorted data
                var tableBody = $('table tbody');
                tableBody.empty(); // Clear existing content

                // Append sorted data to table body
                $.each(response, function(index, member) {
                  
                  var row = '<tr class="text-gray-700 dark:text-gray-400">' +
                        '<td class="px-4 py-3 text-sm">' + (member.member_id ? member.member_id : '-') + '</td>' +
                        '<td class="px-4 py-3 text-sm">' + (member.member_name ? member.member_name : '-') + '</td>' +
                        '<td class="px-4 py-3 text-sm">' + (member.email ? member.email : '-') + '</td>' +
                        '<td class="px-4 py-3 text-sm">' + (member.moniker ? member.moniker : '-') + '</td>' +
                        '<td class="px-4 py-3 text-xs">' +
                        '<select name="" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" style="min-width: 200px;">' +
                        (member.devices ? member.devices.map(device => '<option value="' + device.device_name + '">' + (device.device_name ? device.device_name.charAt(0).toUpperCase() + device.device_name.slice(1) : '') + '</option>').join('') : '') +
                        '</select>' +
                        '</td>' +
                        '<td class="px-4 py-3 text-sm">' + (member.first_time ? member.first_time : '-') + '</td>' +
                        '<td class="px-4 py-3 text-sm">' + (member.last_time ? member.last_time : '-') + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
                $('#loader').removeClass('block');
                $('#loader').addClass('hidden');
            },
            error: function(xhr) {
                // Handle error
            }
        });
    });
  });
  
</script>
<style>
        /* Your CSS rules go here */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loader {
            border-top-color: #3498db;
            border-left-color: #3498db;
            animation: spin 1.5s linear infinite;
        }
    </style>
@endsection