/**** TODO LIST WIDGET ****/

$(document).ready(function(){
    handleTodoList();
});

function handleTodoList(){

    var item = '';

    if($('.todo-list').length){
          var number_items = $( ".todo-list li" ).length;
          var dt = new Date();
          var currentDay = dt.getDate();
          var monthNames = [ "January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December" ];
          currentMonth = monthNames[dt.getMonth()];

          /* Context Menu */
          var todoMenuContext = '<div id="context-menu" class="dropdown clearfix">'+
                              '<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">'+
                                '<li><a href="#" data-priority="high"><i class="fa fa-circle-o c-red"></i> High Priority</a></li>'+
                                '<li><a href="#" data-priority="medium"><i class="fa fa-circle-o c-orange"></i> Medium Priority</a></li>'+
                                '<li><a href="#" data-priority="low"><i class="fa fa-circle-o c-yellow"></i> Low Priority</a></li>'+
                                '<li><a href="#" data-priority="none"><i class="fa fa-circle-o c-gray"></i> None</a></li>'+
                              '</ul>'+
                            '</div>';
          $('.main-content').append(todoMenuContext);
          var $contextMenu = $("#context-menu");
          $('.todo-list').on('mousedown', 'li:not(.editing-input)', function(){
              $(this).contextmenu({
                  target: '#context-menu',
                  onItem: function (context, e) {
                      var current_priority = $(e.target).data("priority");
                      context.removeAttr("class").addClass(current_priority);
                  }
              });
          });

          /* Editable Task & Date */
          $('.todo-list .todo-task').editable({
              type: 'text',
              mode: 'inline'
          });
          $('.todo-list .due-date-span').editable({
              type: 'date',
              format: 'dd MM yyyy'
          });

          /* Sortable Task */
          $(".todo-list").sortable({
              cancel: ".done",
              axis: "y",
              cursor: "move",
              forcePlaceholderSize: true
          });

          /* Done / Undone Task */
          $(".todo-list").on("ifChecked", ".span-check input", function(){
            var parent = $(this).parents("li:first");
              $(parent).removeClass('bounceInDown').addClass("done");
              $(parent).data("task-order",$(parent).index()).insertAfter($(".todo-list li:last"));
              $('.todo-task',parent).editable("disable");
              $('.completed-date',parent).text('Completed on ' + currentDay + ' ' + currentMonth);
              $('.due-date-span',parent).editable("disable");
          });

          $('.editable').on('shown', function(e, editable) {
              $(this).parents('li').addClass('editing-input');
          });

          $('.editable').on('hidden', function(e, reason) {
              $(this).parents('li').removeClass('editing-input');
          });

          $(".todo-list").on("ifUnchecked", ".span-check input", function(){
            var parent = $(this).parents("li:first");
              $(parent).removeClass("done");
              if($(parent).data("task-order")){
                console.log($(parent).data("task-order"));
                  $(parent).insertAfter($(".todo-list li:eq("+($(parent).data("task-order")-1)+")"));
              }
              else {
                $(".todo-list").prepend($(parent));
              }
              $('.todo-task',parent).editable("enable");   
              $('.due-date-span',parent).editable("enable");     
              $('.completed-date',parent).text("");  
          });

          /* Material Design */
          $(".todo-list.md-todo").on("change", "input", function(){
              if(this.checked){
                var parent = $(this).parents("li:first");
                $(parent).removeClass('bounceInDown').addClass("done");
                $(parent).data("task-order",$(parent).index()).insertAfter($(".todo-list li:last"));
                $('.todo-task',parent).editable("disable");
                $('.completed-date',parent).text('Completed on ' + currentDay + ' ' + currentMonth);
                $('.due-date-span',parent).editable("disable");
              }
          });
          $(".todo-list.md-todo").on("change", "input", function(){
            if(!this.checked){
              var parent = $(this).parents("li:first");
                $(parent).removeClass("done");
                if($(parent).data("task-order")){
                  console.log($(parent).data("task-order"));
                    $(parent).insertAfter($(".todo-list li:eq("+($(parent).data("task-order")-1)+")"));
                }
                else {
                  $(".todo-list").prepend($(parent));
                }
                $('.todo-task',parent).editable("enable");   
                $('.due-date-span',parent).editable("enable");     
                $('.completed-date',parent).text("");  
              }
          });

          /* Check All Tasks */
          $(document).on("click", ".check-all-tasks", function(){
              $(this).removeClass('check-all-tasks').addClass('uncheck-all-tasks').html('Uncheck All');
              $('.todo-list li').removeClass('bounceInDown').addClass("done");
              $('input').iCheck('check');
          });

          /* Uncheck All Tasks */
          $(document).on("click", ".uncheck-all-tasks", function(){
              $(this).removeClass('uncheck-all-tasks').addClass('check-all-tasks').html('Check All Done');
              $('.todo-list li').removeClass("done");
              $('input').iCheck('uncheck');
          });

          /* Add Task */
          $(document).on("click",".add-task", function(){
            item = '';
            number_items++;

            

            if($(this).hasClass('md-task')){
              item = '<li class="new-task animated bounceInDown">'+
                        '<div class="checkbox checkbox-primary">'+
                          '<label for="task-' + number_items +'">'+
                            '<input id="task-' + number_items + '" type="checkbox" name="r-primary" value="option1" class="md-checkbox">'+
                            '<span class="todo-task editable editable-click">New Task</span>'+
                          '</label>'+
                        '</div>'+
                        '<div class="todo-date clearfix">'+
                          '<div class="completed-date"></div>'+
                          '<div class="due-date">'+ currentDay + ' ' + currentMonth+'</div>'+
                        '</div>'+
                        '<span class="todo-options pull-right">'+
                        '<a href="javascript:;" class="todo-delete"><i class="icons-office-52"></i></a>'+
                        '</span>'+
                      '</li>';
          }
            else{
                item = '<li class="new-task animated bounceInDown">'+
                        '<span class="span-check">'+
                            '<input id="task-' + number_items + '" type="checkbox" data-checkbox="icheckbox_square-blue"/>'+
                            '<label for="task-' + number_items +'"></label>'+
                        '</span>'+
                        '<span class="todo-task editable editable-click">New Task</span>'+
                        '<div class="todo-date clearfix">'+
                            '<div class="completed-date"></div>'+
                            '<div class="due-date">'+ currentDay + ' ' + currentMonth+'</div>'+
                        '</div>'+
                        '<span class="todo-options pull-right">'+
                            '<a href="javascript:;" class="todo-delete" data-rel="tooltip" data-original-title="Remove task"><i class="icons-office-52"></i></a>'+
                        '</span>'+
                    '</li>';
            }
            $(this).parent().parent().parent().find(".todo-list").append(item);
            $('.todo-list .todo-task').editable({
                  type: 'text',
                  mode: 'inline'
                });
                window.setTimeout(function () {
                    $(".todo-list li").removeClass("animated");
                }, 500);
                $('[data-rel="tooltip"]').tooltip();
                $.material.checkbox();
          });

          /* Remove Task */
          $(document).on("click", ".todo-delete", function(){
              var parent = $(this).parents("li:first");
              $(parent).hide(200);
          });

      }


}