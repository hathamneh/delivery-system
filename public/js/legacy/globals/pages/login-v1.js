function copyrightPos() {
    var windowHeight = $(window).height();
    if (windowHeight < 700) {
        $('.account-copyright').css('position', 'relative').css('margin-top', 40);
    } else {
        $('.account-copyright').css('position', '').css('margin-top', '');
    }
}

$(window).resize(function () {
    copyrightPos();
});

function shipmentStatusSubmit(token) {
    //document.getElementById("form-shipment-status").submit();
    var $form = $("#form-shipment-status");
    var l = Ladda.create($form.find('.ladda-button')[0]);
    l.start();
    var _identifier = $form.find("[name='identifier']").val();
    console.log(_identifier);
    $.ajax({
        url: "/ajax_requests.php",
        type: 'POST',
        data: {
            action: "get_shipment_status",
            identifier: _identifier,
            "g-recaptcha-response": token
        },
        success: function (data) {
            var $result = $form.find('.status-result');
            $result.html(data);
            $result.fadeIn();
            grecaptcha.reset();
        },
        complete: function () {
            l.stop();
        }
    });
}

$(document).ready(function () {

});

$(function () {

    //copyrightPos();
    if ($('body').data('page') == 'login') {

        /* Show / Hide Password Recover Form */
        $('#password').on('click', function (e) {
            e.preventDefault();
            $('.form-signin').slideUp(300, function () {
                $('.form-password').slideDown(300);
            });
        });
        $('#login').on('click', function (e) {
            e.preventDefault();
            $('.form-password').slideUp(300, function () {
                $('.form-signin').slideDown(300);
            });
        });

        var form = $(".form-signin");
        $('#submit-form').click(function (e) {
            form.validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 3,
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 16
                    }
                },
                messages: {
                    username: {
                        required: 'Enter your username'
                    },
                    password: {
                        required: 'Write your password'
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                }
            });
            e.preventDefault();
            if (form.valid()) {
                $(this).addClass('ladda-button');
                var l = Ladda.create(this);
                l.start();
                setTimeout(function () {
                    form.submit();
                }, 1000);
            } else {
                $('body').addClass('boxed');
            }
        });

        $('#submit-form, #submit-password').click(function () {

            e.preventDefault();
            var l = Ladda.create(this);
            l.start();
            setTimeout(function () {
                window.location.href = "dashboard.html";
            }, 2000);
        });

        $.backstretch(["/images/gallery/login4.jpg", "/images/gallery/login3.jpg", "/images/gallery/login2.jpg", "/images/gallery/login.jpg"], {
            fade: 600,
            duration: 24000
        });

        /***** DEMO CONTENT, CAN BE REMOVED ******/
        $("#account-builder").on('mouseenter', function () {
            TweenMax.to($(this), 0.35, {
                css: {
                    height: 160,
                    width: 500,
                    left: '37%',
                    'border-bottom-left-radius': 0,
                    'border-top-right-radius': 0,
                    '-moz-border-bottom-left-radius': 0,
                    '-moz-border-top-right-radius': 0,
                    '-webkit-border-bottom-left-radius': 0,
                    '-webkit-border-top-right-radius': 0
                },
                ease: Circ.easeInOut
            });
        });
        $("#account-builder").on('mouseleave', function () {
            TweenMax.to($(this), 0.35, {
                css: {
                    height: 44,
                    width: 250,
                    left: '44%',
                    'border-bottom-left-radius': 20,
                    'border-top-right-radius': 20
                },
                ease: Circ.easeInOut
            });
        });
        /* Hide / Show Social Connect */
        $('#social-cb').change(function () {
            if ($(this).is(":checked")) {
                $('.social-btn').slideDown(function () {
                    $('body').removeClass('no-social');
                });
            } else {
                $('.social-btn').slideUp(function () {
                    $('body').addClass('no-social');
                });
            }
        });
        /* Hide / Show Boxed Form */
        $('#boxed-cb').change(function () {
            if ($(this).is(":checked")) {
                TweenMax.to($('.account-wall'), 0.5, {
                    backgroundColor: 'rgba(255, 255, 255,1)',
                    ease: Circ.easeInOut,
                    onComplete: function () {
                        $('body').addClass('boxed');
                    }
                });
            } else {
                TweenMax.to($('.account-wall'), 0.5, {
                    backgroundColor: 'rgba(255, 255, 255,0)',
                    ease: Circ.easeInOut,
                    onComplete: function () {
                        $('body').removeClass('boxed');
                    }
                });
            }
        });
        /* Hide / Show Background Image */
        $('#image-cb').change(function () {
            if ($(this).is(":checked")) {
                $.backstretch(["../assets/global/images/gallery/login.jpg"], {
                    fade: 600,
                    duration: 4000
                });
                $('#slide-cb').attr('checked', false);
            } else $.backstretch("destroy");
        });
        /* Add / Remove Slide Image */
        $('#slide-cb').change(function () {
            if ($(this).is(":checked")) {
                $.backstretch(["../assets/global/images/gallery/login4.jpg", "../assets/global/images/gallery/login3.jpg", "../assets/global/images/gallery/login2.jpg", "../assets/global/images/gallery/login.jpg"], {
                    fade: 600,
                    duration: 4000
                });
                $('#image-cb').attr('checked', false);
            } else {
                $.backstretch("destroy");
            }
        });
        /* Separate Inputs */
        $('#input-cb').change(function () {
            if ($(this).is(":checked")) {
                TweenMax.to($('.username'), 0.3, {
                    css: {
                        marginBottom: 8,
                        'border-bottom-left-radius': 2,
                        'border-bottom-right-radius': 2
                    },
                    ease: Circ.easeInOut,
                    onComplete: function () {
                        $('body').addClass('separate-inputs');
                    }
                });
                TweenMax.to($('.password'), 0.3, {
                    css: {
                        'border-top-left-radius': 2,
                        'border-top-right-radius': 2
                    },
                    ease: Circ.easeInOut
                });
            } else {
                TweenMax.to($('.username'), 0.3, {
                    css: {
                        marginBottom: -1,
                        'border-bottom-left-radius': 0,
                        'border-bottom-right-radius': 0
                    },
                    ease: Circ.easeInOut,
                    onComplete: function () {
                        $('body').removeClass('separate-inputs');
                    }
                });
                TweenMax.to($('.password'), 0.3, {
                    css: {
                        'border-top-left-radius': 0,
                        'border-top-right-radius': 0
                    },
                    ease: Circ.easeInOut
                });
            }
        });
        /* Hide / Show User Image */
        $('#user-cb').change(function () {
            if ($(this).is(":checked")) {
                TweenMax.to($('.user-img'), 0.3, {
                    opacity: 0,
                    ease: Circ.easeInOut
                });
            } else {
                TweenMax.to($('.user-img'), 0.3, {
                    opacity: 1,
                    ease: Circ.easeInOut
                });
            }
        });

    }
    if ($('body').data('page') == 'signup') {

        var form = $(".form-signup");
        $.backstretch(["../assets/global/images/gallery/login.jpg"], {
            fade: 600,
            duration: 4000
        });
        $("#account-builder").on('mouseenter', function () {
            TweenMax.to($(this), 0.35, {
                css: {
                    height: 160,
                    width: 500,
                    left: '37%',
                    'border-bottom-left-radius': 0,
                    'border-top-right-radius': 0,
                    '-moz-border-bottom-left-radius': 0,
                    '-moz-border-top-right-radius': 0,
                    '-webkit-border-bottom-left-radius': 0,
                    '-webkit-border-top-right-radius': 0
                },
                ease: Circ.easeInOut
            });
        });
        $("#account-builder").on('mouseleave', function () {
            TweenMax.to($(this), 0.35, {
                css: {
                    height: 44,
                    width: 250,
                    left: '44%',
                    'border-bottom-left-radius': 20,
                    'border-top-right-radius': 20
                },
                ease: Circ.easeInOut
            });
        });
        /* Hide / Show Social Connect */
        $('#social-cb').change(function () {
            if ($(this).is(":checked")) {
                $('.social-btn').slideDown(function () {
                    $('body').removeClass('no-social');
                });
            } else {
                $('.social-btn').slideUp(function () {
                    $('body').addClass('no-social');
                });
            }
        });
        /* Hide / Show Boxed Form */
        $('#boxed-cb').change(function () {
            if ($(this).is(":checked")) {
                TweenMax.to($('.account-wall'), 0.5, {
                    backgroundColor: 'rgba(255, 255, 255,1)',
                    ease: Circ.easeInOut,
                    onComplete: function () {
                        $('body').addClass('boxed');
                    }
                });
            } else {
                TweenMax.to($('.account-wall'), 0.5, {
                    backgroundColor: 'rgba(255, 255, 255,0)',
                    ease: Circ.easeInOut,
                    onComplete: function () {
                        $('body').removeClass('boxed');
                    }
                });
            }
        });
        /* Hide / Show Background Image */
        $('#image-cb').change(function () {
            if ($(this).is(":checked")) {
                $.backstretch(["../assets/global/images/gallery/login.jpg"], {
                    fade: 600,
                    duration: 4000
                });
                $('#slide-cb').attr('checked', false);
            } else $.backstretch("destroy");
        });
        /* Add / Remove Slide Image */
        $('#slide-cb').change(function () {
            if ($(this).is(":checked")) {
                $.backstretch(["../assets/global/images/gallery/login4.jpg", "../assets/global/images/gallery/login3.jpg", "../assets/global/images/gallery/login2.jpg", "../assets/global/images/gallery/login.jpg"], {
                    fade: 600,
                    duration: 4000
                });
                $('#image-cb').attr('checked', false);
            } else {
                $.backstretch("destroy");
            }
        });
        /* Hide / Show Terms Checkbox */
        $('#terms-cb').change(function () {
            if ($(this).is(":checked")) {
                $('.terms').slideDown(function () {
                    $('body').removeClass('no-terms');
                });
            } else {
                $('.terms').slideUp(function () {
                    $('body').addClass('no-terms');
                });
            }
        });
        /* Hide / Show User Image */
        $('#user-cb').change(function () {
            if ($(this).is(":checked")) {
                TweenMax.to($('.user-img'), 0.3, {
                    opacity: 0,
                    ease: Circ.easeInOut
                });
            } else {
                TweenMax.to($('.user-img'), 0.3, {
                    opacity: 1,
                    ease: Circ.easeInOut
                });
            }
        });
        $('#submit-form').click(function (e) {
            form.validate({
                rules: {
                    firstname: {
                        required: true,
                        minlength: 3,
                    },
                    lastname: {
                        required: true,
                        minlength: 4,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 16
                    },
                    password2: {
                        required: true,
                        minlength: 6,
                        maxlength: 16,
                        equalTo: '#password'
                    },
                    terms: {
                        required: true
                    }
                },
                messages: {
                    firstname: {
                        required: 'Enter your first name',
                        minlength: 'Enter at least 3 characters or more'
                    },
                    lastname: {
                        required: 'Enter your last name',
                        minlength: 'Enter at least 3 characters or more'
                    },
                    email: {
                        required: 'Enter email address',
                        email: 'Enter a valid email address'
                    },
                    password: {
                        required: 'Write your password',
                        minlength: 'Minimum 6 characters',
                        maxlength: 'Maximum 16 characters'
                    },
                    password2: {
                        required: 'Write your password',
                        minlength: 'Minimum 6 characters',
                        maxlength: 'Maximum 16 characters',
                        equalTo: '2 passwords must be the same'
                    },
                    terms: {
                        required: 'You must agree with terms'
                    }
                },
                errorPlacement: function (error, element) {
                    if (element.is(":radio") || element.is(":checkbox")) {
                        element.closest('.option-group').after(error);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            e.preventDefault();
            if (form.valid()) {
                $(this).addClass('ladda-button');
                alert('valide');
                var l = Ladda.create(this);
                l.start();
                setTimeout(function () {
                    window.location.href = "dashboard.html";
                }, 2000);
            } else {
                // alert('not valid');
            }
        });

    }
});