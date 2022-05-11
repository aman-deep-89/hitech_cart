$(function() {
    $.extend(jQuery.validator.messages, {
        required: "Please enter value",
    });
    $.validator.addMethod('customphone', function (value, element) {
        return this.optional(element) || /^\d{3}\d{3}\d{4}$/.test(value);
    }, "Please enter a valid phone number");
    
    $('#save_data').validate({ 
        rules: {
            contact_number: 'customphone',
            contact_number2: 'customphone',
            email: {
                email:true
            }
        },    
          errorPlacement: function(error, element) {
             //console.log(element[0].type);
              if (element[0].type == 'checkbox') {
                  error.prependTo(element.parent().parent().parent());
              }
              else {
                  error.insertAfter(element);
              }
          },
        submitHandler: function(form) {         
          var $action=$('#save_data').attr("action");
          var val = $("button[type=submit][clicked=true]").val();
          $('#error').html("");
          $('#loader').show();
          $("button[type=submit]").attr("disabled","disabled");
          $.post($action,$('#save_data').serialize()+"&btn="+val,function(res) {
              if(res.success) {
                  if(res.returnUrl) window.location=res.returnUrl;
                  else {
                      location.reload();
                     /* window.scrollTo(0,1);
                      $('#message').html('Data saved successfully');
                      $('#save_data').trigger('reset');*/
                  }
              } else {
                  window.scrollTo(0,1);
                  $('#error').html(res.error).slideDown().delay(5000).slideUp();
                  $("button[type=submit]").attr("disabled",false);
              } 
              $('#loader').hide();
              $("button[type=submit]").show();
          },'json');
        }
       });
       $("form button[type=submit]").click(function() {
          $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
          $(this).attr("clicked", "true");
       });
});