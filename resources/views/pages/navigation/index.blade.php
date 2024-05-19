@extends('layouts.app')

@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
    <div class="flex align-center justify-between">
        <h2 class="text-black font-semibold text-xl">Manu Management</h2>
        <a href="{{ route('navigation.create') }}" class="text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]">Add Menu Items</a>
    </div>

    <div class="flex align-center justify-between mt-2">
        @if(Session::has('success'))
        <div class="w-full text-center p-4 mb-1 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <span class="font-semibold"></span> {{ Session::get('success') }}
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
                            <th class="px-4 py-3">name</th>
                            <th class="px-4 py-3">url</th>
                            <th class="px-4 py-3 w-1/4">Child Item</th>
                            <th class="px-4 py-3 w-1/4">menu type</th>
                            <th class="px-2 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse($navigationItems as $key=>$navigationItem)
                        <tr class="text-gray-700 dark:text-gray-400">

                            <td class="px-4 py-3 text-sm">
                                {{$navigationItem->name ? $navigationItem->name : '-'}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$navigationItem->url ? $navigationItem->url : '-'}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <select name="" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" style="width: 150px;">
                                    @foreach($navigationItem->children as $child)
                                    <option value="{{ $child->name }}">
                                        {{ ucfirst($child->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$navigationItem->menu_type ? $navigationItem->menu_type : '-'}}
                            </td>

                            <td class="whitespace-nowrap px-3 py-2.5 text-sm text-center text-black">
                                <div class="flex items-center space-x-4 text-sm justify-left">
                                    <a href="{{route('navigation.edit',['navigationItem'=>$navigationItem])}}" class="flex items-center justify-between text-sm font-medium leading-5 text-[#125EF6]" aria-label="Edit">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                    <a onclick="return confirm('Are you sure to delete this user?');" href="{{route('navigation.destroy',['navigationItem'=>$navigationItem])}}" class="flex items-center justify-between text-sm font-medium leading-5 text-[#FF3939]" aria-label="Delete">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </div>
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
    <form method="GET" action="{{ route('navigation.index') }}" class="mt-4">
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
    {{ $navigationItems->appends(['itemsPerPage' => $itemsPerPage])->links() }}
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
        var openButton = document.getElementById('openA');
        var dialog = document.getElementById('dialog');
        var closeButton = document.getElementById('closeA');
        var overlay = document.getElementById('overlay');

        // show the overlay and the dialog
        openButton.addEventListener('click', function() {
            dialog.classList.remove('hidden');
            overlay.classList.remove('hidden');
        });

        // hide the overlay and the dialog
        closeButton.addEventListener('click', function() {
            dialog.classList.add('hidden');
            overlay.classList.add('hidden');
        });
    });
</script>

@endsection