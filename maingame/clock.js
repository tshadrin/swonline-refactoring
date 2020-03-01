
		//alert(Ssecond+' '+Sminute+' '+Shour);
	function clock()
	{
		var my_date = new Date();
		var hour = my_date.getHours()+Shour;
		var minute = my_date.getMinutes()+Sminute;
		var second = my_date.getSeconds()+Ssecond;
		if (second>59)
		{
			second = second - 60;
			minute = minute+1;
		}
		if (second<0)
		{
			second = 60 + second;
			minute = minute-1;
		}
		if (minute>59)
		{
			minute = minute - 60;
			hour = hour+1;
		}
		if (minute<0)
		{
			minute = 60+minute;
			hour = hour-1;
		
		}
		if (hour>23)
		{
			hour = hour-24;
		}
		if (hour<0)
		{
			hour = 24+hour;
		}
		
		if(hour<10)
		{ hour="0"+hour; }
		if(minute<10)
		{ minute="0"+minute; }
		if(second<10)
		{ second="0"+second; }
		if (document.getElementById('clock'))
			document.getElementById('clock').innerHTML = hour+':'+minute+':'+second +'</font>' ;
		setTimeout("clock();",1000);
	}
	clock();