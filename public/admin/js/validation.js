$(function() {

	$("form").attr("novalidate", "novalidate");
    $.fn.is_valid = (function() {
		let parent = form = $(this);
		// console.log(form);
		if(!parent.is("form")) {
			form = parent.closest("form");
		}
        form.addClass("was-validated");
		
        parent.find(".invalid-feedback").remove();
        parent.find(".is-invalid").removeClass("is-invalid");

        parent.find(".form-group").removeClass("has-danger");

        var errorFlag = false;



        // RegEx Variables
        nam     = /^[a-zA-Z ]+$/;

        tel     = /^\d+$/;

        mob     = /^[0-9]{10}$/;

        email   = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

        stpas   = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;

        parent.find("input.mobile").each(function() {
            if( !mob.test( $(this).val() ) && $(this).val() != "" ) {
				console.log("Mobile error.");

                $(this).addClass("is-invalid");
                $(this).closest(".form-group").append('<div class="invalid-feedback">Please enter only 10 digit numeric value.</div>');
                errorFlag = true;
            }
        });

        parent.find("input.name").each(function() {
            if( !nam.test( $(this).val() ) ) {
				console.log("Name error.");

                $(this).addClass("is-invalid");
                $(this).closest(".form-group").append('<div class="invalid-feedback">Please don\'t include any special characters or numeric value.</div>');
                errorFlag = true;
            }
        });

        parent.find("input, select, textarea").each(function() {
            if($(this).prop("required") && $(this).val() == "") {
				console.log("required error.");

                $(this).addClass("is-invalid");
                $(this).closest(".form-group").append('<div class="invalid-feedback">Please fill required field.</div>');
                errorFlag = true;
            }

            if($(this).attr("type") == "tel" && !tel.test($(this).val()) && !$(this).hasClass("mobile") && $(this).val() != "") {
				console.log("number error.");

                $(this).addClass("is-invalid");
                $(this).closest(".form-group").append('<div class="invalid-feedback">Please enter only numeric value.</div>');
                errorFlag = true;

            }



            if($(this).attr("type") == "email" && $(this).val() != "" && !email.test($(this).val())) {
				console.log("email error.");

                $(this).addClass("is-invalid");
                $(this).closest(".form-group").append('<div class="invalid-feedback">Please enter valid Email ID.</div>');
                errorFlag = true;
            }


        });

        if(parent.find(".password").val() != parent.find(".confirm-password").val()) {
			console.log("Password error.");

            $(this).addClass("is-invalid");
            $(this).find(".confirm-password").closest(".form-group").append("<div class='invalid-feedback'>Confirm password didn't match.</div>");
            errorFlag = true;
        }

        return !errorFlag;
    });

    $("form").on("submit", function(e) {

        is_valid = $(this).is_valid();

        if(!is_valid) {

            e.preventDefault();

        }



    });

});
