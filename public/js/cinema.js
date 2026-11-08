/* FilmKu - interaksi UI: navbar, sidebar admin, toast, modal hapus, loading state */
(function () {
    'use strict';

    // Navbar berubah solid saat halaman di-scroll
    var nav = document.querySelector('.cn-nav');
    if (nav) {
        var onScroll = function () { nav.classList.toggle('scrolled', window.scrollY > 40); };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

        var toggle = document.getElementById('cnToggle');
        var collapse = document.getElementById('cnCollapse');
        if (toggle && collapse) {
            toggle.addEventListener('click', function () {
                var open = collapse.classList.toggle('open');
                nav.classList.toggle('menu-open', open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        }
    }

    // Sidebar admin (mobile)
    var sidebar = document.getElementById('admSidebar');
    var admToggle = document.getElementById('admToggle');
    var admBackdrop = document.getElementById('admBackdrop');
    if (sidebar && admToggle) {
        admToggle.addEventListener('click', function () { sidebar.classList.toggle('open'); });
        if (admBackdrop) { admBackdrop.addEventListener('click', function () { sidebar.classList.remove('open'); }); }
    }

    // Toast: tutup otomatis
    function dismissToast(el) {
        el.classList.add('hide');
        setTimeout(function () { el.remove(); }, 320);
    }
    document.querySelectorAll('.cn-toast').forEach(function (el) {
        var btn = el.querySelector('.close');
        if (btn) { btn.addEventListener('click', function () { dismissToast(el); }); }
        setTimeout(function () { dismissToast(el); }, 5500);
    });

    // Modal konfirmasi hapus (satu modal dipakai bersama)
    var modalEl = document.getElementById('deleteModal');
    if (modalEl) {
        var form = modalEl.querySelector('form');
        var nameEl = modalEl.querySelector('[data-delete-name]');
        var noteEl = modalEl.querySelector('[data-delete-note]');
        modalEl.addEventListener('show.bs.modal', function (event) {
            var btn = event.relatedTarget;
            if (!btn) { return; }
            form.setAttribute('action', btn.getAttribute('data-action'));
            nameEl.textContent = btn.getAttribute('data-name') || 'data ini';
            noteEl.textContent = btn.getAttribute('data-note') || '';
            noteEl.style.display = btn.getAttribute('data-note') ? 'block' : 'none';
        });
    }

    // Loading state pada tombol submit
    document.querySelectorAll('form').forEach(function (f) {
        f.addEventListener('submit', function () {
            if (f.dataset.submitting === '1') { return; }
            var btn = f.querySelector('button[type="submit"][data-loading]');
            if (!btn) { return; }
            f.dataset.submitting = '1';
            // Disable setelah event submit selesai agar nilai form tetap terkirim
            setTimeout(function () {
                btn.disabled = true;
                btn.dataset.original = btn.innerHTML;
                btn.innerHTML = '<span class="btn-spinner"></span> ' + (btn.getAttribute('data-loading') || 'Memproses...');
            }, 0);
        });
    });

    // Tampil/sembunyi password
    document.querySelectorAll('[data-pw-toggle]').forEach(function (el) {
        el.addEventListener('click', function () {
            var input = document.querySelector(el.getAttribute('data-pw-toggle'));
            if (!input) { return; }
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            var icon = el.querySelector('i');
            if (icon) { icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye'; }
        });
    });

    // Pratinjau gambar sebelum upload
    document.querySelectorAll('input[type="file"][data-preview]').forEach(function (input) {
        input.addEventListener('change', function () {
            var target = document.querySelector(input.getAttribute('data-preview'));
            if (!target || !input.files || !input.files[0]) { return; }
            target.src = URL.createObjectURL(input.files[0]);
            target.style.display = 'block';
        });
    });
})();
