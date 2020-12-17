$("#side-open").click(function() {
  $(".side-bar").animate({width: "toggle"});
  $( "#side-close" ).fadeIn( "slow" );
  $(this).hide();
});

$("#side-close").click(function() {
  $(".side-bar").animate({width: "toggle"});
  $( "#side-open" ).fadeIn( "slow" );
  $(this).hide();
});

$("#issub").click(function() {
  $("#selectpar").toggle();
});