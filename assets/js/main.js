/*————————————————————————————————————————————————————*\
    ●❱ ANIMATIONS
\*————————————————————————————————————————————————————*/

function slideToggle(el, duration, callback) { if (el.clientHeight === 0) { _s(el, duration, callback, true); } else { _s(el, duration, callback); } }
function slideUp(el, duration, callback) { _s(el, duration, callback); }
function slideDown(el, duration, callback) { _s(el, duration, callback, true); }
function _s(el, duration, callback, isDown) {
    if (typeof duration === 'undefined') duration = 400; if (typeof isDown === 'undefined') isDown = false; el.style.overflow = "hidden"; if (isDown) el.style.display = "block"; var elStyles = window.getComputedStyle(el); var elHeight = parseFloat(elStyles.getPropertyValue('height')); var elPaddingTop = parseFloat(elStyles.getPropertyValue('padding-top')); var elPaddingBottom = parseFloat(elStyles.getPropertyValue('padding-bottom')); var elMarginTop = parseFloat(elStyles.getPropertyValue('margin-top')); var elMarginBottom = parseFloat(elStyles.getPropertyValue('margin-bottom')); var stepHeight = elHeight / duration; var stepPaddingTop = elPaddingTop / duration; var stepPaddingBottom = elPaddingBottom / duration; var stepMarginTop = elMarginTop / duration; var stepMarginBottom = elMarginBottom / duration; var start; function step(timestamp) {
        if (start === undefined) start = timestamp; var elapsed = timestamp - start; if (isDown) { el.style.height = (stepHeight * elapsed) + "px"; el.style.paddingTop = (stepPaddingTop * elapsed) + "px"; el.style.paddingBottom = (stepPaddingBottom * elapsed) + "px"; el.style.marginTop = (stepMarginTop * elapsed) + "px"; el.style.marginBottom = (stepMarginBottom * elapsed) + "px"; } else { el.style.height = elHeight - (stepHeight * elapsed) + "px"; el.style.paddingTop = elPaddingTop - (stepPaddingTop * elapsed) + "px"; el.style.paddingBottom = elPaddingBottom - (stepPaddingBottom * elapsed) + "px"; el.style.marginTop = elMarginTop - (stepMarginTop * elapsed) + "px"; el.style.marginBottom = elMarginBottom - (stepMarginBottom * elapsed) + "px"; }
        if (elapsed >= duration) { el.style.height = ""; el.style.paddingTop = ""; el.style.paddingBottom = ""; el.style.marginTop = ""; el.style.marginBottom = ""; el.style.overflow = ""; if (!isDown) el.style.display = "none"; if (typeof callback === 'function') callback(); } else { window.requestAnimationFrame(step); }
    }
    window.requestAnimationFrame(step);
}

/*————————————————————————————————————————————————————*\
    ●❱ Navigation accesibility
\*————————————————————————————————————————————————————*/

/*
——— Handles toggling the navigation menu for small screens and enables TAB key
    navigation support for dropdown menus
*/

(function () {
    const siteNavigation = document.getElementById('site-navigation');

    // Return early if the navigation don't exist.
    if (!siteNavigation) {
        return;
    }

    const menu = siteNavigation.getElementsByTagName('ul')[0];

    if (!menu.classList.contains('nav-menu')) {
        menu.classList.add('nav-menu');
    }

    // Get all the link elements within the menu.
    const links = menu.getElementsByTagName('a');

    // Get all the link elements with children within the menu.
    // const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > .ancestor-wrapper > a, .page_item_has_children > .ancestor-wrapper > a' );

    // Toggle focus each time a menu link is focused or blurred.
    for (const link of links) {
        link.addEventListener('focus', toggleFocus, true);
        link.addEventListener('blur', toggleFocus, true);
    }

    /**
     * Sets or removes .focus class on an element.
     */
    function toggleFocus() {
        if (event.type === 'focus' || event.type === 'blur') {
            let self = this;
            // Move up through the ancestors of the current link until we hit .nav-menu.
            while (!self.classList.contains('nav-menu')) {
                // On li elements toggle the class .focus.
                if ('li' === self.tagName.toLowerCase()) {
                    self.classList.toggle('focus');
                }
                self = self.parentNode;
            }
        }
    }
}());

/*————————————————————————————————————————————————————*\
    ●❱ MENU MOBILE
\*————————————————————————————————————————————————————*/

let $btns_open = document.querySelectorAll(".js-menu-toggle--open");
let $btns_close = document.querySelectorAll(".js-menu-toggle--close");

if (document.querySelector('.site-header-sticky')) {
    var main_nav = document.querySelector(".site-header-sticky #site-navigation--sticky-menu");
} else {
    var main_nav = document.querySelector(".site-header #site-navigation");
}

document.addEventListener('click', (e) => {
    let $target = e.target;

    // console.log($target);

    if ($target.classList.contains('menu-toggle') || $target.closest('.menu-toggle')) {
        main_nav.classList.toggle("show--fade");

        $btns_open.forEach((el)=>{
            toggle_attr_expand(el);
        })

        $btns_close.forEach((el)=>{
            toggle_attr_expand(el);
        })

    }
})

let sub_menu_toggles = document.querySelectorAll(".ancestor-wrapper .sub-menu-toggle");
if (sub_menu_toggles) {
    sub_menu_toggles.forEach(el => {
        el.addEventListener("click", function () {
            let parentN = this.parentNode;
            slideToggle(parentN.nextElementSibling, 300);
            toggle_attr_expand(el);
        });
    })
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