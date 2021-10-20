<script type="text/javascript">
  
  // $(".other_info").click( function( event ) {
    
  //   var $other_info = $(".change-continer2" ) ;
   
  //   if($(".change-continer2" ).css( "display") == 'block'){
  //       $other_info.hide();
  //   }else{
  //       $other_info.show();
  //   }
  
  // });
  $('.btn-change-pw').click(function(event) {
    var pwInput = $('#password');
    var pwInputConf = $('#password_confirmation');
    pwInput.val('').prop('disabled', true);
    pwInputConf.val('').prop('disabled', true);
    $('.pw-change-container').slideToggle(100, function() {
      pwInput.prop('disabled', function () {
         return ! pwInput.prop('disabled');
      });
      pwInputConf.prop('disabled', function () {
         return ! pwInputConf.prop('disabled');
      });
    });
  });
  $("input").keyup(function() {
    checkChanged();
  });
  $('input[type="file"]').change(function() {
    checkChanged();
  });
  
  $("select").change(function() {
    checkChanged();
  });
  
  $("textarea").keyup(function() {
    checkChanged();
  });

  function checkChanged() {
    var saveBtn = $(".btn-save");
    if(!$('input').val()){
      saveBtn.hide();
    }
    else {
      saveBtn.show();
    }
    
  }
</script>
