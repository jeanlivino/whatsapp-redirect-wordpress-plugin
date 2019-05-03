var _wpp_phone_ = document.querySelector("#_wpp_phone_"),
  _wpp_phone = document.querySelector("#_wpp_phone");

var wpp_intlTelInput = window.intlTelInput(_wpp_phone_, {
  separateDialCode: true,
  utilsScript:
    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/15.0.2/js/utils.js", // just for formatting/placeholders etc
});

var handleintlTelInputChange = function() {
  _wpp_phone.value = wpp_intlTelInput.getNumber();
};

// listen to "keyup", but also "change" to update when the user selects a country
document
  .querySelector(".country-list")
  .addEventListener("mouseleave", handleintlTelInputChange);
_wpp_phone_.addEventListener("keyup", handleintlTelInputChange);
