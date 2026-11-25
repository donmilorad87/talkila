(function($) {
    "use strict";
    jQuery(document).on('ready', function() {
		// Navbar active
        var url = window.location;
        var menuItem = $('.sidemenu .navbar-nav a, .top-menu .navbar-nav a').filter(function() {
            return this.href == url;
        })
        menuItem.addClass('active');

        // Side Menu Hide Show JS
        $(".burger-menu").on('click', function(){
            $(".burger-menu").toggleClass("toggle-menu");
            // $(".navbar-brand").toggleClass("navbar-logo");
            $(".sidemenu-area").toggleClass("sidemenu-toggle");
            $(".sidemenu").toggleClass("hide-nav-title");
            $(".main-content").toggleClass("hide-sidemenu");
        });

        // Burger menu click show toggle x class
        $(".burger-menu").on('click', function(){
            $(".burger-menu").toggleClass("x");
        });

        // Tooltip JS
      /*   $('[data-toggle="tooltip"]').tooltip() */

        // Feather Icon Js
       /*  feather.replace() */

        // FAQ Accordion Js
        /* $('.accordion').find('.accordion-title').on('click', function(){
            // Adds Active Class
            $(this).toggleClass('active');
            // Expand or Collapse This Panel
            $(this).next().slideToggle('fast');
            // Hide The Other Panels
            $('.accordion-content').not($(this).next()).slideUp('fast');
            // Removes Active Class From Other Titles
            $('.accordion-title').not($(this)).removeClass('active');
        }); */

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        /* (function() {
        'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })(); */

        // Back To Top Button JS
        $('body').append('<div id="toTop"><i class="lni lni-chevron-up">&#8593;</i></div>');
        $(window).scroll(function () {
            if ($(this).scrollTop() != 0) {
             $('#toTop').fadeIn();
            } else {
                $('#toTop').fadeOut();
            }
        });
        $('#toTop').on('click', function(){
            $("html, body").animate({ scrollTop: 0 }, 650);
            return false;
        });

        // Gallery Viewer JS
        /* var console = window.console || { log: function () {} };
        var $images = $('.gallery-content');
        var $toggles = $('.gallery-toggles');
        var $buttons = $('.gallery-buttons');
        var options = {
            // inline: true,
            url: 'data-original',
            ready: function (e) {
                console.log(e.type);
            },
            show: function (e) {
                console.log(e.type);
            },
            shown: function (e) {
                console.log(e.type);
            },
            hide: function (e) {
                console.log(e.type);
            },
            hidden: function (e) {
                console.log(e.type);
            },
            view: function (e) {
                console.log(e.type);
            },
            viewed: function (e) {
                console.log(e.type);
            }
        };
        function toggleButtons(mode) {
            if (/modal|inline|none/.test(mode)) {
            $buttons
                .find('button[data-enable]')
                .prop('disabled', true)
                .filter('[data-enable*="' + mode + '"]')
                .prop('disabled', false);
            }
        }
        $images.on({
            ready:  function (e) {
                console.log(e.type);
            },
            show:  function (e) {
                console.log(e.type);
            },
            shown:  function (e) {
                console.log(e.type);
            },
            hide:  function (e) {
                console.log(e.type);
            },
            hidden: function (e) {
                console.log(e.type);
            },
            view:  function (e) {
                console.log(e.type);
            },
            viewed: function (e) {
                console.log(e.type);
            }
        }).viewer(options);
        toggleButtons(options.inline ? 'inline' : 'modal');
        $toggles.on('change', 'input', function () {
            var $input = $(this);
            var name = $input.attr('name');
            options[name] = name === 'inline' ? $input.data('value') : $input.prop('checked');
            $images.viewer('destroy').viewer(options);
            toggleButtons(options.inline ? 'inline' : 'modal');
        });
        $buttons.on('click', 'button', function () {
            var data = $(this).data();
            var args = data.arguments || [];
            if (data.method) {
                if (data.target) {
                    $images.viewer(data.method, $(data.target).val());
                } else {
                    $images.viewer(data.method, args[0], args[1]);
                }
                switch (data.method) {
                    case 'scaleX':
                    case 'scaleY':
                    args[0] = -args[0];
                    break;
                    case 'destroy':
                    toggleButtons('none');
                    break;
                }
            }
        }); */

        // Left Sidemenu BG Color Switcher


        if(document.getElementById('BGPrimary')){
            document.getElementById('BGPrimary').onclick = switchPrimary;
        }

        if(document.getElementById('BGSuccess')){
            document.getElementById('BGSuccess').onclick = switchSuccess;
        }

        if(document.getElementById('BGSecondary')){
            document.getElementById('BGSecondary').onclick = switchSecondary;
        }

        if(document.getElementById('BGPurple')){
            document.getElementById('BGPurple').onclick = switchPurple;
        }

        if(document.getElementById('BGDanger')){
            document.getElementById('BGDanger').onclick = switchDanger;
        }

        if(document.getElementById('BGWarning')){
            document.getElementById('BGWarning').onclick = switchWarning;
        }

        if(document.getElementById('BGWarning')){
            document.getElementById('BGWarning').onclick = switchWarning;
        }

        if(document.getElementById('BGPurpleIndigo')){
            document.getElementById('BGPurpleIndigo').onclick = switchPurpleIndigo;
        }

        if(document.getElementById('BGPink')){
            document.getElementById('BGPink').onclick = switchPink;
        }

        if(document.getElementById('BGIndigo')){
            document.getElementById('BGIndigo').onclick = switchIndigo;
        }

        if(document.getElementById('BGnNightBlue')){
            document.getElementById('BGnNightBlue').onclick = switchNightBlue;
        }

        if(document.getElementById('BGGray')){
            document.getElementById('BGGray').onclick = switchGray;
        }

        if(document.getElementById('BGGrayBlue')){
            document.getElementById('BGGrayBlue').onclick = switchGrayBlue;
        }

        if(document.getElementById('BGGreen')){
            document.getElementById('BGGreen').onclick = switchGreen;
        }

        if(document.getElementById('BGDeepPurple')){
            document.getElementById('BGDeepPurple').onclick = switchDeepPurple;
        }

        function switchPrimary() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-primary';
        }
        function switchSuccess() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-success';
        }
        function switchSecondary() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-secondary';
        }
        function switchPurple() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-purple';
        }
        function switchDanger() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-danger';
        }
        function switchWarning() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-warning';
        }
        function switchPurpleIndigo() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-purple-indigo';
        }
        function switchPink() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-pink';
        }
        function switchIndigo() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-indigo';
        }
        function switchNightBlue() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-nightblue';
        }
        function switchGray() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-gray';
        }
        function switchGrayBlue() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-gray-blue';
        }
        function switchGreen() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-green';
        }
        function switchDeepPurple() {
            document.getElementsByTagName('body')[0].className = 'sidemenu-bg-deep-purple';
        }

        // Folded Menu
        $(".folded-menu").on('click', function(){
            $(".main-content").toggleClass("hide-sidemenu");
            $(".sidemenu-area").toggleClass("sidemenu-toggle");
            $(".sidemenu").toggleClass("hide-nav-title");
        });

        // Folded Menu
        $(".card-shadow").on('click', function(){
            $(".card").toggleClass("hide-card-shadow");
            $(".stats-card").toggleClass("hide-card-shadow");
            $(".stats-card-one, .stats-card-two, .stats-card-three").toggleClass("hide-card-shadow");
        });

    });

	// Preloader JS
    jQuery(window).on('load', function() {
        $('.preloader').fadeOut()
    })
}(jQuery))





