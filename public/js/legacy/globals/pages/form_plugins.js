$(function() {

    /**** DATE AND TIME PLUGINS ****/

   /* Inline Date & Time picker */   
   $('#inline_datetimepicker').datetimepicker({
        altField: "#inline_datetimepicker_alt",
        altFieldTimeOnly: false,
        isRTL: $('body').hasClass('rtl') ? true : false
    });

    /**** COLOR PICKER PLUGINS ****/

    /* Color Picker */    
    /* You can initialize all options directly in input except for palette */
    $("#colorpicker1").spectrum({
        palette: [
            ['black', 'white', 'blanchedalmond'],
            ['rgb(255, 128, 0);', 'hsv 100 70 50', 'lightyellow']
        ]
    });

    $("#colorpicker2").spectrum({
        palette: [
            ['black', 'white', 'blanchedalmond',
            'rgb(255, 128, 0);', 'hsv 100 70 50'],
            ['red', 'yellow', 'green', 'blue', 'violet']
        ]
    }); 
  
    $("#colorpicker1, #colorpicker2").show();
                                                
});             




