/* raspiBackup Pro – landing page interactions (no dependencies). */
(function () {
	'use strict';

	// Mobile menu.
	var toggle = document.querySelector('.rbp-menu-toggle');
	var nav = document.getElementById('rbp-nav');
	function setMenu(open) {
		document.body.classList.toggle('rbp-nav-open', open);
		if (toggle) { toggle.setAttribute('aria-expanded', open ? 'true' : 'false'); }
	}
	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			setMenu(!document.body.classList.contains('rbp-nav-open'));
		});
		nav.addEventListener('click', function (e) {
			if (e.target.closest('a')) { setMenu(false); }
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') { setMenu(false); }
		});
	}

	// Copy install command.
	document.querySelectorAll('.rbp-copy').forEach(function (btn) {
		var label = btn.querySelector('span');
		var original = label ? label.textContent : '';
		btn.addEventListener('click', function () {
			var text = btn.getAttribute('data-copy');
			var done = function () {
				btn.classList.add('is-done');
				if (label) { label.textContent = btn.getAttribute('data-done'); }
				setTimeout(function () {
					btn.classList.remove('is-done');
					if (label) { label.textContent = original; }
				}, 2000);
			};
			if (navigator.clipboard && window.isSecureContext) {
				navigator.clipboard.writeText(text).then(done);
			} else {
				var ta = document.createElement('textarea');
				ta.value = text;
				ta.setAttribute('readonly', '');
				ta.style.position = 'absolute';
				ta.style.left = '-9999px';
				document.body.appendChild(ta);
				ta.select();
				try { document.execCommand('copy'); done(); } catch (err) { /* ignore */ }
				document.body.removeChild(ta);
			}
		});
	});

	// Privacy-friendly YouTube: nothing is loaded from YouTube until the visitor clicks.
	document.querySelectorAll('.rbp-video').forEach(function (box) {
		var btn = box.querySelector('.rbp-video__play');
		if (!btn) { return; }
		btn.addEventListener('click', function () {
			var id = box.getAttribute('data-yt');
			var iframe = document.createElement('iframe');
			iframe.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(id) + '?autoplay=1&rel=0';
			iframe.title = 'YouTube';
			iframe.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
			iframe.allowFullscreen = true;
			box.innerHTML = '';
			box.appendChild(iframe);
		});
	});

	// Header shadow once the page is scrolled.
	var header = document.getElementById('rbp-header');
	if (header) {
		var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 8); };
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}
}());
