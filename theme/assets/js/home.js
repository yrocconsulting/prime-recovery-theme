/* Prime Recovery home designs: menu toggle, sticky header state, recovery circle. */
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

	// Header background once the page scrolls (used by option C).
	var header = document.querySelector('[data-scroll-header]');
	if (header) {
		var onScroll = function () {
			header.classList.toggle('is-scrolled', window.scrollY > 24);
		};
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	// Recovery circle (option B): product nodes act as tabs for the info panel.
	var circle = document.querySelector('[data-recovery-circle]');
	if (circle) {
		var tabs = Array.prototype.slice.call(circle.querySelectorAll('[role="tab"]'));
		var select = function (tab, focus) {
			tabs.forEach(function (t) {
				var on = t === tab;
				t.setAttribute('aria-selected', String(on));
				t.tabIndex = on ? 0 : -1;
				var panel = document.getElementById(t.getAttribute('aria-controls'));
				if (panel) {
					panel.hidden = !on;
				}
			});
			circle.setAttribute('data-active', tab.getAttribute('data-key'));
			if (focus) {
				tab.focus();
			}
		};
		tabs.forEach(function (tab, i) {
			tab.addEventListener('click', function () {
				select(tab, false);
			});
			tab.addEventListener('keydown', function (e) {
				var next = null;
				if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
					next = tabs[(i + 1) % tabs.length];
				} else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
					next = tabs[(i - 1 + tabs.length) % tabs.length];
				} else if (e.key === 'Home') {
					next = tabs[0];
				} else if (e.key === 'End') {
					next = tabs[tabs.length - 1];
				}
				if (next) {
					e.preventDefault();
					select(next, true);
				}
			});
		});
		circle.classList.add('is-enhanced');
		select(tabs[0], false);
	}
})();
