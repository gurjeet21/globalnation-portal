@extends('layouts.app')

@section('content')
<main class="overflow-y-auto px-6 flex flex-1 flex-col grow">
    <h2 class="text-black font-semibold text-xl mt-8">Create Item</h2>
    @if(Session::has('success'))
    <div class="p-4 mb-2 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <span class="font-semibold">Success: </span> {{ session('success') }}
    </div>
    @endif
    <form method="post" action="{{ route('navigation.store') }}" class="flex grow flex-col bg-white w-full p-[1.875rem] mt-[1.875rem] gap-y-10 gap-x-10">
        @csrf
        <div class="space-y-10 w-full overflow-x-auto">
            <div class="edit-profile-sec">
                <!-- First Row -->
                <div class="mt-10 flex gap-x-6 gap-y-6 flex-col lg:flex-row">
                    <div class="3xl:min-w-[300px]">
                        <label for="name" class="text-base font-bold text-black">Name</label>
                        <div class="mt-[10px]">
                            <input type="text" name="name" value="{{ old('name') }}" id="name" class="outline-0 rounded-md border-0 py-[8.5px] text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-[#9CA3AF] px-2.5 text-sm w-full">
                        </div>
                        @if($errors->has('name'))
                        <div class="text-red-600">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="3xl:min-w-[300px]">
                        <label for="url" class="text-base font-bold text-black">URL</label>
                        <div class="mt-[10px]">
                            <input type="text" name="url" value="{{ old('url') }}" id="url" class="outline-0 rounded-md border-0 py-[8.5px] text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-[#9CA3AF] px-2.5 text-sm w-full">
                        </div>
                        @if($errors->has('url'))
                        <div class="text-red-600">{{ $errors->first('url') }}</div>
                        @endif
                    </div>
                    <div class="3xl:min-w-[300px]">
                        <label for="sort_order" class="text-base font-bold text-black">Sort Order</label>
                        <div class="mt-[10px]">
                            <input type="number" name="sort_order" value="{{ old('sort_order') }}" id="sort_order" class="outline-0 rounded-md border-0 py-[8.5px] text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-[#9CA3AF] px-2.5 text-sm w-full">
                        </div>
                        @if($errors->has('sort_order'))
                        <div class="text-red-600">{{ $errors->first('sort_order') }}</div>
                        @endif
                    </div>
                </div>

                <!-- Second Row -->
                <div class="mt-10 flex gap-x-6 gap-y-6 flex-col lg:flex-row">
                    <div class="3xl:min-w-[300px]">
                        <label for="menu_type" class="text-base font-bold text-black">Menu Type</label>
                        <div class="mt-[10px]">
                            <select name="menu_type" id="menu_type" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <option value="navbar" {{ old('menu_type') == 'navbar' ? 'selected' : '' }}>Navbar</option>
                                <option value="footer" {{ old('menu_type') == 'footer' ? 'selected' : '' }}>Footer</option>
                                <!-- Add more menu types as needed -->
                            </select>
                        </div>
                        @if($errors->has('menu_type'))
                        <div class="text-red-600">{{ $errors->first('menu_type') }}</div>
                        @endif
                    </div>
                    <div class="3xl:min-w-[300px]">
                        <label for="parent_id" class="text-base font-bold text-black">Parent Item</label>
                        <div class="mt-[10px]">
                            <select name="parent_id" id="parent_id" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <option value="">None</option>
                                @foreach($parents as $id => $name)
                                <option value="{{ $id }}" {{ old('parent_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($errors->has('parent_id'))
                        <div class="text-red-600">{{ $errors->first('parent_id') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Buttons -->
        <div class="mt-auto bg-white px-4 py-3 text-sm tracking-wide text-black border-t dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800 justify-end flex gap-2.5">
            <a href="{{ route('navigation.index') }}">
                <button type="button" class="text-black p-2.5 rounded border border-[#D1D5DB] hover:bg-[#EEEEEE] text-sm flex gap-1.5 items-center focus:outline-none">Back</button>
            </a>
            <button type="submit" class="text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]">Save Changes</button>
        </div>
    </form>
</main>
@endsection
