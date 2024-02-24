<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
			<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
				<!-- Sidebar component, swap this element with another sidebar if you like -->
				<div class="flex grow flex-col gap-y-5 overflow-y-auto bg-menu-bg-color px-6 pb-4">
					<div class="flex items-center m-auto pt-3 pb-3">
						<img class="h-27 w-full" src="{{asset('assets/img/Logo_GNTV.svg')}}" alt="Your Company">
					</div>
					<nav class="flex flex-1 flex-col mt-3">
						<ul role="list" class="flex flex-1 flex-col gap-y-7 menu-list">
							<li>
								<ul role="list" class="-mx-2 space-y-1">
									<li>
										<a href="/"
											class="<?php echo request()->routeIs('dashboard') ? 'bg-[#297a99] text-white' : 'text-[#808080]'; ?> hover:text-white hover:bg-[#297a99] group flex gap-x-3 rounded-md p-2 text-sm leading-6">
											<svg
											class="w-5 h-5"
											aria-hidden="true"
											fill="none"
											stroke-linecap="round"
											stroke-linejoin="round"
											stroke-width="2"
											viewBox="0 0 24 24"
											stroke="currentColor"
											>
											<path
												d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
											></path>
											</svg>
											Dashboard
										</a>
									</li>

									<?php if(\Auth::user()->role == 'Super Admin' || \Auth::user()->role == 'Admin'){?>
									<li class="users">
										<a href="{{route('user')}}"
											class="<?php echo request()->routeIs('user') ? 'bg-[#297a99] text-white' : 'text-[#297a99]'; ?> hover:text-white hover:bg-[#297a99] group flex gap-x-3 items-center rounded-md p-2 text-sm leading-6">
											<i class="fa-solid fa-user text-lg"></i>
											Users
										</a>
									</li>
								<?php } ?>
								</ul>
							</li>

							<li class="mt-auto">
								<a href="{{route('twoFa')}}"
									class="group -mx-2 flex gap-x-3 item-center rounded-md p-2 text-sm leading-6 text-[#297a99] hover:bg-[#297a99] hover:text-white">
									<svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
										aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z">
										</path>
										<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
									</svg>
									Settings
								</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</aside>
		<!-- Mobile sidebar -->
		<!-- Backdrop -->
		<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
			x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
			x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
			x-transition:leave-end="opacity-0"
			class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
		<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-[4.5rem] overflow-y-auto bg-black dark:bg-gray-800 md:hidden"
			x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
			x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
			x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
			x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu"
			@keydown.escape="closeSideMenu">
			<div class="flex grow flex-col gap-y-5 overflow-y-auto bg-menu-bg-color px-6 pb-4" style="
			">
				<div class="flex items-center m-auto pt-8 pb-3">
					<img class="h-27 w-179" src="{{asset('assets/img/Logo_PDW.png')}}" alt="Your Company">
				</div>
				<nav class="flex flex-1 flex-col">
					<ul role="list" class="flex flex-1 flex-col gap-y-7">
						<li>
							<ul role="list" class="flex flex-1 flex-col gap-y-7">
								<li>
									<ul role="list" class="-mx-2 space-y-1">
										<li>
											<a href="#" class="bg-[#297a99] text-white group flex gap-x-3 rounded-md p-2 text-sm leading-6">
												<svg xmlns="http://www.w3.org/2000/svg" width="19" height="21" viewBox="0 0 19 21">
													<g id="Icon_feather-home" data-name="Icon feather-home" transform="translate(-4 -2.5)">
														<path id="Path_1" data-name="Path 1" d="M4.5,10l9-7,9,7V21a2,2,0,0,1-2,2H6.5a2,2,0,0,1-2-2Z"
															transform="translate(0 0)" fill="none" stroke="currentColor" stroke-linecap="round"
															stroke-linejoin="round" stroke-width="1" />
														<path id="Path_2" data-name="Path 2" d="M13.5,27.739V18h5.843v9.739" transform="translate(-2.922 -4.739)"
															fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" />
													</g>
												</svg>
												Dashboard
											</a>
										</li>
										<li>
											<a href="#"
												class="text-[#808080] hover:text-white hover:bg-[#297a99] group flex gap-x-3 rounded-md p-2 text-sm leading-6">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="20"
													viewBox="0 0 18 20">
													<defs>
														<clipPath id="clip-path">
															<rect id="Rectangle_29" data-name="Rectangle 29" width="18" height="20"
																transform="translate(-1612 1082)" fill="#fff" stroke="#707070" stroke-width="1" />
														</clipPath>
													</defs>
													<g id="RIMS__icon" data-name="RIMS _icon" transform="translate(1612 -1082)" clip-path="url(#clip-path)">
														<path id="Path_23" data-name="Path 23"
															d="M16,7a9,9,0,1,0,9,9A9.01,9.01,0,0,0,16,7Zm8.28,9a8.267,8.267,0,0,1-.229,1.929l-3.814-1.091a4.27,4.27,0,0,0,0-1.675l3.814-1.091A8.248,8.248,0,0,1,24.28,16ZM7.72,16a8.267,8.267,0,0,1,.229-1.929l3.814,1.091a4.27,4.27,0,0,0,0,1.675L7.949,17.929A8.248,8.248,0,0,1,7.72,16Zm5.44-3.247L10.308,10a8.278,8.278,0,0,1,3.337-1.932l.963,3.851A4.315,4.315,0,0,0,13.16,12.753Zm-.5.515a4.323,4.323,0,0,0-.692,1.2L8.148,13.379a8.284,8.284,0,0,1,1.659-2.867Zm-.692,4.261a4.318,4.318,0,0,0,.692,1.2l-2.85,2.756a8.278,8.278,0,0,1-1.659-2.867Zm1.195,1.718a4.31,4.31,0,0,0,1.448.838l-.963,3.851A8.282,8.282,0,0,1,10.307,22ZM12.4,16A3.6,3.6,0,1,1,16,19.6,3.6,3.6,0,0,1,12.4,16Zm6.943-2.732,2.85-2.756a8.278,8.278,0,0,1,1.659,2.867l-3.817,1.092A4.322,4.322,0,0,0,19.343,13.268Zm-.5-.515a4.31,4.31,0,0,0-1.448-.838l.963-3.851A8.282,8.282,0,0,1,21.693,10Zm0,6.494L21.692,22a8.278,8.278,0,0,1-3.337,1.932l-.963-3.851A4.315,4.315,0,0,0,18.84,19.247Zm.5-.515a4.323,4.323,0,0,0,.692-1.2l3.817,1.092a8.284,8.284,0,0,1-1.659,2.867ZM17.657,7.887l-.964,3.854a3.974,3.974,0,0,0-1.387,0l-.964-3.854a8.306,8.306,0,0,1,3.315,0ZM14.343,24.113l.964-3.854a3.974,3.974,0,0,0,1.387,0l.964,3.854a8.315,8.315,0,0,1-3.315,0Z"
															transform="translate(-1619 1076)" fill="currentColor" />
													</g>
												</svg>
												Rims
											</a>
										</li>
										<li>
											<a href="#"
												class="text-[#808080] hover:text-white hover:bg-[#297a99] group flex gap-x-3 rounded-md p-2 text-sm leading-6">
												<embed src="{{asset('assets/img/Cars.svg')}}" style="width: 18px;">
												Vehicles
											</a>
										</li>
										<li>
											<a href="#"
												class="text-[#808080] hover:text-white hover:bg-[#297a99] group flex gap-x-3 rounded-md p-2 text-sm leading-6">
												<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
													<path id="Download_icon" d="M6.75,0V6.75H2.25L9,13.5l6.75-6.75h-4.5V0ZM0,15.75V18H18V15.75Z"
														fill="currentColor" />
												</svg>
												Downloads
											</a>
										</li>
										<li>
											<a href="#"
												class="text-[#808080] hover:text-white hover:bg-[#297a99] group flex gap-x-3 rounded-md p-2 text-sm leading-6">
												<svg xmlns="http://www.w3.org/2000/svg" width="18.253" height="18.253" viewBox="0 0 18.253 18.253">
													<g id="Cron_icon" transform="translate(-3.375 -3.375)">
														<path id="Path_24" data-name="Path 24"
															d="M12.493,3.375A9.127,9.127,0,1,0,21.628,12.5,9.123,9.123,0,0,0,12.493,3.375ZM12.5,19.8a7.3,7.3,0,1,1,7.3-7.3A7.3,7.3,0,0,1,12.5,19.8Z"
															fill="currentColor" />
														<path id="Path_25" data-name="Path 25" d="M17.906,10.688H16.538v5.476l4.791,2.874.684-1.123-4.107-2.435Z"
															transform="translate(-4.949 -2.749)" fill="currentColor" />
													</g>
												</svg>
												Cron Jobs
											</a>
										</li>
										<?php if(\Auth::user()->role == 'Super Admin'){?>
										<li>
											<a href="{{route('user')}}"
												class="text-[#808080] hover:text-white hover:bg-[#297a99] group flex gap-x-3 rounded-md p-2 text-sm leading-6">
												<embed src="{{asset('assets/img/Users.svg')}}" style="width: 18px;">
												Users
											</a>
										</li>
										<?php } ?>
									</ul>
								</li>

								<li class="mt-auto">
									<a href="{{route('twoFa')}}"
										class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm leading-6 text-[#808080] hover:bg-[#297a99] hover:text-white">
										<svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
											aria-hidden="true">
											<path stroke-linecap="round" stroke-linejoin="round"
												d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z">
											</path>
											<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
										</svg>
										Settings
									</a>
								</li>
							</ul>
				</nav>
			</div>
		</aside>
