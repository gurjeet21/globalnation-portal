

<header class="z-10 py-5 bg-white shadow-md dark:bg-gray-800">
				<div class="flex items-center justify-between h-full px-6 mx-auto text-black-600 dark:text-black-300">
					<!-- Mobile hamburger -->
					<button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-black"
						@click="toggleSideMenu" aria-label="Menu">
						<svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd"
								d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
								clip-rule="evenodd"></path>
						</svg>
					</button>

					<form class="flex justify-center flex-1 lg:mr-32">
						<div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500" >
							<div class="absolute inset-y-0 flex items-center pl-2">
							<svg
								class="w-4 h-4"
								aria-hidden="true"
								fill="#297a99"
								viewBox="0 0 20 20"
							>
								<path
								fill-rule="evenodd"
								d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
								clip-rule="evenodd"
								></path>
							</svg>
							</div>
							<input
							class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-theme-primary focus:outline-none form-input"
							type="text"
							readonly
							id="open_all_search"
							placeholder="Search users"
							aria-label="Search"
							/>
						</div>
					</form>
					

					<div class="flex items-center gap-x-4 lg:gap-x-6">
						{{--<div class="relative">
							<button class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500 focus:outline-none"
								@click="toggleNotificationsMenu" @keydown.escape="closeNotificationsMenu" aria-label="Notifications"
								aria-haspopup="true">
								<span class="sr-only">View notifications</span>
								<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0">
									</path>
								</svg>
								<!-- Notification badge -->
								<span aria-hidden="true"
									class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800"></span>
							</button>
							<template x-if="isNotificationsMenuOpen">
								<ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
									x-transition:leave-end="opacity-0" @click.away="closeNotificationsMenu" @keydown.escape="closeNotificationsMenu"
									class="absolute right-0 w-36 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700">
									<li class="flex">
										<a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
											href="#">
											<span>Messages</span>
											<span
												class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
												13
											</span>
										</a>
									</li>
								</ul>
							</template>
						</div>

						--}}

						<!-- Separator -->
						<div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10" aria-hidden="true"></div>

						<!-- Profile dropdown -->
						<div class="relative">
							<button class="-m-1.5 flex items-center p-1.5 focus:outline-none" @click="toggleProfileMenu"
								@keydown.escape="closeProfileMenu" aria-label="Account" aria-haspopup="true">

									<span class="sr-only">Open user menu</span>

									<?php  if(\Auth::user()->img != ''){  ?>
										<img class="h-8 w-8 rounded-full bg-gray-50"
										src="{{asset('user_image')}}/{{\Auth::user()->img}}"
										alt="">
									<?php }else{ ?>
										<div class="relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
										    <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
										</div>
									<?php } ?>
									
										<span class="hidden lg:flex lg:items-center">
											<span class="ml-4 text-sm font-normal leading-6 text-black dark:text-[#61d5d8]" aria-hidden="true">{{\Auth::user()->name}}</span>
											<svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
												<path fill-rule="evenodd"
													d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
													clip-rule="evenodd"></path>
											</svg>
										</span>
							</button>

							<template x-if="isProfileMenuOpen">
								<ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
									x-transition:leave-end="opacity-0" @click.away="closeProfileMenu" @keydown.escape="closeProfileMenu"
									class="absolute right-0 w-36 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
									aria-label="submenu">
									<li class="flex">
										<a class="inline-flex items-center w-full px-2 py-1 text-sm transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
											href="{{ route('user.profile')}}">
											<span>My Profile</span>
										</a>
									</li>

									
									<li class="flex">
										<a class="inline-flex items-center w-full px-2 py-1 text-sm transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
											href="">
											<form method="POST" action="{{ route('logout') }}">
					                            @csrf
					                            <span onclick="event.preventDefault(); this.closest('form').submit();">Sign Out</span>
					                        </form>
											
										</a>
									</li>
								</ul>
							</template>
						</div>
					</div>
				</div>

				<!-- Overlay element -->
		<div id="overlay" class="fixed hidden z-40 w-screen h-screen inset-0 bg-gray-900 bg-opacity-60"></div>

		<!-- The dialog -->
		<div id="dialog_all_search" style="min-width : 60%;top: 40%;min-height: 56vh;" class="hidden fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2  bg-white rounded-md px-2 py-2 drop-shadow-lg ">
				<div class="relative w-full">
					<div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
		                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">
		                    Search
		                </h4>
			                <header class="flex justify-end">
						          <button class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700" id="close">
						            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
						              <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path>
						            </svg>
						          </button>
						        </header>
	            	</div>
	            	<div class="p-6 space-y-6">
						<div class="mb-3">
						  <input
						    type="search" id="search-field"
						    class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
						    placeholder="Type query" />
						</div>

						<div id="all_search" class="mt-2" style="height: 35vh;overflow: auto;">
							No search 
						</div>
					</div>
			</div>


	</header>

			



							