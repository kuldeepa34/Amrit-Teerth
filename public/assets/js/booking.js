/* Booking page — repopulate the time-slot dropdown when the offering changes */
(function () {
    "use strict";

    const schedules = window.__offeringSchedules || {};
    const offeringSelect = document.getElementById("offering");
    const slotSelect = document.getElementById("slot");
    if (!offeringSelect || !slotSelect) {
        return;
    }

    function populateSlots() {
        const slots = schedules[offeringSelect.value] || [];
        slotSelect.innerHTML = "";
        slots.forEach(function (slot, index) {
            const option = document.createElement("option");
            option.value = String(index);
            option.textContent = slot.name + " — " + slot.time;
            slotSelect.appendChild(option);
        });
    }

    offeringSelect.addEventListener("change", populateSlots);
})();
