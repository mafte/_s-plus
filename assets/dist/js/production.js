"use strict";

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/*————————————————————————————————————————————————————*\
    ●❱ ANIMATIONS
\*————————————————————————————————————————————————————*/
var slideUp = function slideUp(target) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 500;
  target.style.transitionProperty = "height, margin, padding";
  target.style.transitionDuration = duration + "ms";
  target.style.boxSizing = "border-box";
  target.style.height = target.offsetHeight + "px";
  target.offsetHeight;
  target.style.overflow = "hidden";
  target.style.height = 0;
  target.style.paddingTop = 0;
  target.style.paddingBottom = 0;
  target.style.marginTop = 0;
  target.style.marginBottom = 0;
  window.setTimeout(function () {
    target.style.display = "none";
    target.style.removeProperty("height");
    target.style.removeProperty("padding-top");
    target.style.removeProperty("padding-bottom");
    target.style.removeProperty("margin-top");
    target.style.removeProperty("margin-bottom");
    target.style.removeProperty("overflow");
    target.style.removeProperty("transition-duration");
    target.style.removeProperty("transition-property"); //alert("!");
  }, duration);
};

var slideDown = function slideDown(target) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 500;
  target.style.removeProperty("display");
  var display = window.getComputedStyle(target).display;
  if (display === "none") display = "block";
  target.style.display = display;
  var height = target.offsetHeight;
  target.style.overflow = "hidden";
  target.style.height = 0;
  target.style.paddingTop = 0;
  target.style.paddingBottom = 0;
  target.style.marginTop = 0;
  target.style.marginBottom = 0;
  target.offsetHeight;
  target.style.boxSizing = "border-box";
  target.style.transitionProperty = "height, margin, padding";
  target.style.transitionDuration = duration + "ms";
  target.style.height = height + "px";
  target.style.removeProperty("padding-top");
  target.style.removeProperty("padding-bottom");
  target.style.removeProperty("margin-top");
  target.style.removeProperty("margin-bottom");
  window.setTimeout(function () {
    target.style.removeProperty("height");
    target.style.removeProperty("overflow");
    target.style.removeProperty("transition-duration");
    target.style.removeProperty("transition-property");
  }, duration);
};

var slideToggle = function slideToggle(target) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 500;

  if (window.getComputedStyle(target).display === "none") {
    return slideDown(target, duration);
  } else {
    return slideUp(target, duration);
  }
};
/*————————————————————————————————————————————————————*\
    ●❱ Navigation accesibility
\*————————————————————————————————————————————————————*/

/*
——— Handles toggling the navigation menu for small screens and enables TAB key
    navigation support for dropdown menus
*/


(function () {
  var siteNavigation = document.getElementById('site-navigation'); // Return early if the navigation don't exist.

  if (!siteNavigation) {
    return;
  } // const button = siteNavigation.getElementsByTagName( 'button' )[ 0 ];


  var button = document.querySelector("#site-nav-btn-close"); // Return early if the button don't exist.

  if ('undefined' === typeof button) {
    return;
  }

  var menu = siteNavigation.getElementsByTagName('ul')[0]; // Hide menu toggle button if menu is empty and return early.

  if ('undefined' === typeof menu) {
    button.style.display = 'none';
    return;
  }

  if (!menu.classList.contains('nav-menu')) {
    menu.classList.add('nav-menu');
  } // Toggle the .toggled class and the aria-expanded value each time the button is clicked.


  button.addEventListener('click', function () {
    siteNavigation.classList.toggle('toggled');
  }); // Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
  // document.addEventListener( 'click', function( event ) {
  //     const isClickInside = siteNavigation.contains( event.target );
  //     if ( ! isClickInside ) {
  //         siteNavigation.classList.remove( 'toggled' );
  //         button.setAttribute( 'aria-expanded', 'false' );
  //     }
  // } );
  // Get all the link elements within the menu.

  var links = menu.getElementsByTagName('a'); // Get all the link elements with children within the menu.

  var linksWithChildren = menu.querySelectorAll('.menu-item-has-children > .ancestor-wrapper > a, .page_item_has_children > .ancestor-wrapper > a'); // Toggle focus each time a menu link is focused or blurred.

  var _iterator = _createForOfIteratorHelper(links),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var link = _step.value;
      link.addEventListener('focus', toggleFocus, true);
      link.addEventListener('blur', toggleFocus, true);
    } // Toggle focus each time a menu link with children receive a touch event.

  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }

  var _iterator2 = _createForOfIteratorHelper(linksWithChildren),
      _step2;

  try {
    for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
      var _link = _step2.value;

      _link.addEventListener('touchstart', toggleFocus, false);
    }
    /**
     * Sets or removes .focus class on an element.
     */

  } catch (err) {
    _iterator2.e(err);
  } finally {
    _iterator2.f();
  }

  function toggleFocus() {
    if (event.type === 'focus' || event.type === 'blur') {
      var self = this; // Move up through the ancestors of the current link until we hit .nav-menu.

      while (!self.classList.contains('nav-menu')) {
        // On li elements toggle the class .focus.
        if ('li' === self.tagName.toLowerCase()) {
          self.classList.toggle('focus');
        }

        self = self.parentNode;
      }
    }

    if (event.type === 'touchstart') {
      var menuItem = this.parentNode;
      event.preventDefault();

      var _iterator3 = _createForOfIteratorHelper(menuItem.parentNode.children),
          _step3;

      try {
        for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
          var link = _step3.value;

          if (menuItem !== link) {
            link.classList.remove('focus');
          }
        }
      } catch (err) {
        _iterator3.e(err);
      } finally {
        _iterator3.f();
      }

      menuItem.classList.toggle('focus');
    }
  }
})();
/*————————————————————————————————————————————————————*\
    ●❱ MENU MOBILE
\*————————————————————————————————————————————————————*/


var button_menu = document.querySelector("#site-nav-btn-menu");
var button_close = document.querySelector("#site-nav-btn-close");
var main_nav = document.getElementById("site-navigation");

if (button_menu) {
  button_menu.addEventListener("click", function () {
    main_nav.classList.toggle("show--fade");
    toggle_attr_expand(button_menu);
    toggle_attr_expand(button_close);
  });
}

if (button_close) {
  button_close.addEventListener("click", function () {
    main_nav.classList.toggle("show--fade");
    toggle_attr_expand(button_menu);
    toggle_attr_expand(button_close);
  });
}

var sub_menu_toggles = document.querySelectorAll(".ancestor-wrapper .sub-menu-toggle");

if (sub_menu_toggles) {
  sub_menu_toggles.forEach(function (el) {
    el.addEventListener("click", function () {
      var parentN = this.parentNode;
      slideToggle(parentN.nextElementSibling);
      toggle_attr_expand(el);
    });
  });
}

function toggle_attr_expand(element) {
  if (element.getAttribute("aria-expanded") === "true") {
    element.setAttribute("aria-expanded", "false");
  } else {
    element.setAttribute("aria-expanded", "true");
  }
}
/*————————————————————————————————————————————————————*\
    ●❱ LIBRARIES SETTINGS
\*————————————————————————————————————————————————————*/

/*  |> LAZYLOAD
——————————————————————————————————————————————————————*/


var lazyLoadInstance = new LazyLoad({// Your custom settings go here
});
/*  |> TINY-SLIDER
——————————————————————————————————————————————————————*/
// window.addEventListener("load", () => {
// 	if (document.querySelector(".slider")) {
// 		var slider_name = tns({
// 			container: ".slider",
// 			loop: true,
// 			gutter: 30,
// 			// autoplay: true,
// 			mouseDrag: true,
// 			nav: false,
// 			autoplayButtonOutput: false,
// 			responsive: {
// 				998: {
// 					items: 2,
// 					autoHeight: false,
// 				},
// 				320: {
// 					items: 1,
// 					autoHeight: true,
// 				},
// 			},
// 		});
// 	}
// });

/*————————————————————————————————————————————————————*\
    ●❱ SMOOTH SCROLL
\*————————————————————————————————————————————————————*/
// const navLinks = document.querySelectorAll(
//     'a[href^="#"]:not(.skip-link)'
// );
// Array.from(navLinks).forEach(navLink => {
//     const href = navLink.getAttribute('href');
//     if (href !== '#') {
//         if (document.querySelector(href)) {
//             const section = document.querySelector(href);
//             const offset = 80; // nav and offset
//             navLink.onclick = e => {
//                 // get body position
//                 const bodyRect = document.body.getBoundingClientRect().top;
//                 // get section position relative
//                 const sectionRect = section.getBoundingClientRect().top;
//                 // subtract the section from body
//                 const sectionPosition = sectionRect - bodyRect;
//                 // subtract offset
//                 const offsetPosition = sectionPosition - offset;
//                 e.preventDefault();
//                 window.scrollTo({
//                     top: offsetPosition,
//                     behavior: 'smooth'
//                 });
//                 if (history.pushState) {
//                     history.pushState(null, null, href);
//                 } else {
//                     window.location.hash = href;
//                 }
//             }
//         }
//     }
// })