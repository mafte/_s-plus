/* ● ANIMATIONS ❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱ */


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

/* ● MENU MOBILE ❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱ */

let button_menu = document.getElementsByClassName("menu-toggle")[0];
let button_close = document.getElementsByClassName("menu-toggle__close")[0];
let main_nav = document.getElementById("site-navigation");

button_menu.addEventListener("click", function () {
	main_nav.classList.toggle("show--fade");
});

button_close.addEventListener("click", function () {
	main_nav.classList.toggle("show--fade");

	if (button_menu.getAttribute("aria-expanded") === "true") {
		button_menu.setAttribute("aria-expanded", "false");
	} else {
		button_menu.setAttribute("aria-expanded", "true");
	}
});

var elements = document.querySelectorAll(".ancestor-wrapper .sub-menu-toggle");
Array.prototype.forEach.call(elements, function (el, i) {

	el.addEventListener("click", function () {
		let parentN = this.parentNode;

		slideToggle(parentN.nextElementSibling);

		if (el.getAttribute("aria-expanded") === "true") {
			el.setAttribute("aria-expanded", "false");
		} else {
			el.setAttribute("aria-expanded", "true");
		}
	});
});

/* ● LAZYLOAD ❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱ */

var lazyLoadInstance = new LazyLoad({
	// Your custom settings go here
});

/* ● TINY-SLIDER ❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱ */

if(document.querySelector(".my-slider")){
	var slider = tns({
		container: '.my-slider',
		items: 1,
		slideBy: 'page',
		autoplay: true
	});
}

/* ● SMOOTH SCROLL ❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱❱ */

/* Fires whenever --scroll-behavior: smooth; is declared in the html element */