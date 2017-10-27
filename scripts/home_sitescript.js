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
        $(".inputMessage").keypress(function (e) {
            if(e.which == 13 && !e.shiftKey) {
                $(this).closest("form").submit();
                e.preventDefault();
            }
        });

		$(".message_body").mouseenter(function() {
            curMessageId = $(this).attr("id");
			offset=$(this).offset();

			$(".messageHoverButtons").css({'top': offset.top, 'left' : parseInt($(this).css("width"))})
			$(".messageHoverButtons").show();

			//console.log(curMessageId);

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


		// // var elt = $('input');
		// // elt.tagsinput({
		// //   itemValue: 'value',
		// //   itemText: 'text',
		// //   typeaheadjs: {
		// //     name: 'cities',
		// //     displayKey: 'text',
		// //     source: cities.ttAdapter()
		// //   }
		// // });
		// // elt.tagsinput('add', { "value": 1 , "text": "Amsterdam"   , "continent": "Europe"    });
		// // elt.tagsinput('add', { "value": 4 , "text": "Washington"  , "continent": "America"   });
		// // elt.tagsinput('add', { "value": 7 , "text": "Sydney"      , "continent": "Australia" });
		// // elt.tagsinput('add', { "value": 10, "text": "Beijing"     , "continent": "Asia"      });
		// // elt.tagsinput('add', { "value": 13, "text": "Cairo"       , "continent": "Africa"    });

		// var places = [
		//   {name: "New York"}, 
		//   {name: "Los Angeles"},
		//   {name: "Copenhagen"},
		//   {name: "Albertslund"},
		//   {name: "Skjern"}  
		// ];

		// $('.channelInvites').tagsinput({
		//   typeahead: {
		//     source: places.map(function(item) { return item.name }),
		//     afterSelect: function() {
		//     	this.$element[0].value = '';
		//     }
		//   }
		// });

        // this registration takes care of
        $(".messageHoverButtons .threadbutt").click(function(event) {
            event.preventDefault();
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

	});
}
start();
