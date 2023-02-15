(function($) {
    "use strict"
    
    // Colorpicker
     $(".as_colorpicker").asColorPicker({
            
            nameDegradation: 'HEX',
            
    });
    $(".complex-colorpicker").asColorPicker({
        mode: 'complex'
    });
    $(".gradient-colorpicker").asColorPicker({
        mode: 'gradient'
    });
})(jQuery);