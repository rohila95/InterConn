function start()
{
	$(document).ready(function() {
		console.log("Inside ready"); 
		$('.rightContent_wrapper_HP').scrollTop($('.rightContent_wrapper_HP')[0].scrollHeight);
	});
}
start();
