<!DOCTYPE html>

<html x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
    <title>GlobalNation TV - Create, Connect, Collect</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <link rel="stylesheet" href="{{asset('assets/css/tailwind.output.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/custom_style.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.4.0/build/css/intlTelInput.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://tailwindcss.com/docs/installation"></script>
    <script src="{{asset('assets/js/init-alpine.js')}}"></script>
    <script src="{{asset('assets/js/alpine.min.js')}}"></script>
    <script src="{{asset('assets/js/focus-trap.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.4.0/build/js/intlTelInput.min.js"></script>
    <script type="text/javascript">
        // window.addEventListener("pageshow", function (event) {
        //   var historyTraversal = event.persisted,
        //     perf = window.performance;
        //     perfEntries = perf && perf.getEntriesByType && perf.getEntriesByType("navigation");
        //     perfEntryType = perfEntries && perfEntries[0] && perfEntries[0].type
        //     // perfEntries =
        //     //   perf && perf.getEntriesByType && perf.getEntriesByType("navigation"),
        //     // perfEntryType = perfEntries && perfEntries[0] && perfEntries[0].type,
        //     // navigationType = perf && perf.navigation && perf.navigation.type;
        //   if (
        //     perfEntryType === "back_forward"
        //   ) {
        //     // Handle page restore.
        //     window.location.reload();
        //   }
        // });
    </script>



    <script>
        tailwind.config = {
            theme: {
                extend: {
                    width: {
                        '295': '18.438rem',
                    },
                    colors: {
                        '#808080': '#808080',
                        '#1D1D1D': '#1D1D1D',
                        '#888888': '#888888',
                        '#D1D5DB': '#D1D5DB',
                        '#F8F6F6': '#F8F6F6',
                        '#4F46E5': '#4F46E5',
                        '#9CA3AF': '#9CA3AF',
                        '#726AFC': '#726AFC',
                        '#EEEEEE': '#EEEEEE',
                        '#F3F3F3': '#F3F3F3',
                        '#9BA0A8': '#9BA0A8',
                        '#00B406': '#00B406',
                        '#125EF6': '#125EF6',
                        '#FF3939': '#FF3939',
                        '#E7E7E9': '#E7E7E9',
                        '#4338CA': '#4338CA',
                        '#E0E7FF': '#E0E7FF',
                        '#F9FAFB': '#F9FAFB',
                        '#959595': '#959595',
                        '#297a99': '#297a99',
                        '#61d5d8': '#61d5d8',
                        '#f0f0f0': '#f0f0f0',
                        '#e1e6e6': '#e1e6e6',
                    },
                    fontSize: {
                        '13px': '13px',
                    },
                    fontFamily: {
                        poppins: ['Poppins'],
                    },
                    margin: {
                        '4.5rem': '4.5rem',
                        '30px': '1.875rem',
                        '10px': '10px',
                        '5px': '5px',
                        '50px': '50px',
                    },
                    borderRadius: {
                        '5px': '5px',
                    },
                    borderWidth:{
                        '20px': '20px',
                    },
                    padding: {
                        '5px': '5px',
                        '10px': '10px',
                        '30px': '1.875rem',
                        '8.5px': '8.5px',
                        '25px': '25px',
                    },
                    width: {
                        '100px': '6.25rem',
                        '228px': '228px',
                    },
                    height: {
                        '100px': '6.25rem',
                    },
                    minWidth: {
                        '300px': '300px',
                        '200px': '200px',
                    },
                    gridAutoColumns: {
                        '2fr': 'minmax(0, 300px)',
                    },
                    screens: {
                        '3xl': '1600px',
                        'sm': '640px',
                        'md': '768px',
                        'lg': '1024px',
                    },
                    lineHeight: {
                        '1.2em': '1.2em',
                    }
                }
            }
        }
    </script>

</head>

<body class="font-poppins">
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        @include('includes.nav')
        <div class="flex flex-col flex-1 w-full bg-[#F3F3F3]">
            @include('includes.header')

            @yield('content')

            <input type="hidden" id="refresh" value="no">
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script>

        $(document).ready(function () {
            // Initialize select2
            $(".filter_top").select2();

            $('#filterMake').select2({
                placeholder: 'Make',
                // Other options here
            });
            $('#filterModel').select2({
                placeholder: 'Model',
                // Other options here
            });
            $('#filterYear').select2({
                placeholder: 'Year',
                // Other options here
            });

            $('#filter_now').click(function () {
                $('#filter_style_ktype').toggle("slide");
            })

            /* Tab View */
            $(".rim_services").click(function () {
                $(".rim_services").removeClass("active text-[#4338CA] bg-[#E0E7FF]").addClass("text-black hover:text-[#4338CA] bg-transparent"); //removing active and font-text-800 from all tab btns, add hover:text-blue-800 in all tabs
                $(this).removeClass("text-black hover:text-[#4338CA] bg-transparent").addClass("active text-[#4338CA] bg-[#E0E7FF]"); // adding active class and text color to clicked tab
                let tab_to_show = $(this).data("tab_id"); // getting tab id to un-hide from clicked tab using data attribute;
                $(".rim_tab_view").addClass("hidden"); //hiding all tabs using tailwind css;
                $(`#${tab_to_show}`).removeClass("hidden"); // removing class hidden from wanted tab only, note that i am using Grave Accent symbol instead for inverted comma ;
            });
        });

        $(document).on('keyup','#search-field',function(){
            var search_val = $(this).val();
            search_all(search_val)
        });

        const searchField = document.getElementById('search-field');
        searchField.addEventListener('input', function () {
            if (this.value === '') {
                $('#all_search').html('');
            }
        });

        function search_all(search_val){

            if(search_val == ''){
                $('#all_search').html('No Search');
                return false;
            }

            $.ajax({
                url: "",
                method: "get",
                data : {search_val : search_val,"_token": "{{ csrf_token() }}"},
                success: function(data) {
                    if(data != ''){
                        $('#all_search').html(data);
                    }else{
                        $('#all_search').html('No record found');
                    }

                }
            });
        }

        var openButton = document.getElementById('open_all_search');
        var dialog = document.getElementById('dialog_all_search');
        var closeButton = document.getElementById('close');
        var overlay = document.getElementById('overlay');

        // show the overlay and the dialog
        openButton.addEventListener('click', function () {
            dialog.classList.remove('hidden');
            overlay.classList.remove('hidden');
            $('#search-field').val('');
            $('#all_search').html('No Search');
            $('#search-field').focus();
        });

        // hide the overlay and the dialog
        closeButton.addEventListener('click', function () {
            dialog.classList.add('hidden');
            overlay.classList.add('hidden');
        });

        $(document).on('change','.is_locked_btn',function(){
            if ($(this).is(':checked')) {
                $(this).attr('value', 1);

                var parentTr = $(this).closest('tr');
                var isLockedCheckbox = parentTr.find('input[name="with_selected_id_name"]');
                isLockedCheckbox.prop('checked', false);

            }
            else {
               $(this).attr('value', 0);
            }

            var is_locked = $(this).val();
            var type_id = $(this).data('id');
            var type = $(this).data('type');
            var modification_id = $(this).data('modification_id');
            // console.log(type + " : " + type_id + " : " + is_locked);
            var request_perm = encodeURIComponent(JSON.stringify($(this).data('query')));
            $.ajax({
                url:"",    //the page containing php script
                type: "post",
                data: {modification_id : modification_id ,request_perm : request_perm ,is_locked: is_locked , type_id: type_id, type: type,"_token": "{{ csrf_token() }}", },
                success:function(result){
                    console.log(result);
                    $('#locked_msg').html('<span style="color:green;">'+result.msg+'</span>');
                }
            });


        });



        $(document).on('click','input[name="with_selected_id_name"]', function(){

            var parentTr = $(this).closest('tr');
            var isLockedCheckbox = parentTr.find('.is_locked_btn');
            if (isLockedCheckbox.is(':checked')) {
                alert('This vehcile is locked to bulk update');
                return false;
            }

        });


        $(document).on('click','.check_ceh',function(){
            // var select = $(this).data('select');
            var href = $(this).data('href');


            var parentTr = $(this).closest('tr');
            var isLockedCheckbox = parentTr.find('.is_locked_btn');
            if (isLockedCheckbox.is(':checked')) {
                alert('This vehcile is locked to bulk update');
                return false;
            }else{
                window.location.href = href;
            }

        // if(select == 0){
        //     alert('vehicle is locked to update');
        //     return false;
        // }else{
        //     window.location.href = href;
        // }
        });


        $(document).on('click','.rim_fil_btn',function(){
            var filter_style  = $('.filter_style').val();
            if(filter_style == ''){
                alert('Please select at least one.');
                return false;
            }

        });



        $(document).mouseup(function(e) {
              var modal = $("#dialog_all_search");

              // If the target of the click isn't the modal nor a descendant of the modal
              if (!modal.is(e.target) && modal.has(e.target).length === 0) {
                    modal.addClass('hidden');
                    $('#overlay').addClass('hidden');
                }
        });


        $(document).on('click', function (event) {
            var filterElement = $('#filter_style_ktype');
            if (!filterElement.is(event.target) && filterElement.has(event.target).length === 0) {
                // Clicked outside the filterElement, hide it
                $(this).css('display','none');
            }

        });


    </script>

    @yield('script')
</body>

</html>
