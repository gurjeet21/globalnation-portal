@extends('layouts.app')

@section('content')
<main class="flex flex-1 flex-col grow p-[1.875rem] overflow-y-auto">
        <h2 class="text-black font-semibold text-xl">Cron Jobs</h2>
        @if(Session::has('success'))
            <div class="p-4 mb-2 mt-2 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                  <span class="font-semibold">Success: </span> {{session('success')}}
            </div>
        @endif


        @if(Session::has('error'))
            <div class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative " role="alert">
              <strong class="font-bold">Error : </strong>
              <span class="block sm:inline">{{session('error')}}</span>
            </div>
        @endif


        <div class="container grid grow p-[1.875rem] mx-auto bg-white rounded-[5px] mt-[1.875rem]">
            <div class="w-full overflow-hidden flex flex-1 flex-col">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap divide-y divide-gray-300">
                        <thead>
                            <tr class="text-xs font-semibold text-left text-gray-500">
                                <th scope="col" class="pl-4 pb-[1.875rem] pr-3 text-left text-base font-semibold text-black sm:pl-3">Cron Name</th>
                                <th scope="col" class="px-3 pb-[1.875rem] text-left text-base font-semibold text-black">Cron Command</th>
                                <th scope="col" class="px-3 pb-[1.875rem] text-left text-base font-semibold text-black">Command Intervel</th>
                                <th scope="col" class="px-3 pb-[1.875rem] text-left text-base font-semibold text-black text-center">Last Executed</th>
                                <th scope="col" class="px-3 pb-[1.875rem] text-left text-base font-semibold text-black text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divider_padding">
                            @forelse($cron_list as $cron)
                            <tr class="even:bg-gray-50">
                                <td class="whitespace-nowrap py-2.5 pl-4 pr-3 text-sm font-medium text-black sm:pl-3">
                                    {{$cron->cron_name}}
                                </td>
                                <td class="whitespace-nowrap px-3 py-2.5 text-sm text-[#4F46E5]">
                                    <a >{{$cron->cron_command}}</a>
                                </td>
                                <td class="whitespace-nowrap px-3 py-2.5 text-sm text-[#4F46E5]">
                                    <a >{{$cron->command_intervel}}</a>
                                </td>
                                
                                <td class="whitespace-nowrap px-3 py-2.5 text-sm text-black text-center">
                                    <?php if($cron->excecute_date != ''){ ?>
                                        <span class="date">{{ \Carbon\Carbon::parse($cron->excecute_date)->format('Y-m-d') }}</span>
                                        <span class="time text-xs block">{{ \Carbon\Carbon::parse($cron->excecute_date)->format('H:i:s') }}</span>
                                    <?php }else{
                                        echo "-";
                                    } ?>
                                    
                                </td>
                                <td class="whitespace-nowrap px-3 py-2.5 text-sm text-center text-[#00B406]">
                                    <a href="{{ route('cronjob.execute_cron',['cron_id'=>$cron->id]) }}" class="hover:bg-[#4F46E5] text-white py-[5px] px-[10px] rounded-[5px] bg-[#4F46E5] execute_cron">
                                        Execute Cron
                                    </a>
                                </td>
                            </tr>

                            @empty
                                <tr>
                                    <td colspan="4">
                                        No record found
                                    </td>
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

@endsection
