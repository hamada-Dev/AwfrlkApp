<!DOCTYPE html>
<html>
 <head>
  <title>Ajax Autocomplete Textbox in Laravel using JQuery</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
   }

   li.selected {background:yellow}
a:hover{color:blue}
a {
  color:inherit;
  text-decoration: none;
 }
ul
{
    list-style-type: none;
}
  </style>
 </head>
 <body>
  <br />
  <div class="container box">
   <h3 align="center">Ajax Autocomplete Textbox in Laravel using JQuery</h3><br />
   
   <div class="form-group">
    <input type="text" name="country_name" id="country_name" class="form-control input-lg" placeholder="Enter Country Name" />
    <div id="countryList">
    </div>
   </div>
   {{ csrf_field() }}
  </div>
 </body>
</html>

<script>
$(document).ready(function(){

 $('#country_name').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.fetch') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
           $('#countryList').fadeIn();  
                    $('#countryList').html(data);
          }
         });
        }
        else
        {
            $('#countryList').fadeOut();
        }
    });

    $(document).on('click', 'li', function(){  
        $('#country_name').val($(this).text());  
        $('#countryList').fadeOut();  
    });


});

var li = $('li');

var liSelected;
$(window).keydown(function(e){
    if(e.which === 40){

        if(liSelected){
            alert();
            alert(li[0].innerHTML);
            liSelected.removeClass('selected');
            next = liSelected.next();
            if(next.length > 0){
                liSelected = next.addClass('selected');
            }else{
                alert();
                liSelected = li.eq(0).addClass('selected');
            }
        }else{
            liSelected = li.eq(0).addClass('selected');
        }
    }else if(e.which === 38){
        if(liSelected){
            liSelected.removeClass('selected');
            next = liSelected.prev();
            if(next.length > 0){
                liSelected = next.addClass('selected');
            }else{
                liSelected = li.last().addClass('selected');
            }
        }else{
            liSelected = li.last().addClass('selected');
        }
    }
});
</script>

