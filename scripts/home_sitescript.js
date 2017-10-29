var curMessageId='';
var curThreadReplyId='';
function start()
{
	var usersData='';
	var usersChannelData='';
    $(document).ready(function() {
		console.log("Inside ready");
		$('.rightContent_wrapper_HP').scrollTop($('.rightContent_wrapper_HP')[0].scrollHeight);
		$('.createNewChannelIcon').click(function()
		{
			$('.channelInvites').select2('data', null);
			$('#createChannel').modal('show');

		});
		
		$('.invitations').click(function()
		{
			$('.existingChannelInvites').select2('data', null);
			$('#existingChannelInvites').modal('show');

		});
		var userid=$('.loggedIn_user').attr('id');
		var workspaceid=$('.loggedIn_workspace').attr('id');
		var channelid=$('.currentChannelTitle').attr('id');
		var getusersdata='{"userid":"'+userid+'","workspaceid":"'+workspaceid+'"}';
		
		console.log(getusersdata);
		$.post('./Controller.php',{"getWorkspaceUsers":getusersdata},function (data){
			usersData=$.parseJSON(data);
			$('.channelInvites').select2({
		    width: '100%',
		    allowClear: true,
		    multiple: true,
		    data: usersData
			});
		});

		var getUsersDataNotInChannel='{"channelid":"'+channelid+'","workspaceid":"'+workspaceid+'"}';
		$.post('./Controller.php',{"getChannelUsers":getUsersDataNotInChannel},function (data){
			// console.log(data);
				usersChannelData=data;
			if(!data.includes('fail'))
			{
				usersChannelData=$.parseJSON(data);
				$('.existingChannelInvites').select2({
			    width: '100%',
			    allowClear: true,
			    multiple: true,
			    data: usersData
				});
			}
		});

        $(".leftMenuContentWrapper_HP,.inputMessage,.headerSpace_HP,.messageentryspace_threadsection").hover(function (e) {
            $(".messageHoverButtons").hide();
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

            if($(this).parents(".messageSet").attr("class").includes("threadReplyWithId")){
                curThreadReplyId = $(this).parents(".messageSet").attr("threadreplyid");
                curMessageId = '';
            }

            offset=$(this).offset();
            $(".messageHoverButtons").find(".nonthumbbutts").hide();
            $(".messageHoverButtons").css({'top': offset.top, 'left' : (offset.left)+$(this).width()-($(this).width()*30/100)})
            $(".messageHoverButtons").show();
        });


        $(document).on("click",".threadMessageWrapper .message_time",function() {

			var curMessageId = $(this).parents(".message").find(".message_body").attr("id");
			$(".regularMessagesWrapper").find(".messagewithid_"+curMessageId).css("background-color","#dedddd").animate({"background-color": ""},2000,function () {
				$(this).removeAttr("style");
            });
        });


		$(".loggedIn_user").click(function(){
			var id= $('.loggedIn_user').attr('id');
			window.location.href = "ProfilePage.php?userid="+id;
		})


		// this registration takes care of thumbsup and thumbs down functionality
		$(".messageHoverButtons .thumbsbutt").click(function(event) {
            event.preventDefault();
            $(".messageHoverButtons").hide();
            var emoji_idCLicked = $(this).attr("emojiid");
            var data= {};
            var isToTreadMsg = false;
            data["setReaction"] = "yes";
            if(curMessageId == ''){
                data["message_id"] = curThreadReplyId;
                data["isToThreadReply"] = "yes";
                isToTreadMsg = true;
            }else{
                data["message_id"] = curMessageId;
            }

            data["emoji_id"] = emoji_idCLicked;

            $.post('./Controller.php',data,function (data){

                if($.trim(data).split("-")[0] == "success"){


                	var curMsgEle = "";

                    if(isToTreadMsg == true){
                        curMsgEle = $(".threadReplyWithId_"+curThreadReplyId);
                    }else{
                        curMsgEle = $(".messagewithid_"+curMessageId);
                    }

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
        $(document).on("click",".messageHoverButtons .threadbutt, .repliescount",function(e){
            e.preventDefault();

            if($(".threadMessageWrapper").css("display") == "block"){
				$(".threadMessageWrapper .eleToBeCleared").empty();
			}
			//$(".threadMessageWrapper").html("<h2>Clicked on the thread with messageId: "+curMessageId+"</h2>" );
            $(".messageHoverButtons").hide();
            $(".regularMessagesWrapper").removeClass("col-xs-12").addClass("col-xs-8");
			$(".messageEntrySpace_regularMsg_HP").css("width","56.7%");
            var curMsgEle = $(".regularMessagesWrapper").find(".messagewithid_"+curMessageId);
            $(".threadMessageWrapper .parentmsgidip_threadmsg").val(curMessageId);
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
			if(curMsgEle.find(".repliescount").length > 0 ){
                getAllThreadReplies(curMessageId);
            }

            $(".threadMessageWrapper").show();
        });

		$( ".createChannelBtn" ).on("click",function(e) {

			var ids=[];
			$.each(usersData,function(i,obj){

				$.each($(".select2-choices li div"),function(i,innerobj){

					if(obj['text']==innerobj['outerText'])
						ids.push(obj['id']);
				});
			});


			var myForm = document.getElementById('createChannelForm');
		   	var formData = new FormData(myForm),
		   	convertedJSON = {},
		   	it = formData.entries(),
		   	n;
		   	while(n = it.next()) {
		      if(!n || n.done) break;
		      convertedJSON[n.value[0]] = n.value[1];
		    }
		    convertedJSON ['invites']=ids;
		    convertedJSON['workspaceid']=$('.loggedIn_workspace').attr('id');
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
							
										
						});
						$("#successModal").modal("show");
						$("#successModal").css("z-index","1100");
						setTimeout(function() 
							{
								$('#successModal').modal('hide');
								window.location.href = "./HomePage.php?channel="+$.trim(data).split(".")[0].split("-")[1];
							}, 4000);
		        	}
		        	else
		        	{
		        		$('#errorModal .modal-body').html("<p>Channel name already exists. Try with different name.</p>");
						$('#errorModal').on('hidden.bs.modal', function (e) {
							$('#errorModal').off();
						});
						$("#errorModal").modal("show");
						$("#errorModal").css("z-index","1100");
						setTimeout(function() {$('#errorModal').modal('hide');}, 4000);
		        		// $('.uniqueChannel').html('Channel name already exists. Try with different name.');
		        	}
		        }
		    });
	 	});
		$( ".inviteExistingChannel" ).on("click",function(e) {

			var ids=[];
			$.each(usersData,function(i,obj){

				$.each($(".select2-choices li div"),function(i,innerobj){

					if(obj['text']==innerobj['outerText'])
						ids.push(obj['id']);
				});
			});

		   	var convertedJSON = {};
		    convertedJSON ['ids']=ids;
		    convertedJSON['channelid']=channelid;
		    var stringData = JSON.stringify(convertedJSON);
	     	console.log(convertedJSON);
		    $.ajax({
		        url: './Controller.php',
		        type: 'post',
		        data: {'inviteToChannel':stringData},
		        dataType: 'text',
		        success: function (data) {
		        	console.log(data);
		        	if(data.includes('success'))
		        	{
		        		$('#successModal .modal-body').html("<p> Members invited Successfully. </p>");
						$('#successModal').on('hidden.bs.modal', function (e) {  
							$('#successModal').off();
							
										
						});
						$("#successModal").modal("show");
						$("#successModal").css("z-index","1100");
						setTimeout(function() 
							{
								$('#successModal').modal('hide');
								// window.location.href = "./HomePage.php?channel="+$.trim(data).split(".")[0].split("-")[1];
							}, 4000);
		        	}
		        	else
		        	{
		        		$('#errorModal .modal-body').html("<p>Unable to add Members. Try again.</p>");
						$('#errorModal').on('hidden.bs.modal', function (e) {
							$('#errorModal').off();
						});
						$("#errorModal").modal("show");
						$("#errorModal").css("z-index","1100");
						setTimeout(function() {$('#errorModal').modal('hide');}, 4000);
		        		// $('.uniqueChannel').html('Channel name already exists. Try with different name.');
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
                            var serializedArr = $('.messageentryspace_threadsection form').serializeArray();
                            var convertedJSON ={};

							$.each(serializedArr , function( key, value ) {
                                convertedJSON[value["name"]]= value["value"];
							});

                            var stringData = JSON.stringify(convertedJSON);
                            console.log(convertedJSON);
                            $.ajax({
                                url: './Controller.php',
                                type: 'post',
                                data: {'createThreadReply':stringData},
                                dataType: 'text',
                                success: function (data) {
									if(data.split("-")[0]=="success"){
									    $(".messageentryspace_threadsection textarea").val("");
                                        getAllThreadReplies($(".parentmsgidip_threadmsg").val());
                                    }
                                }
                            });

					}
                }
        });

        $(document).on("click",".closeHover",function(e) {
            $(".regularMessagesWrapper").removeClass("col-xs-8").addClass("col-xs-12");
            $(".threadMessageWrapper").hide();
            $(".messageEntrySpace_regularMsg_HP").css("width", "86.7%");
            $(".messageHoverButtons").hide();
            $(".eleToBeCleared").empty();
        });



	});
}
start();

// gets all the the thread replies, by just needing the parentmsgID
function getAllThreadReplies(parentMsgID){
    var convertedJSON ={};
    convertedJSON["parentmessageid"] = parentMsgID;

    var stringData = JSON.stringify(convertedJSON);
    console.log(convertedJSON);
    $.ajax({
        url: './Controller.php',
        type: 'post',
        data: {'getThreadMessages':stringData},
        dataType: 'text',
        success: function (data) {
            console.log(data);
            if(!data.includes("fail")){

                var jsonArrRes = $.parseJSON(data);
                // to update the number of replies in case if changed
				if(jsonArrRes.length > 0 && $(".messagewithid_"+parentMsgID).find(".repliescount").length < 1){
                    $(".messagewithid_"+parentMsgID).find(".msg_reactionsec").append('<div class="repliescount" title="view thread"><a href="#"><span>'+jsonArrRes.length +'</span> replies</a></div>');
				}else {
					$(".messagewithid_"+parentMsgID).find(".repliescount span").html(jsonArrRes.length);
				}


                var threadReplysUIStr="";
                $(".threadedreplies_content").empty();
                $.each(jsonArrRes,function(indx,obj){

                    var defPictureDet = buildDefaultPicture(obj['user_id'],obj['first_name'],obj['last_name']);

                    var curThreadReplyEle = $('<div class="row messageSet"><div class="col-xs-1 userPic"><div class="defUserPic" style="background-color: '+defPictureDet.split("-")[0] +';">'+ defPictureDet.split("-")[1]+'</div></div></div>');

                    curThreadReplyEle.addClass("threadReplyWithId_"+obj['id']);
                    curThreadReplyEle.attr("threadReplyId",obj['id']);
                    $(".threadedreplies_content").append(curThreadReplyEle);
                    if(obj['profile_pic'] != ""){
                        curThreadReplyEle.find(".defUserPic").addClass("profilePic").html("");
                        curThreadReplyEle.find(".profilePic").css("background-image","url("+obj['profile_pic']+")");
                    }


                    var curThRepMsgCont=$('<div class="col-xs-11 message"><div class="message_header"><b>'+ obj["first_name"]+' '+obj["last_name"] +'</b><span class="message_time"> '+ obj["created_at"]+ '</span></div><div class="message_body"> <div class="msg_content">'+obj["content"]+'</div><div class="msg_reactionsec"></div></div>');
                    var emojiElementsStr= "";
                    $.each(obj['emojis'], function (emojiIndx, emojiObj) {
                        emojiElementsStr += "<div class=\"emojireaction\" emojiid='"+emojiObj['emoji_id'] + "'><i class='"+emojiObj['emoji_pic'] +"'></i><span class=\"reactionCount\">"+ emojiObj['count']+"</span></div>"
                    });
                    curThRepMsgCont.find(".msg_reactionsec").append(emojiElementsStr);


                    $(".threadedreplies_content").find(".threadReplyWithId_"+obj['id']).append(curThRepMsgCont);


                });




            }else{
            	alert("something went wrong while fetching the Thread Replies.")
			}
        }
    });

    function buildDefaultPicture( userID,fName,lName){
        var shortName ="";
        if(lName==""){
            shortName= fName.split("")[0]+fName.split("")[1];
        }else{
            shortName= fName.split("")[0]+lName.split("")[0];
        }
        var defUserPicBGColorArr = ['#3F51B5','#2196F3','#00BCD4','#CDDC39','#FF5722'];
        return   defUserPicBGColorArr[parseInt(userID)%5]+"-"+shortName.toUpperCase();
    }
}
