$(document).ready(function()
{
$(".confirm").click(function(){

return confirm("Are you sure you want to delete this User?");

})	

 $("select").selectBoxIt({
 	autoWidth: false,
 	 
 	

 	});
 
//category view option
$(".cat h3").click(function()
{
	$(this).next('.ful-view').fadeToggle(200);
})

	$(".option span").click(function(){
		$(this).addClass("active").siblings("span").removeClass("active");

		if ($(this).data('view') === 'full') {
			$(".catigories .ful-view").fadeIn(200);
		}
		else
		{
			$(".catigories .ful-view").fadeOut(200);
		}
	})
})
