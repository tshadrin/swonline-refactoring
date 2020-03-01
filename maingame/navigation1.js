	MW=80;
	MF='Verdana';
	MFS=1;
	MFColor='E7EBE7';
	MBC='D6D3BD';
	HL='DEE7E7';
	Separater=2;
	n4=(document.layers);
	n6=(document.getElementById&&!document.all);
	ie=(document.all);
	h=(ie)?document.body.clientHeight:window.innerHeight;
	w=(ie)?document.body.clientWidth:window.innerWidth;
	Titles=new Array()
	Links=new Array()
	a1="<center>";
	a2="</center>";
	
	function colour2(c){(n4)?c.bgColor=HL:c.style.background=HL}//
	function colour1(c){(n4)?c.bgColor=MBC:c.style.background=MFColor}//
	
	var OL="<div z-index=0 style='height:auto;width:100%;' onMouseOver='colour1(this)'; onMouseOut='colour2(this)'>";
	var CL="</font></div>";
	
	var vs=(n4)?"n":OL+"&nbsp;"+CL+"<br>"+"</font>";
	
	Titles[0]='<table><tr><td><b>Действие</b></td></tr></table>';
	Titles[1]='<table><tr><td><b>Опции</b></td></tr></table>';
	Titles[2]='<table><tr><td><b>Общество</b></td></tr></table>';
	
	Links[0]=vs
	+OL+"<table width=80%><tr><td width=15><img src=pic/i.gif></td><td><a href=# class=menu>Информация</a></td></tr></table>"+CL
	+OL+"<table width=80%><tr><td width=15><img src=pic/bag.gif></td><td><a href=# class=menu>Инвентарь</a></td></tr></table>"+CL
	+OL+"<table width=80%><tr><td width=15><img src=pic/skills.gif></td><td><a href=# class=menu>Умения</a></td></tr></table>"+CL
	+OL+"<table width=80%><tr><td width=15><img src=pic/at.gif></td><td><a href=# class=menu>Действие</a></td></tr></table>"+CL
	+OL+"<table width=80%><tr><td width=15><img src=pic/har.gif></td><td><a href=# class=menu>Параметры</a></td></tr></table>"+CL
	
	Links[1]=vs
	+OL+"<table width=60%><tr><td width=15><img src=pic/city.gif></td><td><a href=# class=menu>Город</a></td></tr></table>"+CL
	+OL+"<table width=60%><tr><td width=15><img src=pic/city.gif></td><td><a href=# class=menu>Клан</a></td></tr></table>"+CL
	+OL+"<table width=60%><tr><td width=15><img src=pic/party.gif></td><td><a href=# class=menu>Группа</a></a></td></tr></table>"+CL
	
	
	Links[2]=vs
	+OL+"<table width=90%><tr><td width=15><img src=pic/opt.gif></td><td><a href=# class=menu>Настройки чата</a></td></tr></table>"+CL
	+OL+"<table width=90%><tr><td width=15><img src=pic/opt.gif></td><td><a href=# class=menu>Настройки игры</a></td></tr></table>"+CL
	
	Links[3]=vs
	
	
	w1=(MW+Separater)*Titles.length;
	w2=0;
	i1=w2-MW-Separater-w1/2;
	i2=w2-MW-Separater-w1/2;
	s1=MW+Separater;
	s2=MW+Separater;
	if (w1 > w2*2){i1=-MW;i2=-MW}
	vy=(n4)?'show':'visible';
	vn=(n4)?'hide':'hidden';
	
	
	if (!n4){
	for (i=0; i < Titles.length; i++){
		document.write("<div z-index=0 id='lnks"+i+"' style='position:absolute;"
		+"top:0px;left:"+(i2+=s2)+"px;width:"+MW+"px;"
		+"background:"+HL+";visibility:hidden'" 
		+" onMouseOver='this.style.visibility=vy; document.getElementById(\"ttls"+i+"\").style.background=HL';"
		+" onMouseOut='this.style.visibility=vn; document.getElementById(\"ttls"+i+"\").style.background=MBC'>"
		+a1+Links[i]+a2+"</div>");
		document.write("<div z-index=0 id='ttls"+i+"' style='position:absolute;top:0px;left:"+(i1+=s1)+"px;height:20;width:"+MW+"px;"
		+"background:"+MBC+";cursor:default'"
		+" onMouseOver='document.getElementById(\"lnks"+i+"\").style.visibility=vy;this.style.background=HL'" 
		+" onMouseOut='document.getElementById(\"lnks"+i+"\").style.visibility=vn;this.style.background=MBC'>"
		+a1+""+Titles[i]+a2+"</div>");
		}
	}
