jQuery(document).ready(function ($) {

    $.validator.addMethod("phoneno", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 &&
                phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
    }, "<br />Please Specify a Valid Phone Number");

    $.validator.addMethod("numeric", function (value, element) {
        return this.optional(element) || /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/.test(value);
    }, "Enter Only Numeric Value");

    $.validator.addMethod("alpha", function (value, element) {
        return this.optional(element) || /^[a-zA-Z]*$/.test(value);
    }, "Enter Only Alphabet Value");
	
	$.validator.addMethod("space", function (value, element) {
        return this.optional(element) || /^\S.*$/.test(value);
    }, "Please Enter Proper Value");

    $.validator.addMethod("email", function (value, element) {
        return this.optional(element) || /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
    }, 'Please Enter a Valid Email Address.');

        $("#stripe-payment-frm").validate({
            rules: {
                fname: {
                    required: true,
                    alpha: true
                },
                lname: {
                    required: true,
                    alpha: true
                },
                email: {
                    required: true,
                    email: true
                },
                phone_no: {
                    required: true,
                    phoneno: true
                },
                address: {
					required: true,
					space: true
				},
                country: {
					required: true,
					space: true,
					alpha: true
				},
                state: {
					required: true,
					space: true,
					alpha: true
				},
                city: {
					required: true,
					space: true,
					alpha: true
				},
                zipcode: {
                    required: true,
					space: true
                },
                amount: {
                    required: true,
                    numeric: true,
                    min:1
                },
				end_date_recurring: {
                    required: true
                }
            },
            messages: {
                fname: {
                    required: "Please Enter First Name"
                },
                lname: {
                    required: "Please Enter Last Name"
                },
                email: {
                    required: 'Please Enter Email',
                    email: 'Please Enter Valid Email'
                },
                phone_no: {
                    required: 'Please Enter Phone No',
                    phoneno: 'Please Enter Valid Phone No'
                },
                address: {
                    required: 'Please Enter Address'
                },
                country: {
                    required: 'Please Enter Country'
                },
                state: {
                    required: 'Please Enter State'
                },
                city: {
                    required: 'Please Enter City'
                },
                zipcode: {
                    required: 'Please Enter Pincode'
                },
                amount: {
                    required: "Please Enter Amount"
                },
				end_date_recurring: {
                    required: "Please Enter end date"
                },
            }
        });
        
        jQuery(".tsttt").click(function () {
            if (jQuery('#stripe-payment-frm').valid()) {
                jQuery( ".stripe_popup" ).trigger( "click" );
            } else {
                return false;
            }
        });
		
		jQuery(".cal-icon").click(function () 
		{
            jQuery( "#recurring_end_date" ).trigger( "click" );
        });
		
		var dateToday = new Date();
		var yrRange = dateToday.getFullYear() + ":" + (dateToday.getFullYear() + 5);
		jQuery("#recurring_end_date").datepicker({
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true,
				yearRange: yrRange,
				minDate: 0,
			});
});
function rpadts_hiddenEndDates()
{
document.getElementById("recurringEndDate").style.display="none";
if(document.getElementById("end_date_recurring") != null)
{
document.getElementById("end_date_recurring").value="";
}
}

function rpadts_showEndDates()
{
document.getElementById("recurringEndDate").style.display="block";
}

function rpadts_show_datepicker(cont)
{
  var count = cont;
  if(count=='1m' || count=='3m' || count=='6m' || count=='12m')
  {
	document.getElementById("recurringEndDate").style.display="block";
  }
  else
  {
    document.getElementById("recurringEndDate").style.display="none";
	if(document.getElementById("end_date_recurring") != null)
	{
	document.getElementById("end_date_recurring").value="";
	}
  }
}