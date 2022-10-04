/*————————————————————————————————————————————————————*\
    ●❱ ANIMATIONS
\*————————————————————————————————————————————————————*/

let slideUp = (target, duration = 500) => {
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
    window.setTimeout(() => {
        target.style.display = "none";
        target.style.removeProperty("height");
        target.style.removeProperty("padding-top");
        target.style.removeProperty("padding-bottom");
        target.style.removeProperty("margin-top");
        target.style.removeProperty("margin-bottom");
        target.style.removeProperty("overflow");
        target.style.removeProperty("transition-duration");
        target.style.removeProperty("transition-property");
        //alert("!");
    }, duration);
};
let slideDown = (target, duration = 500) => {
    target.style.removeProperty("display");
    let display = window.getComputedStyle(target).display;

    if (display === "none") display = "block";

    target.style.display = display;
    let height = target.offsetHeight;
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
    window.setTimeout(() => {
        target.style.removeProperty("height");
        target.style.removeProperty("overflow");
        target.style.removeProperty("transition-duration");
        target.style.removeProperty("transition-property");
    }, duration);
};
let slideToggle = (target, duration = 500) => {
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

( function() {
    const siteNavigation = document.getElementById( 'site-navigation' );

    // Return early if the navigation don't exist.
    if ( ! siteNavigation ) {
        return;
    }

    // const button = siteNavigation.getElementsByTagName( 'button' )[ 0 ];
    const button = document.querySelector("#site-nav-btn-close");

    // Return early if the button don't exist.
    if ( 'undefined' === typeof button ) {
        return;
    }

    const menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];

    // Hide menu toggle button if menu is empty and return early.
    if ( 'undefined' === typeof menu ) {
        button.style.display = 'none';
        return;
    }

    if ( ! menu.classList.contains( 'nav-menu' ) ) {
        menu.classList.add( 'nav-menu' );
    }

    // Toggle the .toggled class and the aria-expanded value each time the button is clicked.
    button.addEventListener( 'click', function() {
        siteNavigation.classList.toggle( 'toggled' );
    } );

    // Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
    // document.addEventListener( 'click', function( event ) {
    //     const isClickInside = siteNavigation.contains( event.target );

    //     if ( ! isClickInside ) {
    //         siteNavigation.classList.remove( 'toggled' );
    //         button.setAttribute( 'aria-expanded', 'false' );
    //     }
    // } );

    // Get all the link elements within the menu.
    const links = menu.getElementsByTagName( 'a' );

    // Get all the link elements with children within the menu.
    const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > .ancestor-wrapper > a, .page_item_has_children > .ancestor-wrapper > a' );

    // Toggle focus each time a menu link is focused or blurred.
    for ( const link of links ) {
        link.addEventListener( 'focus', toggleFocus, true );
        link.addEventListener( 'blur', toggleFocus, true );
    }

    // Toggle focus each time a menu link with children receive a touch event.
    for ( const link of linksWithChildren ) {
        link.addEventListener( 'touchstart', toggleFocus, false );
    }

    /**
     * Sets or removes .focus class on an element.
     */
    function toggleFocus() {
        if ( event.type === 'focus' || event.type === 'blur' ) {
            let self = this;
            // Move up through the ancestors of the current link until we hit .nav-menu.
            while ( ! self.classList.contains( 'nav-menu' ) ) {
                // On li elements toggle the class .focus.
                if ( 'li' === self.tagName.toLowerCase() ) {
                    self.classList.toggle( 'focus' );
                }
                self = self.parentNode;
            }
        }

        if ( event.type === 'touchstart' ) {
            const menuItem = this.parentNode;
            event.preventDefault();
            for ( const link of menuItem.parentNode.children ) {
                if ( menuItem !== link ) {
                    link.classList.remove( 'focus' );
                }
            }
            menuItem.classList.toggle( 'focus' );
        }
    }
}() );

/*————————————————————————————————————————————————————*\
    ●❱ MENU MOBILE
\*————————————————————————————————————————————————————*/

let button_menu = document.querySelector("#site-nav-btn-menu");
let button_close = document.querySelector("#site-nav-btn-close");
let main_nav = document.getElementById("site-navigation");

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

var elements = document.querySelectorAll(".ancestor-wrapper .sub-menu-toggle");
Array.prototype.forEach.call(elements, function (el, i) {

    el.addEventListener("click", function () {
        let parentN = this.parentNode;

        slideToggle(parentN.nextElementSibling);

        toggle_attr_expand(el);

    });
});

function toggle_attr_expand(element){

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

var lazyLoadInstance = new LazyLoad({
    // Your custom settings go here
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