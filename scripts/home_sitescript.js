function start()
{
	var curMessageId='';
	$(document).ready(function() {
		console.log("Inside ready");
		$('.rightContent_wrapper_HP').scrollTop($('.rightContent_wrapper_HP')[0].scrollHeight);
		$('.createNewChannelIcon').click(function()
		{
			$('#createChannel').modal('show');
		});

		$(".message_body").mouseenter(function() {
            curMessageId = $(this).attr("id");
			offset=$(this).offset();

			$(".messageHoverButtons").css({'top': offset.top, 'left' : parseInt($(this).css("width"))})
			$(".messageHoverButtons").show();

			//console.log(curMessageId);

		});

		$(".loggedIn_user").click(function(){
			window.location.href = "ProfilePage.php";
		})

		// $(".message").mouseleave(function() {
		//   $(".messageHoverButtons").hide();
		// });

		// $(".messageHoverButtons").hover(function(event) {
		// 	event.stopPropagation();
		// 	event.preventDefault();
		// });

		$(".messageHoverButtons button").click(function(event) {
            event.preventDefault();
            $(".messageHoverButtons").hide();
            var emoji_idCLicked = $(this).attr("emojiid");
            var data= {};

            data["setReaction"] = "yes";
            data["message_id"] = curMessageId;
            data["emoji_id"] = emoji_idCLicked;

            $.post('./Controller.php',data,function (data){

                if($.trim(data).split("-")[0] == "success"){

                	var curMsgEle = $(".message_body#"+curMessageId);
					if($.trim(data).split("-")[1] == "inserted"){
						// Increase the count, the name logic is to be taken care yet
                        if (curMsgEle.find(".msg_reactionsec").find("[emojiid="+emoji_idCLicked+"]").length == 0 ){ //adding a reaction dynamically
                        	var curReactionToattach = $("<div>").addClass("emojireaction").attr("emojiid",emoji_idCLicked);
                        	var emojiPicToAppened = "";
                        	if(emoji_idCLicked == "1"){
                                emojiPicToAppened = "<i class=\"fa fa-thumbs-o-up\"></i><span class='reactionCount'>1</span>";
							}else{
                                emojiPicToAppened = "<i class=\"fa fa-thumbs-o-down\"></i><span class='reactionCount'>1</span>";
							}
                            curReactionToattach.append(emojiPicToAppened);
                            curMsgEle.find(".msg_reactionsec").append(curReactionToattach);

						}else{
                        	var curReactionEle = curMsgEle.find(".msg_reactionsec").find("[emojiid="+emoji_idCLicked+"]");
                            var curReactionCount = parseInt(curReactionEle.find("span.reactionCount").html());
                            curReactionEle.find("span.reactionCount").html(++curReactionCount);
						}
					}else{
						// Decrease the count, the name logic is to be taken care yet

                        var curReactionEle = curMsgEle.find(".msg_reactionsec").find("[emojiid="+emoji_idCLicked+"]");
                        var curReactionCount = parseInt(curReactionEle.find("span.reactionCount").html());

						if(curReactionCount <= 1 ){
                            curReactionEle.remove();
						}else{
                            curReactionEle.find("span.reactionCount").html(--curReactionCount);
						}

					}

                }else{
                    alert("You have reacted to the message, but the System didn't quite capture that. Please try again.");
                }
            });

		});



	});
}
start();
