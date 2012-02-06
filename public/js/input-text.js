$.fn.defaultText = function(options) {
    var defaults = {
        css: 'dimmed'
    };
    
    
    var options = $.extend({}, defaults, options);
    var event = false;
    var longdesc = false;
    if (!('text' in options)) return this;
    
    if('event' in options) {
        this.event = true;
    }
    if('longdesc' in options) {
        this.longdesc = true;    
    }
    
        
    var input = this[0],
        event = this[1],
        $input = this,
        offset = $input.offset();
   
    function hide() {
      $div.hide();
      $input.add($div).removeClass(options.css);
    };

    function show() {
       $div.show();
       $input.add($div).addClass(options.css);
    }

    function focus() {
        if (input.value.length) hide();
        else show();
    };
    
  
    if ($('.outside').length){
        fontsize = '24px';
        topPos = '12px';
        leftPos = '7px'
    } else if(this.event) {
        fontsize = '18px';
        topPos = '12px';
        leftPos = '125px'
    } else if(this.longdesc){
        fontsize = '18px';
        topPos = '12px';
        leftPos = '12px'
    }else {
        fontsize = '18px';
        topPos = '7px';
        leftPos = '7px'
    }
    var $div;
    // Create div to put placeholder text in
    if (!input.value.length) {
        $div = $('<div class="'+this.attr('id')+'_default">' + options.text + '</div>')
        // Position it to the same place as the input box:
        .css({ position: 'absolute',
               top: topPos,
               //left: offset.left + 4,
               left: leftPos,
               cursor: 'text',
               'font-size': fontsize
            })
        .click(function() {
            $input.focus();
            focus();
        })
        .addClass(options.css + ' unselectable')
        .appendTo($(this).parent());
    }
    // Also add the class to the input box:
    $input
        .keyup(focus).blur(function() {
            if (!input.value.length) show();
        });
    
    return this;
};