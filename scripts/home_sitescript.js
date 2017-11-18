var curMessageId='';
var curThreadReplyId='';
function start()
{
	var usersData='';
	var usersChannelData='';
    $(document).ready(function() {
        $("#wholebody_loader").hide();
        console.log("Inside ready");
		// $('[data-toggle="tooltip"]').tooltip();
		var userid=$('.loggedIn_user').attr('id');
		var workspaceid=$('.loggedIn_workspace').attr('id');
		var channelid=$('.currentChannelTitle').attr('id');
		var getusersdata='{"userid":"'+userid+'","workspaceid":"'+workspaceid+'"}';


		/* logic that takes care of code snippet and imge upload is taken care here */

        $(document).on("click",".dropupMenuRegularMsgs li",function(event){
        	event.preventDefault();
        	if($(this).attr("intent") == "codesnipp"){

                $("#sendSnippetModal").modal("show");

            }else if($(this).attr("intent") == "localimage"){
                $("#sendLocalImgModal").modal("show");

            }
		});

		// handler for sendSnippet butt click
        $(document).on("click",".sendSnippetButt",function(event) {
				// this following  hidden ip value will be set to  0--normal,  1--image,2--code
			$(".messageEntrySpace_regularMsg_HP").find(".isSplMsgHiddenIP").val("2");
            $(".messageEntrySpace_regularMsg_HP .inputMessage").val($(".textAreaInCodeSnipp").val());
            $(".messageEntrySpace_regularMsg_HP .codeSnippTypeHiddenIP").val( $("#codeSnipSelBox").val());
            $(".messageEntrySpace_regularMsg_HP button").trigger("click");
        });





		// to make an ajax call on scroll top
        $(".rightContent_wrapper_HP").scroll(function(){
            if($(".rightContent_wrapper_HP").scrollTop()== 0){
               if($(".oldMessages").length > 0 ){
                   $(".oldMessages").trigger("click");
               }
            }

        });

		$(document).on("click",".channelsContainer_menu_HP a, .archieveChannelsContainer_menu_HP a",function(){
            $("#wholebody_loader").show();
		});

		
		$('.rightContent_wrapper_HP').scrollTop($('.rightContent_wrapper_HP')[0].scrollHeight);
		$('body').click(function(){
			$(".resSuggDiv").remove();
		});
		$(document).on("click",".oldMessages",function(){
			var queryStr='{"channelid":"'+channelid+'","lastmessageid":"'+$(this).attr('id')+'"}';
			// console.log(queryStr);
            $("#wholebody_loader").show();
			$.post('./Controller.php',{"retrieveOldMessages":queryStr},function (data){
                $("#wholebody_loader").hide();
				$('.oldMessages').remove();
				$('.messagesList').prepend(data);
			
			});
		});
		$(document).on("click",".deletebutt",function(){
			var postDataObj={};
			if(curMessageId == ""){
                postDataObj={"deleteThreadedMessage":curThreadReplyId,"parentMessageID":$(".threadReplyWithId_"+curThreadReplyId).parents(".threadedContent").find(".threadheadmsg .message_body").attr("id")};
			}else{
                postDataObj={"deleteMessage":curMessageId};
			}

            $("#wholebody_loader").show();
            $.post('./Controller.php',postDataObj,function (data){
                $("#wholebody_loader").hide();

                if(data.includes('success'))
				{
                    var successStr = "<p> Thread Reply deleted Successfully. </p>";
					if(postDataObj["deleteThreadedMessage"] == undefined){
                   		 successStr = "<p> Message deleted Successfully. </p>";
					}
					$('#successModal .modal-body').html(successStr);
					$('#successModal').on('hidden.bs.modal', function (e) {
						$('#successModal').off();
						$("#wholebody_loader").show();
                        window.location.href = "./HomePage.php?channel="+channelid;

					});
					$("#successModal").modal("show");
					$("#successModal").css("z-index","1100");
					setTimeout(function()
						{
							$('#successModal').modal('hide');
                            $("#wholebody_loader").show();
                            window.location.href = "./HomePage.php?channel="+channelid;
						}, 2000);
				}
				else
				{
					$('#errorModal .modal-body').html("<p> Unable to delete message. </p>");
					$('#errorModal').on('hidden.bs.modal', function (e) {
						$('#errorModal').off();
					});
					$("#errorModal").modal("show");
					$("#errorModal").css("z-index","1100");
					setTimeout(function() {$('#errorModal').modal('hide');}, 2000);
				}

			});
		});
		$('.archieveButton').click(function(){
            $("#wholebody_loader").show();
            $.post('./Controller.php',{"archieveChannel":channelid},function (data){
                $("#wholebody_loader").hide();

                if(data.includes('success'))
				{
					$('#successModal .modal-body').html("<p> Channel Archieved Successfully. </p>");
					$('#successModal').on('hidden.bs.modal', function (e) {
						$('#successModal').off();
                        $("#wholebody_loader").show();
                        window.location.href = "./HomePage.php?channel="+channelid;

					});
					$("#successModal").modal("show");
					$("#successModal").css("z-index","1100");
					setTimeout(function()
						{
							$('#successModal').modal('hide');
                            $("#wholebody_loader").show();
                            window.location.href = "./HomePage.php?channel="+channelid;
						}, 2000);
				}
				else
				{
					$('#errorModal .modal-body').html("<p> Channel not Archieved. </p>");
					$('#errorModal').on('hidden.bs.modal', function (e) {
						$('#errorModal').off();
					});
					$("#errorModal").modal("show");
					$("#errorModal").css("z-index","1100");
					setTimeout(function() {$('#errorModal').modal('hide');}, 2000);
				}
				
			});
		});
		$('.unarchieveButton').click(function(){
            $("#wholebody_loader").show();
            $.post('./Controller.php',{"unArchieveChannel":channelid},function (data){
                $("#wholebody_loader").hide();

                if(data.includes('success'))
				{
					$('#successModal .modal-body').html("<p> Channel UnArchieved Successfully. </p>");
					$('#successModal').on('hidden.bs.modal', function (e) {
						$('#successModal').off();
                        $("#wholebody_loader").show();
                        window.location.href = "./HomePage.php?channel="+channelid;

					});
					$("#successModal").modal("show");
					$("#successModal").css("z-index","1100");
					setTimeout(function()
						{
							$('#successModal').modal('hide');
                            $("#wholebody_loader").show();
                            window.location.href = "./HomePage.php?channel="+channelid;
						}, 2000);
				}
				else
				{
					$('#errorModal .modal-body').html("<p> Channel not UnArchieved. </p>");
					$('#errorModal').on('hidden.bs.modal', function (e) {
						$('#errorModal').off();
					});
					$("#errorModal").modal("show");
					$("#errorModal").css("z-index","1100");
					setTimeout(function() {$('#errorModal').modal('hide');}, 2000);
				}
				
			});
		});
		$('input.userProfileSearchInput').keyup(function(){
			$(".resSuggDiv").remove();
			var inputStr = $(this).val().trim();
			var searchInput=$(this);
			var inputData='{"inputString":"'+inputStr+'","workspaceid":"'+workspaceid+'"}';
            $("#wholebody_loader").show();
            $.post('./Controller.php',{"getWorkspaceUsersByInput":inputData},function (data){
                $("#wholebody_loader").hide();

                // console.log(data);
				if(data!='[]')
				{
					var usersData=$.parseJSON(data);
					var listGroupDiv = $("<div class='resSuggDiv'><ul class='list-group'></ul></div>");
					var liComp = "";
					$.each(usersData,function(i,obj){
						liComp += '<li class="list-group-item userSuggList" id="'+obj['user_id'] +'">'+obj['name']+'</li>';
						
					});
					listGroupDiv.find("ul").append(liComp);
	                $("body").append(listGroupDiv);
	                var eleWidth=$('.left-inner-addon').width();
	                listGroupDiv.css({
	                 	position:'absolute',
	                  	top:searchInput.offset().top+31,
	                    left:searchInput.offset().left,
	                    width:$('.left-inner-addon').width()
	                });
	                $(".userSuggList").click(function(){
	                	$('.userProfileSearchInput').val($(this).html());
	                	$(".resSuggDiv").remove();
                        $("#wholebody_loader").show();
                        window.location.href = "ProfilePage.php?userid="+$(this).attr("id");
	                });
           		}
			});

		});


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


        /* Below click registration for channel members editing */
        $(document).on('click','.channelMemebersEditButt',function(){
        	if(!isAdmin){
				return;
			}
        	if($(this).parents(".headerAddon_HP").hasClass("archivedChannel")){
        		return;
			}
            $("#channelMembershipEditingPUP .curSelChannel").html($(".currentChannelTitle span").html());
            $('.existingChannelInvites').select2('data', null);
            $('#channelMembershipEditingPUP').modal('show');

        });
		

		console.log(getusersdata);
        $("#wholebody_loader").show();

        $.post('./Controller.php',{"getWorkspaceUsers":getusersdata},function (data){
            $("#wholebody_loader").hide();

            usersData=$.parseJSON(data);
			$('.channelInvites').select2({
		    width: '100%',
		    allowClear: true,
		    multiple: true,
		    data: usersData
			});
		});

		var getUsersDataNotInChannel='{"channelid":"'+channelid+'","workspaceid":"'+workspaceid+'"}';
        $("#wholebody_loader").show();
        $.post('./Controller.php',{"getChannelUsers":getUsersDataNotInChannel},function (data){
            $("#wholebody_loader").hide();

            // console.log(data);
				// usersChannelData=$.parseJSON(data);
			if(!data.includes('fail'))
			{
				usersChannelData=$.parseJSON(data);
				$('.existingChannelInvites').select2({
			    width: '100%',
			    allowClear: true,
			    multiple: true,
			    data: usersChannelData
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
            $(".messageHoverButtons").css({'top': offset.top, 'left' : (offset.left)+$(this).width()-($(this).width()*50/100)})
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
            $(".messageHoverButtons").css({'top': offset.top, 'left' : (offset.left)+$(this).width()-($(this).width()*50/100)})
            $(".messageHoverButtons").show();
        });


        $(document).on("click",".threadheadmsg .msg_content",function() {

					var curMessageId = $(this).parents(".message").find(".message_body").attr("id");
					$(".regularMessagesWrapper").find(".messagewithid_"+curMessageId).css("background-color","#dedddd").animate({"background-color": ""},2000,function () {
							$(this).removeAttr("style");
		          });

				// code segment to make it scroll to the corresponding main message
            $(".rightContent_wrapper_HP").animate({scrollTop: $(".rightContent_wrapper_HP").scrollTop() + ($('.regularMessagesWrapper .messagewithid_'+curMessageId).parents(".messageSet").offset().top - $(".rightContent_wrapper_HP").offset().top)});



        });


		$(".loggedIn_user").click(function(){
			var id= $('.loggedIn_user').attr('id');
            $("#wholebody_loader").show();
            window.location.href = "ProfilePage.php?userid="+id;
		});

        $(document).on("click",".message_header",function() {
                var id= $(this).attr('userid');
            $("#wholebody_loader").show();
            window.location.href = "ProfilePage.php?userid="+id;
        });



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
            $("#wholebody_loader").show();
            $.post('./Controller.php',data,function (data){
                $("#wholebody_loader").hide();

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
            $(".message").addClass('messageThread');
            if($(".threadMessageWrapper").css("display") == "block"){
				$(".threadMessageWrapper .eleToBeCleared").empty();
			}
			//$(".threadMessageWrapper").html("<h2>Clicked on the thread with messageId: "+curMessageId+"</h2>" );
            $(".messageHoverButtons").hide();
            $(".regularMessagesWrapper").removeClass("col-xs-12").addClass("col-xs-8");
			$(".messageEntrySpace_regularMsg_HP").css("width","51.7%");
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
	     	$("#wholebody_loader").show();
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
                            $("#wholebody_loader").show();
                            window.location.href = "./HomePage.php?channel="+$.trim(data).split(".")[0].split("-")[1];

						});
                        $("#wholebody_loader").hide();
						$("#successModal").modal("show");
						$("#successModal").css("z-index","1100");
						setTimeout(function()
							{
								$('#successModal').modal('hide');
                                $("#wholebody_loader").show();
                                window.location.href = "./HomePage.php?channel="+$.trim(data).split(".")[0].split("-")[1];
							}, 2000);
		        	}
		        	else if($.trim(data).split("-")[0]=="fail")
		        	{
		        		$('#errorModal .modal-body').html("<p>"+$.trim(data).split("-")[1]+"</p>");
						$('#errorModal').on('hidden.bs.modal', function (e) {
							$('#errorModal').off();
						});
						$("#errorModal").modal("show");
						$("#errorModal").css("z-index","1100");
						setTimeout(function() {$('#errorModal').modal('hide');}, 2000);
		        		// $('.uniqueChannel').html('Channel name already exists. Try with different name.');
		        	}
		        }
		    });
	 	});
		$( ".inviteExistingChannel, .saveChangesChannelMemShipEdit" ).on("click",function(e) {

			var ids=[];
			$.each(usersData,function(i,obj){

				$.each($(".select2-choices li div"),function(i,innerobj){

					if(obj['text']==innerobj['outerText'])
						ids.push(obj['user_id']);
				});
			});

		   	var convertedJSON = {};
		    convertedJSON ['ids']=ids;
		    convertedJSON['channelid']=channelid;
		    var stringData = JSON.stringify(convertedJSON);
	     	console.log(convertedJSON);
            $("#wholebody_loader").show();

            $.ajax({
		        url: './Controller.php',
		        type: 'post',
		        data: {'inviteToChannel':stringData},
		        dataType: 'text',
		        success: function (data) {
		        	console.log(data);
                    $("#wholebody_loader").hide();
		        	if(data.includes('success'))
		        	{
		        		$('#successModal .modal-body').html("<p> Members invited Successfully. </p>");
						$('#successModal').on('hidden.bs.modal', function (e) {
							$('#successModal').off();
							location.reload();

						});
						$("#successModal").modal("show");
						$("#successModal").css("z-index","1100");
						setTimeout(function()
							{
								$('#successModal').modal('hide');
                                location.reload();

							}, 2000);
		        	}
		        	else if($.trim(data).split("-")[0]=="fail")
		        	{
		        		$('#errorModal .modal-body').html("<p>"+$.trim(data).split("-")[1]+"</p>");
						$('#errorModal').on('hidden.bs.modal', function (e) {
							$('#errorModal').off();
						});
						$("#errorModal").modal("show");
						$("#errorModal").css("z-index","1100");
						setTimeout(function() {$('#errorModal').modal('hide');}, 2000);
		        		// $('.uniqueChannel').html('Channel name already exists. Try with different name.');
		        	}
		        }
		    });
	 	});


		// handles the removing of user from a channel
		$(document).on('click','.existingChannelMembersWrapper .removeUserFromChannel' ,function(){
			var userLIToRemove = $(this).parents("li");
            var ids=[];
            ids.push(parseInt(userLIToRemove.attr('userid')));
            var convertedJSON = {};
            convertedJSON ['ids']=ids;
            convertedJSON['channelid']=channelid;
            var stringData = JSON.stringify(convertedJSON);
            console.log(convertedJSON);
            $("#wholebody_loader").show();
            $.ajax({
                url: './Controller.php',
                type: 'post',
                data: {'removeFromChannel':stringData},
                dataType: 'text',
                success: function (data) {
                    console.log(data);
                    $("#wholebody_loader").hide();
                    if(data.includes('success'))
                    {
                        /* now this removed users li has to be removed and his data set to be added in the select 2 list */
                        $('.existingChannelInvites').select2('data', null);


						var userTobeAddedToSuggList = {};
						var curUserFullnumber = userLIToRemove.find(".userfullname").html();
                        userTobeAddedToSuggList['id'] = userLIToRemove.attr('userid');
						userTobeAddedToSuggList['first_name'] = curUserFullnumber.split(" ")[0];
						userTobeAddedToSuggList['last_name'] = curUserFullnumber.split(" ")[1];
						userTobeAddedToSuggList['profile_pic'] = "./images/"+ userLIToRemove.attr('userid')+".png";
						userTobeAddedToSuggList['text'] = curUserFullnumber;
						if(usersChannelData == ""){
                            usersChannelData = [];
						}
						usersChannelData.push(userTobeAddedToSuggList);

                         /* logic to remove the array element
                         	$.each(usersChannelData, function(i){
                           if(usersChannelData[i].id === userLIToRemove.attr('userid')) {
								   usersChannelData.splice(i,1);
								   return false;
							   }
							 });
                         */

                        $('.existingChannelInvites').select2({
                            width: '100%',
                            allowClear: true,
                            multiple: true,
                            data: usersChannelData
                        });
                        // the fll0wing lines to changes few html element details like member count, memberslist in tile etc
                        userLIToRemove.remove();
                        $(".headerAddon_HP .membersCount").html(parseInt($(".headerAddon_HP .membersCount").html())-1);
                        var titleMemList = "";
                        $(".existingChannelMemUL li").find(".userfullname").each(function(){
                            titleMemList += $(this).html().split(" ")[0]+",";
                        });

                        $(".headerAddon_HP .membersCount").attr("title",titleMemList);

                        $('#successModal .modal-body').html("<p> Member Removed Successfully. </p>");
                        $("#successModal").modal("show");
                        $("#successModal").css("z-index","2100");
                        setTimeout(function()
                        {
                            $('#successModal').modal('hide');
                        }, 1000);


                    }
                    else if($.trim(data).split("-")[0]=="fail")
                    {
                        $('#errorModal .modal-body').html("<p>"+$.trim(data).split("-")[1]+"</p>");
                        $("#errorModal").modal("show");
                        $("#errorModal").css("z-index","2100");
                        setTimeout(function() {$('#errorModal').modal('hide');}, 1000);
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
                        	$("#threadmsg_loader").show();
                            $.ajax({
                                url: './Controller.php',
                                type: 'post',
                                data: {'createThreadReply':stringData},
                                dataType: 'text',
                                success: function (data) {
                                    $("#threadmsg_loader").hide();
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
        	$(".message").removeClass('messageThread');
            $(".regularMessagesWrapper").removeClass("col-xs-8").addClass("col-xs-12");
            $(".threadMessageWrapper").hide();
            $(".messageEntrySpace_regularMsg_HP").css("width", "86.7%");
            $(".messageHoverButtons").hide();
            $(".eleToBeCleared").empty();
        });


	});
}
start();
function escapeHtml(str)
{
	var map =
	{
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		"'": '&#039;'
	};
	return str.replace(/[&<>"']/g, function(m) {return map[m];});
}
function decodeHtml(str)
{
	var map =
	{
		'&amp;': '&',
		'&lt;': '<',
		'&gt;': '>',
		'&quot;': '"',
		'&#039;': "'"
	};
	return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function(m) {return map[m];});
}

// gets all the the thread replies, by just needing the parentmsgID
function getAllThreadReplies(parentMsgID){
    var convertedJSON ={};
    convertedJSON["parentmessageid"] = parentMsgID;

    var stringData = JSON.stringify(convertedJSON);
    console.log(convertedJSON);
    //loader show
    $("#threadmsg_loader").show();
    $.ajax({
        url: './Controller.php',
        type: 'post',
        data: {'getThreadMessages':stringData},
        dataType: 'text',
        success: function (data) {
            console.log(data);
            if(data!=("fail")){

                var jsonArrRes = $.parseJSON(data);
                // to update the number of replies in case if changed
								if(jsonArrRes.length > 0 && $(".messagewithid_"+parentMsgID).find(".repliescount").length < 1){
				                    $(".messagewithid_"+parentMsgID).find(".msg_reactionsec").append('<div class="repliescount" 										title="view thread"><a href="#"><span>'+jsonArrRes.length +'</span> replies</a></div>');
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
                    if(obj['profile_pic'] != "./images/0.jpeg"){
                        curThreadReplyEle.find(".defUserPic").addClass("profilePic").html("");
                        curThreadReplyEle.find(".profilePic").css("background-image","url("+obj['profile_pic']+")");
                    }

                    // var datetime=obj["created_at"].split(" ");
										// var date=datetime[0].split("-");
										// var time=datetime[1].split(":");
										// var date = new Date(date[0],(date[1]-1),date[2],date[0],time[1],time[2]);
										// console.log(date);

                    var curThRepMsgCont=$('<div class="col-xs-11 message"><div class="message_header" userid="'+obj['user_id'] +'"><b>'+ obj["first_name"]+' '+obj["last_name"] +'</b><span class="message_time"> '+ obj["created_at"]+ '</span></div><div class="message_body"> <div class="msg_content">'+escapeHtml(obj["content"])+'</div><div class="msg_reactionsec"></div></div>');
                    var emojiElementsStr= "";
                    $.each(obj['emojis'], function (emojiIndx, emojiObj) {
                        emojiElementsStr += "<div class=\"emojireaction\" emojiid='"+emojiObj['emoji_id'] + "'><i class='"+emojiObj['emoji_pic'] +"'></i><span class=\"reactionCount\">"+ emojiObj['count']+"</span></div>"
                    });
                    curThRepMsgCont.find(".msg_reactionsec").append(emojiElementsStr);
                    $(".threadedreplies_content").find(".threadReplyWithId_"+obj['id']).append(curThRepMsgCont);
                });
                $(".threadedreplies_content").animate({scrollTop: $(".threadedreplies_content").scrollTop() + ($(".threadedreplies_content .messageSet:last-child").offset().top - $(".threadedreplies_content").offset().top)});
				//loader hide
                $("#threadmsg_loader").hide();



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
