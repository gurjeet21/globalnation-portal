@extends('layouts.app')
@section('content')
    <main class="overflow-y-auto px-6 flex flex-1 flex-col grow">
                <h2 class="text-black font-semibold text-xl mt-8">Edit Video Type</h2>
                @if(Session::has('success'))
                    <div class="p-4 mb-2 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                          <span class="font-semibold">Success: </span> {{session('success')}}
                    </div>
                @endif
                <form method="post" action="{{route('videotype.update',['video_type_id'=>$video_type->id])}}" class="flex grow flex-col bg-white w-full p-[1.875rem] mt-[1.875rem] gap-y-10 gap-x-10" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-10 w-full overflow-x-auto">
                        <div class="edit-profile-sec">

                            <div class="mt-10 flex gap-x-6 gap-y-6 flex-col lg:flex-row">
                                <div class="3xl:min-w-[300px]">
                                    <label for="full-name" class="text-base font-bold text-black">Video Type</label>
                                    <div class="mt-[10px]">
                                        <input type="text" name="name" value="{{ $video_type->first_name }}" id="full-name"  class="outline-0 rounded-md border-0 py-[8.5px] text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-[#9CA3AF] px-2.5 text-sm w-full">
                                    </div>
                                    @if($errors->has('name'))
                                        <div class="text-red-600">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto bg-white px-4 py-3 text-sm tracking-wide text-black border-t dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800 justify-end flex gap-2.5">

                        <a href="{{ route('video-types') }}">
                        <button type="button" class="text-black p-2.5 rounded border border-[#D1D5DB] hover:bg-[#EEEEEE] text-sm flex gap-1.5 items- focus:outline-none">Back</button>
                        </a>
                        <button type="submit"
                            class="text-white py-[5px] px-[10px] focus:outline-none bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8]">Save Changes</button>
                    </div>
                </form>
            </main>
@endsection

