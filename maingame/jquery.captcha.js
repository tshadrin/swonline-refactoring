function shuffle(array) {
  var currentIndex = array.length, temporaryValue, randomIndex ;

  while (0 !== currentIndex) {

    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}

;(function( $ ){
	$.fn.captcha = function(options){
		var defaults = {  
		   borderColor: "",  
		   captchaDir: "pic/game/captcha/",  
		   url: "captcha.php",  
		   formId: "myForm",  
		   text: "<b>@Барабашка@</b>: Очень простая игра,<br />перенеси указанные <span>вещи</span> в круг.",
		   items: Array("pencil", "scissors", "clock", "heart", "note") 
		  };	
	
		var nbElem = 16;
		var options = $.extend(defaults, options); 
		var TIMES = 1;
		
		var randomItems = Array();
		for(var i=1;i<=nbElem;i++){
			randomItems.push("<li class='ajax-fc-"+i+"'><img src='" + options.captchaDir + "" + i + ".png' alt='' /></li>");
		}
		randomItems = shuffle(randomItems);
		var theElements = randomItems.join("");
		
		ran = Math.random() *9999;
		
		
		
		var isMobile = window.matchMedia("only screen and (max-width: 760px)");
		//isMobile.matches
		if (1==1) {
			$(this).html("<b class='ajax-fc-rtop'><b class='ajax-fc-r1'></b><b class='ajax-fc-r2'></b><b class='ajax-fc-r3'></b><b class='ajax-fc-r4'></b></b><div id='ajax-fc-content'><div id='ajax-fc-left'><ul id='ajax-fc-task'>"+
			theElements+
			"</ul></div><div id='ajax-fc-right'><p id='ajax-fc-task'><b>@Барабашка@</b>: Очень простая игра,<br>нажми на указанные <span>вещи</span>.</p><img src=\"model.php?rev="+ran+"\"  /></div></div><div id='ajax-fc-corner-spacer'></div><b class='ajax-fc-rbottom'><b class='ajax-fc-r4'></b> <b class='ajax-fc-r3'></b> <b class='ajax-fc-r2'></b> <b class='ajax-fc-r1'></b></b>");
			
			
			for(var i=1;i<=nbElem;i++){
				$(".ajax-fc-" + i).addClass('ajax-fc-highlighted');
				$(".ajax-fc-" + i).click(function() {
					var id = $( this ).attr("class").replace(/\D/g, '');
					$( this ).hide();
					$("#" + options.formId).append("<input type=\"hidden\" style=\"display: none;\" name=\"captcha"+TIMES+"\" value=\"" + id + "\">");
					if(TIMES >= 3)
						$("#" + options.formId).submit();
					else
						TIMES++;
				});
			}
		}else{
			$(this).html("<b class='ajax-fc-rtop'><b class='ajax-fc-r1'></b><b class='ajax-fc-r2'></b><b class='ajax-fc-r3'></b><b class='ajax-fc-r4'></b></b><div id='ajax-fc-content'><div id='ajax-fc-left'><ul id='ajax-fc-task'>"+
			theElements+
			"</ul></div><div id='ajax-fc-right'><p id='ajax-fc-task'>" + options.text + "</p><img src=\"model.php?rev="+ran+"\"  /><p id='ajax-fc-circle'></p></div></div><div id='ajax-fc-corner-spacer'></div><b class='ajax-fc-rbottom'><b class='ajax-fc-r4'></b> <b class='ajax-fc-r3'></b> <b class='ajax-fc-r2'></b> <b class='ajax-fc-r1'></b></b>");

			for(var i=1;i<=nbElem;i++){
				$(".ajax-fc-" + i).addClass('ajax-fc-highlighted');
				$(".ajax-fc-" + i).draggable({ containment: '#ajax-fc-content' });
			}
			$("#ajax-fc-circle").droppable({
				drop: function(event, ui) {
					var draggable = ui.draggable;
					draggable.draggable("disable");
					var id = draggable.attr("class").replace(/\D/g, '');
					
					$("#" + options.formId).append("<input type=\"hidden\" style=\"display: none;\" name=\"captcha"+TIMES+"\" value=\"" + id + "\">");
					if(TIMES >= 3)
						$("#" + options.formId).submit();
					else
						TIMES++;
				},
				tolerance: 'touch'
			});	
		}
	};

})( jQuery );