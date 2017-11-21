var starClicked = false;

var cal_rating = 0;
var tempval = -1;
var myVar = null;
$(function() {

  $('.star').click(function() {

    $(this).children('.selected').addClass('is-animated');
    $(this).children('.selected').addClass('pulse');

    var target = this;

    setTimeout(function() {
      $(target).children('.selected').removeClass('is-animated');
      $(target).children('.selected').removeClass('pulse');
    }, 1000);

    starClicked = true;
  })

  $('.half').click(function() {
    if (starClicked == true) {
      setHalfStarState(this)
    }
    $(this).closest('.rating').find('.js-score').text($(this).data('value'));

    $(this).closest('.rating').data('vote', $(this).data('value'));
    calculateAverage()
    console.log(parseInt($(this).data('value')));

  })

  $('.full').click(function() {
    if (starClicked == true) {
      setFullStarState(this)
    }
    $(this).closest('.rating').find('.js-score').text($(this).data('value'));

    $(this).find('js-average').text(parseInt($(this).data('value')));

    $(this).closest('.rating').data('vote', $(this).data('value'));
    calculateAverage()

    console.log(parseInt($(this).data('value')));
  })

/*  $('.half').hover(function() {
    if (starClicked == false) {
      setHalfStarState(this)
    }

  })

  $('.full').hover(function() {
    if (starClicked == false) {
      setFullStarState(this)
    }
  })*/
/*
    $(".star").eq(0).find(".half").trigger("click");
    $(".star").eq(1).find(".half").trigger("click");
    $(".star").eq(2).find(".half").trigger("click");
    $(".star").eq(3).find(".half").trigger("click");
    $(".star").eq(4).find(".half").trigger("click");
*/
     cal_rating = Math.ceil((parseInt(userScore))*2)/2;
     if(cal_rating > 5){
         cal_rating = 5;
     }
   $("span[data-value='0']").eq(0).trigger("click");
    myVar = setInterval(function(){ myTimer() }, 200);


})

function myTimer() {
    $("span[data-value='" + (++tempval) +"']").eq(0).trigger("click");
    console.log("tempval:"+tempval);
    if(tempval == cal_rating){
      $("span").off("click");
      $(".star").off("click");
        clearInterval(myVar);
    }
}

function updateStarState(target) {
  $(target).parent().prevAll().addClass('animate');
  $(target).parent().prevAll().children().addClass('star-colour');

  $(target).parent().nextAll().removeClass('animate');
  $(target).parent().nextAll().children().removeClass('star-colour');
}

function setHalfStarState(target) {
  $(target).addClass('star-colour');
  $(target).siblings('.full').removeClass('star-colour');
  updateStarState(target)
}

function setFullStarState(target) {
  $(target).addClass('star-colour');
  $(target).parent().addClass('animate');
  $(target).siblings('.half').addClass('star-colour');

  updateStarState(target)
}

function calculateAverage() {
  var average = 0

  $('.rating').each(function() {
    average += $(this).data('vote')
  })

  $('.js-average').text((average/ $('.rating').length).toFixed(1))
}
