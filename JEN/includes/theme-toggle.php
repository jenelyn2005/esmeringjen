<button class="theme-toggle" type="button" data-theme-toggle aria-label="Switch to dark mode">
    <span data-theme-icon aria-hidden="true">&#9790;</span>
    <span data-theme-label>Dark mode</span>
</button>
<script>
(function () {
    const root = document.documentElement;
    const toggle = document.querySelector('[data-theme-toggle]');
    const icon = document.querySelector('[data-theme-icon]');
    const label = document.querySelector('[data-theme-label]');

    function applyTheme(theme) {
        const dark = theme === 'dark';
        root.dataset.theme = dark ? 'dark' : 'light';
        if (toggle) {
            toggle.setAttribute('aria-label', dark ? 'Switch to light mode' : 'Switch to dark mode');
        }
        if (icon) {
            icon.textContent = dark ? '\u2600' : '\u263e';
        }
        if (label) {
            label.textContent = dark ? 'Light mode' : 'Dark mode';
        }
    }

    applyTheme(localStorage.getItem('eventdesk-theme') || 'light');
    if (toggle) {
        toggle.addEventListener('click', function () {
            const nextTheme = root.dataset.theme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('eventdesk-theme', nextTheme);
            applyTheme(nextTheme);
        });
    }
}());
</script>
