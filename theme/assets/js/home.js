/* Prime Recovery home designs: menu toggle and sticky header state. */
(function () {
	'use strict';

	document.documentElement.classList.add('js');

	// Mobile menu toggles.
	document.querySelectorAll('.menu-toggle').forEach(function (btn) {
		var target = document.getElementById(btn.getAttribute('aria-controls'));
		if (!target) {
			return;
		}
		btn.addEventListener('click', function () {
			var open = btn.getAttribute('aria-expanded') !== 'true';
			btn.setAttribute('aria-expanded', String(open));
			target.classList.toggle('is-open', open);
			document.body.classList.toggle('menu-open', open);
		});
	});

	// Header background once the page scrolls.
	var header = document.querySelector('[data-scroll-header]');
	if (header) {
		var onScroll = function () {
			header.classList.toggle('is-scrolled', window.scrollY > 24);
		};
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}
})();
