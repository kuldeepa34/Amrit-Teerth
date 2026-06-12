/* Site-wide behaviour (loaded on every page) */
(function () {
    "use strict";

    // Elevate the top nav with a stronger shadow once the page is scrolled.
    const nav = document.getElementById("top-nav");
    if (nav) {
        const onScroll = function () {
            const scrolled = window.scrollY > 10;
            nav.classList.toggle("shadow-md", scrolled);
            nav.classList.toggle("shadow-sm", !scrolled);
        };
        window.addEventListener("scroll", onScroll, { passive: true });
        onScroll();
    }
})();
