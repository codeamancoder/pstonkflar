; (function ($) {
    $.fn.characterCounter = function (limit) {
        return this.filter("textarea, input:text").each(function () {
            var $this = $(this),
              checkCharacters = function (event) {

                  if ($this.val().length > limit) {

                      // Trim the string as paste would allow you to make it 
                      // more than the limit.
                      $this.val($this.val().substring(0, limit))
                      // Cancel the original event
                      event.preventDefault();
                      event.stopPropagation();

                  }
              };

            $this.keyup(function (event) {

                // Keys "enumeration"
                var keys = {
                    BACKSPACE: 8,
                    TAB: 9,
                    LEFT: 37,
                    UP: 38,
                    RIGHT: 39,
                    DOWN: 40
                };

                // which normalizes keycode and charcode.
                switch (event.which) {

                    case keys.UP:
                    case keys.DOWN:
                    case keys.LEFT:
                    case keys.RIGHT:
                    case keys.TAB:
                        break;
                    default:
                        checkCharacters(event);
                        break;
                }   

            });

            // Handle cut/paste.
            $this.bind("paste cut", function (event) {
                // Delay so that paste value is captured.
                setTimeout(function () { checkCharacters(event); event = null; }, 150);
            });
        });
    };
} (jQuery));


$('textarea[limit]').map(function(b,a){ $(a).characterCounter($(a).attr('limit')); });