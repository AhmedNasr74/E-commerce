$(document).ready(function(){
    
   $(".confirm").click(function(){

return confirm("Are you sure ?");
});

 $("select").selectBoxIt({
 	autoWidth: false,
});
    
 $(".log-page h1 span").click(function(){
     $(this).addClass("active").siblings().removeClass("active");
     $(".log-page form").hide();
     $('.'+($(this).data('class'))).fadeIn()
 });
  
    $('.live-name').keyup(function(){
        $('.live-preview .caption h3').text($(this).val())
    });

        $('.live-desc').keyup(function(){
        $('.live-preview .caption .desc').text($(this).val())
    });
    
        $('.live-price').keyup(function(){
        $('.live-preview .gg').text($(this).val()+'$')
    });

});
