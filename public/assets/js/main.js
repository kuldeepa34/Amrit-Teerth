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

    // Mobile profile dropdown (Login / account menu in the top nav).
    const profileToggle = document.getElementById("profile-toggle");
    const profileDropdown = document.getElementById("profile-dropdown");
    if (profileToggle && profileDropdown) {
        const close = function () {
            profileDropdown.classList.add("hidden");
            profileToggle.setAttribute("aria-expanded", "false");
        };

        profileToggle.addEventListener("click", function (e) {
            e.stopPropagation();
            const isOpen = !profileDropdown.classList.toggle("hidden");
            profileToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
        });

        document.addEventListener("click", function (e) {
            if (!profileDropdown.classList.contains("hidden") &&
                !profileDropdown.contains(e.target) &&
                !profileToggle.contains(e.target)) {
                close();
            }
        });

        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape") {
                close();
            }
        });
    }

    // Mobile slide-in navigation drawer.
    const navToggle = document.getElementById("nav-toggle");
    const navDrawer = document.getElementById("nav-drawer");
    const navBackdrop = document.getElementById("nav-backdrop");
    const navClose = document.getElementById("nav-close");

    if (navToggle && navDrawer && navBackdrop) {
        const openDrawer = function () {
            navDrawer.classList.remove("-translate-x-full");
            navBackdrop.classList.remove("opacity-0", "pointer-events-none");
            navToggle.setAttribute("aria-expanded", "true");
            document.body.classList.add("overflow-hidden");
        };
        const closeDrawer = function () {
            navDrawer.classList.add("-translate-x-full");
            navBackdrop.classList.add("opacity-0", "pointer-events-none");
            navToggle.setAttribute("aria-expanded", "false");
            document.body.classList.remove("overflow-hidden");
        };

        navToggle.addEventListener("click", openDrawer);
        navBackdrop.addEventListener("click", closeDrawer);
        if (navClose) {
            navClose.addEventListener("click", closeDrawer);
        }
        // Close after tapping a link, and on Escape.
        navDrawer.querySelectorAll("a").forEach(function (link) {
            link.addEventListener("click", closeDrawer);
        });
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape") {
                closeDrawer();
            }
        });
    }
})();
