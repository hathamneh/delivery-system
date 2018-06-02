if($('.page-content').hasClass('mailbox-send')){
    var dt = new Date();
    var currentDay = dt.getDate();
    var monthNames = [ "January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December" ];
    var currentMonth = monthNames[dt.getMonth()];
    var hours = dt.getHours();
    var minutes = dt.getMinutes();
    var currentDate = currentDay + ' ' + currentMonth + ', ' + hours +':'+ minutes;
    $('.date-send').text(currentDate);

    /* Context Menu */
    var emailMenuContext = '<div id="context-menu" class="email-context dropdown clearfix">'+
                      '<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">'+
                        '<li><a data-remove="true" href="#">Remove Contact</a></li>'+
                      '</ul>'+
                    '</div>';
    $('.main-content').append(emailMenuContext);
    var $contextMenu = $("#context-menu");
    $('.emails-list').on('mousedown', '.message-item', function(){
      $(this).contextmenu({
          target: '#context-menu',
          onItem: function (context, e) {
              var currentLabel = $(e.target).data("label") ? $(e.target).data("label") : false;
              var currentLabelColor = $(e.target).data("color") ? $(e.target).data("color") : false;
              if(context.find('.subject .label').length > 0 && !$(e.target).data("remove")){
                context.find('.subject .label').remove();
              }
              if(currentLabel && currentLabelColor){
                context.find('.subject').prepend('<span class="label label-'+ currentLabelColor +'">'+ currentLabel +'</span>');
              }
              if($(e.target).data("remove")){
                context.slideUp(200, function(){
                    context.remove();
                });
              }
          }
      });
    });

    /* Display selected email */
    $('.emails-list').on('click', '.message-item', function(){
        var emailSender = $(this).find('.email').text();
        $('#recipient').tagsinput('add', emailSender);
    });

    /* Send Email */
    $('.answer-textarea').summernote({
        focus: true,
        toolbar: [
            ["style", ["style"]],
            ["style", ["bold", "italic", "underline", "clear"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
            ["table", ["table"]]
        ]
    });

    /*  Search Function  */
    if ($('input#email-search').length) {
        $('input#email-search').val('').quicksearch('.active .message-item', {
            selector: '.sender, .subject',
            'onAfter': function () {
                customScroll();
                
            },
        });
    }

    $('#save').on('click', function() {
        window.location = 'mailbox.html';
    });

}
else{
    /****  Initiation of Main Functions  ****/
    $(document).ready(function () {
        windowWidth = $(window).width();
        $('.go-back-list').on('click', function(){
            $('.email-details').fadeOut(200, function(){
                $('.emails-list').fadeIn();
            });
        });

        if(windowWidth < 800){
            $('.emails-list .tab-content .message-item').on('click', function(){
                $('.emails-list').fadeOut(200, function(){
                    $('.email-details').fadeIn();
                    customScroll();
                });
            });
        }

        $('.nav-tabs a').on('click', function(){
            setTimeout(function(){
                customScroll();
            },200);
        });

    });

    $(window).resize(function(){
        windowWidth = $(window).width();
        if(windowWidth > 800){
            $('.emails-list, .email-details').css('display', 'table-cell');
        }
        else {
            $('.email-details').css('display', 'none');
            $('.emails-list .tab-content .message-item').on('click', function(){
                $('.emails-list').fadeOut(200, function(){
                    $('.email-details').fadeIn();
                    customScroll();
                });
            });
        }


    });

    /* Context Menu */
    var emailMenuContext = '<div id="context-menu" class="email-context dropdown clearfix">'+
                      '<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">'+
                        '<li><a href="#" data-label="business" data-color="danger"><i class="fa fa-circle-o c-red" data-label="business" data-color="danger"></i> Business</a></li>'+
                        '<li><a href="#" data-label="family" data-color="primary"><i class="fa fa-circle-o c-blue" data-label="family" data-color="primary"></i> Family</a></li>'+
                        '<li><a href="#" data-label="friends" data-color="success"><i class="fa fa-circle-o c-green" data-label="friends" data-color="success"></i> Friends</a></li>'+
                        '<li><a href="#" data-label="personal" data-color="warning"><i class="fa fa-circle-o c-yellow" data-label="personal" data-color="warning"></i> Personal</a></li>'+
                        '<li><a href="#"><i class="fa fa-circle-o c-gray"></i> No label</a></li>'+
                        '<li class="border-top"><a data-remove="true" href="#"><i class="fa fa-times"></i> Remove Email</a></li>'+
                      '</ul>'+
                    '</div>';
    $('.main-content').append(emailMenuContext);
    var $contextMenu = $("#context-menu");
    $('.emails-list').on('mousedown', '.message-item', function(){
      $(this).contextmenu({
          target: '#context-menu',
          onItem: function (context, e) {
              var currentLabel = $(e.target).data("label") ? $(e.target).data("label") : false;
              var currentLabelColor = $(e.target).data("color") ? $(e.target).data("color") : false;
              if(context.find('.subject .label').length > 0 && !$(e.target).data("remove")){
                context.find('.subject .label').remove();
              }
              if(currentLabel && currentLabelColor){
                context.find('.subject').prepend('<span class="label label-'+ currentLabelColor +'">'+ currentLabel +'</span>');
              }
              if($(e.target).data("remove")){
                context.slideUp(200, function(){
                    context.remove();
                });
              }
          }
      });
    });


    /* Summernote inline editing functions */
    $.fn.lastWord = function() {
      var text = this.text().trim().split(" ");
      var last = text.pop();
      this.html(text.join(" ") + (text.length > 0 ? " <strong>" + last + "</strong>" : last));
    };

    /* Display selected email */
    $('.emails-list').on('click', '.message-item', function(){
        var emailSender = $(this).find('.sender').text();
        var emailSubject = $(this).find('.subject-text').text();
        var emailDate = $(this).find('.date').text();
        var emailContent = $(this).find('.email-content').html();

        $('.email-details h1').fadeOut(200, function(){
            $(this).text(emailSubject).fadeIn(200);
            $(this).lastWord();
        });
        $('.email-details .sender').fadeOut(200, function(){
            $(this).text(emailSender).fadeIn(200);
        });
        $('.email-details .date').fadeOut(200, function(){
            $(this).text(emailDate).fadeIn(200);
        });
        $('.email-details .email-content').fadeOut(200, function(){
            $(this).html(emailContent).fadeIn(200);
            customScroll(); 
        });
    });

    /* Send Answer */
    $('.answer-textarea').on('click', function() {
        $('.answer-textarea').summernote({
            focus: true,
            toolbar: [
                ["style", ["style"]],
                ["style", ["bold", "italic", "underline", "clear"]],
                ["fontsize", ["fontsize"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["height", ["height"]],
                ["table", ["table"]]
            ]
        });
    });

    $('#save').on('click', function() {
        var aHTML = $('.answer-textarea').code(); //save HTML If you need(aHTML: array).
        $('.answer-textarea').destroy();
        var mailTitle = $('.email-subject h1').text();
        $('.answer-title').html('<strong>Re:</strong> '+ mailTitle);
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes();
        var currentDate = 'Today, '+time;
        $('.answer-date').text(currentDate);

        var answerTxt = $('.answer-textarea').html();
        $('.answer-content').html(answerTxt);
        $('.answer-textarea').html('');
        $('.answers').show();
        $('.write-answer').slideUp();
    });


}


/*  Search Function  */
if ($('input#email-search').length) {
    $('input#email-search').val('').quicksearch('.active .message-item', {
        selector: '.subject-text',
        'onAfter': function () {
            customScroll();
            
        },
    });
}
var day_data = [
    {"elapsed": "January 2014", "value": 24, b:18},
    {"elapsed": "February 2014", "value": 34, b:22},
    {"elapsed": "March 2014", "value": 33, b:20},
    {"elapsed": "April 2014", "value": 22, b:16},
    {"elapsed": "May 2014", "value": 28, b:17},
    {"elapsed": "June 2014", "value": 30, b:15},
    {"elapsed": "July 2014", "value": 32, b:17},
    {"elapsed": "August 2014", "value": 34, b:15},
    {"elapsed": "September 2014", "value": 36, b:18},
    {"elapsed": "October 2014", "value": 42, b: 18},
    {"elapsed": "November 2014", "value": 44, b: 18},
    {"elapsed": "December 2014 ", "value": 52, b: 29},
    {"elapsed": "January 2015", "value": 51, b: 13},
    {"elapsed": "February 2015", "value": 54, b:15},
    {"elapsed": "March 2015", "value": 52, b:22},
    {"elapsed": "April 2015", "value": 45, b:17},
    {"elapsed": "May 2015", "value": 48, b:14},
    {"elapsed": "June 2015", "value": 54, b:17},
    {"elapsed": "July 2015", "value": 60, b:15},
    {"elapsed": "August 2015", "value": 60, b:17},
    {"elapsed": "September 2015", "value": 58, b:15},
    {"elapsed": "October 2015", "value": 54, b:18},
    {"elapsed": "November 2015", "value": 52, b: 18},
    {"elapsed": "December 2015", "value": 50, b: 18}
];

if($('#morris-chart-network').length){
    var chart = Morris.Area({
        element: 'morris-chart-network',
        data: day_data,
        axes:false,
        xkey: 'elapsed',
        ykeys: ['value', 'b'],
        labels: ['Email Received', 'Email Sent'],
        yLabelFormat :function (y) { return y.toString() + '  emails'; },
        gridEnabled: false,
        gridLineColor: 'transparent',
        lineColors: ['#7faadd','#005dad'],
        lineWidth:0,
        pointSize:0,
        pointFillColors:['#3e80bd'],
        pointStrokeColors:'#3e80bd',
        fillOpacity:.3,
        gridTextColor:'#999',
        parseTime: false,
        resize:true,
        behaveLikeLine : true,
        hideHover: 'auto',
          hoverCallback: function(index, options, content) {
            $("#chart-legend").html("<div><strong>" +  options.data[index].elapsed + "</strong><br>  " + options.labels[0] + ": " + options.data[index].value + "<br />" + options.labels[1] + ": " + options.data[index].b + "</div>");
        },
    });
}
