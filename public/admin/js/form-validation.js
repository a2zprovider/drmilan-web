"use strict";
!(function () {
    window.Helpers.initCustomOptionCheck();
    const e = [].slice.call(document.querySelectorAll(".flatpickr-validation"));
    e &&
        e.forEach((e) => {
            e.flatpickr({ allowInput: !0, monthSelectorType: "static" });
        });
    const a = document.querySelectorAll(".needs-validation");
    Array.prototype.slice.call(a).forEach(function (e) {
        e.addEventListener(
            "submit",
            function (a) {
                e.checkValidity() ? '' : (a.preventDefault(), a.stopPropagation()), e.classList.add("was-validated");
            },
            !1
        );
    });
})();
