function runCalendar() {
    var $modal = $('#event-modal');
    $('#external-events div.external-event').each(function () {
        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
            title:' $.trim($(this).text())' // use the element's text as the event title
        };
        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);
        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,      // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });
    });
    /*  Initialize the calendar  */
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var form = '';
    var today = new Date($.now());


    var calendar = $('#calendar').fullCalendar({
        slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
        minTime: '08:00:00',
        maxTime: '19:00:00',  
        defaultView: 'agendaWeek',  
        handleWindowResize: true,   
        height: $(window).height() - 200,   
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: [{
            title: 'Bring Files!',
            start: new Date($.now() + 158000000),
            className: 'bg-purple'
        }, {
            title: 'See John',
            start: today,
            end: today,
            className: 'bg-red'
        }, {
            title: 'Buy a Sandwich',
            start: new Date($.now() + 338000000),
            className: 'bg-primary'
        }],
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        eventLimit: true, // allow "more" link when too many events
        drop: function (date) { 
            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');
            var $categoryClass = $(this).attr('data-class');
            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);
            // assign it the date that was reported
            copiedEventObject.start = date;
            if ($categoryClass)
                copiedEventObject['className'] = [$categoryClass];
            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        selectable: true,
        eventClick: function (calEvent, jsEvent, view) {
            var form = $("<form></form>");
            form.append("<label>Change event name</label>");
            form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success'><i class='fa fa-check'></i> Save</button></span></div>");
            $modal.modal({
                backdrop: 'static'
            });
            $modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
                calendar.fullCalendar('removeEvents', function (ev) {
                    return (ev._id == calEvent._id);
                });
                $modal.modal('hide');
            });
            $modal.find('form').on('submit', function () {
                calEvent.title = form.find("input[type=text]").val();
                calendar.fullCalendar('updateEvent', calEvent);
                $modal.modal('hide');
                return false;
            });
        },
        select: function (start, end, allDay) {
            $modal.modal({
                backdrop: 'static'
            });
            form = $("<form></form>");
            form.append("<div class='row'></div>");
            form.find(".row")
                .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div></div>")
                .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>")
                .find("select[name='category']")
                .append("<option value='bg-red'>Work</option>")
                .append("<option value='bg-green'>Sport</option>")
                .append("<option value='bg-purple'>Meeting</option>")
                .append("<option value='bg-blue'>Lunch</option>")
                .append("<option value='bg-yellow'>Children</option></div></div>");
                inputSelect();
            $modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                form.submit();
            });
            $modal.find('form').on('submit', function () {
                title = form.find("input[name='title']").val();
                beginning = form.find("input[name='beginning']").val();
                ending = form.find("input[name='ending']").val();
                $categoryClass = form.find("select[name='category'] option:checked").val();
                if (title !== null && title.length != 0) {
                    calendar.fullCalendar('renderEvent', {
                        title: title,
                        start:start,
                        end: end,
                        allDay: false,
                        className: $categoryClass
                    }, true);  
                    $modal.modal('hide');
                }
                else{
                    alert('You have to give a title to your event');
                }
                return false;
                
            });
            calendar.fullCalendar('unselect');
        }
    });

    /* Creation of new category */
    $('.save-category').on('click', function(){
        formCategory = $('#add-category form');
        var categoryName = formCategory.find("input[name='category-name']").val();
        var categoryColor = formCategory.find("select[name='category-color']").val();
        if (categoryName !== null && categoryName.length != 0) {
            $('#external-events').append('<div class="external-event bg-' + categoryColor + '" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-move"></i>' + categoryName + '</div>')
            runCalendar();
        }

    });
}

$(function () {
    runCalendar();
});