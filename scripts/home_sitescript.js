function start()
{
	$(document).ready(function() {
		console.log("Inside ready"); 
		$('.rightContent_wrapper_HP').scrollTop($('.rightContent_wrapper_HP')[0].scrollHeight);
		$('.createNewChannelIcon').click(function()
		{
			$('#createChannel').modal('show');
		});

		$(".message_body").mouseenter(function() {
			id=$(this).attr("id");
			offset=$(this).offset();

			$(".messageHoverButtons").css({'top': offset.top, 'left' : parseInt($(this).css("width"))})
			$(".messageHoverButtons").show();
			
			console.log(id);

		});
		// $(".message_body").mouseleave(function() {
		//   $(".messageHoverButtons").hide();
		// });

		$(".messageHoverButtons").hover(function(event) {
			event.stopPropagation();
			event.preventDefault();
		});

		$(".messageHoverButtons").click(function(event) {
			alert("clicked");
		});



	});
}
start();
