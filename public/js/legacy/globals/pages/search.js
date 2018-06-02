/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

( function( window ) {

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) {
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

var classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
};

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( classie );
} else {
  // browser global
  window.classie = classie;
}

})( window );


(function() {


    if($('#search-results').length){
          var morphSearch = document.getElementById( 'morphsearch' ),
          searchResult = document.getElementById( 'search-results' ),
              input = searchResult.querySelector( 'input' ),
              ctrlClose = morphSearch.querySelector( 'span.morphsearch-close' ),
              isOpen = isAnimating = false,
              // show/hide search area
              toggleSearch = function(evt) {
                  // return if open and the input gets focused
                  if( evt.type.toLowerCase() === 'focus' && isOpen ) return false;

                  var offsets = morphsearch.getBoundingClientRect();
                  if( isOpen ) {
                      classie.remove( morphSearch, 'open' );
                      classie.remove( searchResult, 'open' );
                      if( input.value !== '' ) {
                          setTimeout(function() {
                              classie.add( morphSearch, 'hideInput' );
                              classie.add( searchResult, 'hideInput' );
                              setTimeout(function() {
                                  classie.remove( morphSearch, 'hideInput' );
                                  classie.remove( searchResult, 'hideInput' );
                                  input.value = '';
                              }, 300 );
                          }, 500);
                      }
                      
                      input.blur();
                      $('body').removeClass('ov-hidden');
                      $('.page-content').css('display', '');
                  }
                  else {
                      classie.add( morphSearch, 'open' );
                      classie.add( searchResult, 'open' );
                      var morphSearchHeight = $('.morphsearch-content').height();

                      setTimeout(function(){
                        $('.page-content').css('display', 'none');
                      },450);
                                           
                      setTimeout(function(){
                        $('.morphsearch-input').focus();
                        if($('#noty_topRight_layout_container').length) $('#noty_topRight_layout_container').remove();
                      },200);
                  }
                  isOpen = !isOpen;
              };

          // events
          input.addEventListener( 'focus', toggleSearch );
          ctrlClose.addEventListener( 'click', toggleSearch );
          // esc key closes search overlay
          // keyboard navigation events

          document.addEventListener( 'keydown', function( ev ) {
              var keyCode = ev.keyCode || ev.which;
              if( keyCode === 27 && isOpen ) {
                  toggleSearch(ev);
              }
          });
    }

})();