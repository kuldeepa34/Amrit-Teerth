/* Services page — FAQ accordion toggle */
(function () {
    "use strict";

    document.querySelectorAll("#faq .faq-question").forEach(function (header) {
        header.addEventListener("click", function () {
            const content = header.nextElementSibling;
            const icon = header.querySelector(".material-symbols-outlined");
            const isHidden = content.classList.toggle("hidden");

            if (icon) {
                icon.textContent = isHidden ? "expand_more" : "expand_less";
                icon.style.transition = "transform 0.3s ease";
                icon.style.transform = isHidden ? "rotate(0deg)" : "rotate(180deg)";
            }
        });
    });
})();
