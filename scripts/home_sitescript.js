var curMessageId='';
function start()
{
    $(document).ready(function() {
		console.log("Inside ready");
		$('.rightContent_wrapper_HP').scrollTop($('.rightContent_wrapper_HP')[0].scrollHeight);
		$('.createNewChannelIcon').click(function()
		{
			$('#createChannel').modal('show');
		});

        $(".inputMessage").keypress(function (e) {
            // if(e.which == 13 && !e.shiftKey) {
            //     $(this).closest("form").submit();
            //     e.preventDefault();
            // }

            if(e.which == 13 && !e.shiftKey) {
             		$(".messageEntrySpace_regularMsg_HP button").trigger("click");          
             }
        });

        $(document).on("mouseenter",".regularMessagesWrapper .message_body",function() {
            curMessageId = $(this).attr("id");
			offset=$(this).offset();
            $(".messageHoverButtons").find(".nonthumbbutts").show();
			//$(".messageHoverButtons").css({'top': offset.top, 'left' : parseInt($(this).css("width"))})
            $(".messageHoverButtons").css({'top': offset.top, 'left' : (offset.left)+$(this).width()-($(this).width()*30/100)})
			$(".messageHoverButtons").show();
			//console.log(curMessageId);
		});

        $(document).on("mouseenter",".threadMessageWrapper .message_body",function() {
            curMessageId = $(this).attr("id");
            offset=$(this).offset();
            $(".messageHoverButtons").find(".nonthumbbutts").hide();
            $(".messageHoverButtons").css({'top': offset.top, 'left' : (offset.left)+$(this).width()-($(this).width()*30/100)})
            $(".messageHoverButtons").show();
        });


        $(document).on("click",".threadMessageWrapper .message_time",function() {

			var curMessageId = $(this).parents(".message").find(".message_body").attr("id");
			$(".regularMessagesWrapper").find(".messagewithid_"+curMessageId).css("background-color","#dedddd").animate({"background-color": ""},1000,function () {
				$(this).removeAttr("style");
            });
        });


		$(".loggedIn_user").click(function(){
			var id= $('.loggedIn_user').attr('id');
			window.location.href = "ProfilePage.php?userid="+id;
		})

		// $(".message").mouseleave(function() {
		//   $(".messageHoverButtons").hide();
		// });

		// $(".messageHoverButtons").hover(function(event) {
		// 	event.stopPropagation();
		// 	event.preventDefault();
		// });

		// this registration takes care of thumbsup and thumbs down functionality
		$(".messageHoverButtons .thumbsbutt").click(function(event) {
            event.preventDefault();
            $(".messageHoverButtons").hide();
            var emoji_idCLicked = $(this).attr("emojiid");
            var data= {};

            data["setReaction"] = "yes";
            data["message_id"] = curMessageId;
            data["emoji_id"] = emoji_idCLicked;

            $.post('./Controller.php',data,function (data){

                if($.trim(data).split("-")[0] == "success"){

                	var curMsgEle = $(".messagewithid_"+curMessageId);
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


        // this registration takes care of creating a new thread
        $(document).on("click",".messageHoverButtons .threadbutt",function(e){
            e.preventDefault();

            if($(".threadMessageWrapper").css("display") == "block"){
				$(".threadMessageWrapper .eleToBeCleared").empty();
			}
			//$(".threadMessageWrapper").html("<h2>Clicked on the thread with messageId: "+curMessageId+"</h2>" );
            $(".messageHoverButtons").hide();
            $(".regularMessagesWrapper").removeClass("col-xs-12").addClass("col-xs-8");
			$(".messageEntrySpace_regularMsg_HP").css("width","56.7%");
            var curMsgEle = $(".regularMessagesWrapper").find(".messagewithid_"+curMessageId);
            var parentsUserPicEle = curMsgEle.parents(".messageSet").eq(0).find(".userPic").clone();
            var parentsMsgHeaderEle = curMsgEle.parents(".messageSet").eq(0).find(".message_header").clone();
                // section that prepares the head of the Message Thread
			var threadHeadParentMsgEle= $("<div class=\"row threadheadmsg messageSet\"></div>");

            threadHeadParentMsgEle.addClass("messagewithid_"+curMessageId);
			$(".threadhead_parentmessage").append(threadHeadParentMsgEle);


            threadHeadParentMsgEle.append(parentsUserPicEle);
            threadHeadParentMsgEle.append("<div class='col-xs-11 message'></div>");
            threadHeadParentMsgEle.find(".message").append(parentsMsgHeaderEle);
            threadHeadParentMsgEle.find(".message").append(curMsgEle.clone());

            var allPrevElements = curMsgEle.parents(".messageSet").eq(0).prevAll();
            for(var i=0;i < allPrevElements.length;i++){
            	if($(allPrevElements[i]).hasClass("dayDividerWrapper")){
                    threadHeadParentMsgEle.find(".message .message_time").prepend(" "+$(allPrevElements[i]).find(".dayDividerText").html()+" at ");
						break;
				}
			}
            $(".threadMessageWrapper").show();
        });

        // this registration takes care of showing the thread which has replies already
        $(document).on("click",".repliescount",function(e){
            e.preventDefault();
           // $(".threadMessageWrapper").html("<h2>Clicked on the thread with messageId: "+curMessageId+"</h2>" );
            $(".messageHoverButtons").hide();
            $(".regularMessagesWrapper").removeClass("col-xs-12").addClass("col-xs-8");
            $(".threadMessageWrapper").show();
            $(".messageEntrySpace_regularMsg_HP").css("width","56.7%");
        });

		$( ".createChannelBtn" ).on("click",function(e) {
			console.log("in clickkk");
			// e.preventDefault();
			var myForm = document.getElementById('createChannelForm');
		   	var formData = new FormData(myForm),
		   	convertedJSON = {},
		   	it = formData.entries(),
		   	n;
		   	while(n = it.next()) {
		      if(!n || n.done) break;
		      convertedJSON[n.value[0]] = n.value[1];
		    }
		    convertedJSON ['invites']=[9,11];
		    var stringData = JSON.stringify(convertedJSON);
	     	console.log(convertedJSON);
		    $.ajax({
		        url: './Controller.php',
		        type: 'post',
		        data: {'createChannel':stringData},
		        dataType: 'text',
		        success: function (data) {
		        	console.log(data);
		        	if($.trim(data).split(".")[0].split("-")[0]=="id")
		        	{
		        		$('#successModal .modal-body').html("<p> Channel created Successfully. </p>");
						$('#successModal').on('hidden.bs.modal', function (e) {  
							$('#successModal').off();
							window.location.href = "./index.php";
										
						});
						$("#successModal").modal("show");
						$("#successModal").css("z-index","1100");
						setTimeout(function() 
							{
								$('#successModal').modal('hide');
								window.location.href = "./index.php?channel="+$.trim(data).split(".")[0].split("-")[1];
							}, 4000);
		        	}
		        	else
		        	{
		        		$('#errorModal .modal-body').html("<p> Channel not created.</p>");
						$('#errorModal').on('hidden.bs.modal', function (e) {
							$('#errorModal').off();
						});
						$("#errorModal").modal("show");
						$("#errorModal").css("z-index","1100");
						setTimeout(function() {$('#errorModal').modal('hide');}, 4000);
		        		// $('.uniqueEmail').html('Email Id already exists. Try with different Id.');
		        	}
		        }
		    });
	 	});

        $(document).on("keypress",".messageentryspace_threadsection",function(e) {
                if(e.which == 13 && !e.shiftKey) {
                    e.preventDefault();
                    if (!$('.messageentryspace_threadsection form')[0].checkValidity()) {
                        $('#thread_MsgEntrySubmit').trigger('click');
                    }else{
                    	alert("write ajax post logic");
					}
                }
        });


	});
}
start();
