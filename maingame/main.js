var ChatMsg,ChatTimer,BalanceTimer,DrinkTimer,KopTimer,balan,Rem,mx1,mx2,ruda,rudanum,sho,MakeTimer,user_text,invrnd,reg_text,sme,shoptext,shopnum;
var	bquality = new Array();
var	colors= new Array();
var	affl_file= new Array();
var	topper= new Array();
var	toppertext= new Array();
var	svet= new Array();
var	mesto= new Array();
var	rudaimg= new Array();
ChatMsg = ''; 
sme = 0;
SkillText = ''; 
skillid = 0;
x = 0;
mx1=0;
balan = 0;
show_us = 0;
rudaimg[1] = 'bron.gif';
rudaimg[2] = 'iron.gif';
rudaimg[3] = 'rose.gif';
rudaimg[4] = 'silver.gif';
rudaimg[5] = 'gold.gif';
rudaimg[6] = 'vetriy.gif';
rudaimg[7] = 'krent.gif';
colors[1] = 'usergood';
colors[2] = 'usernormal';
colors[3] = 'userbad';
colors[4] = 'usermy';
colors[5] = 'userhis';
bquality[0] = 'плохое';
bquality[1] = 'нормальное';
bquality[2] = 'хорошее';
bquality[3] = 'отличное';
mesto[1] = 'Голова';
mesto[2] = 'Тело';
mesto[3] = 'Руки';
mesto[4] = 'Ноги';
svet = {
	1: 'Северо-запад',
	2: 'Север',
	3: 'Северо-восток',
	4: 'Запад',
	5: 'Восток',
	6: 'Юго-запад',
	7: 'Юг',
	8: 'Юго-восток'
}; //имена сторон света




var timeInSecsEX;
var tickerEX;



function close_window_func() {
    close();
}
function startExTimer(secsss){
timeInSecsEX = parseInt(secsss)-1;
tickerEX = setInterval("tickEX()",1000);  
}


function showNotification(ntitle, nbody, nicon) {
    var notification = new Notification(ntitle, {
        dir: "auto",
        lang: "",
        body: nbody,
        icon: nicon,
        iconUrl: nicon

    });
}

function notifyUser(img,title,texto){
talk.noty({
		text     : '<div ><img src="pic/'+img+'" alt="'+title+'" title="'+title+'" style="float: left;padding-bottom:10px;"/> <strong>'+title+'</strong> <br />'+texto+'</div>',
		layout   : 'bottomRight',
		timeout: 15000,
		maxVisible: 2, 
		closeWith: ['click']
	});
}



function tickEX() {
var secsss = timeInSecsEX;
if (secsss>0) {
timeInSecsEX--;
}
else {
clearInterval(tickerEX); 
}

top.frames['mtop'].document.getElementById('countdown').innerHTML = secsss;
}


function sy(n)
{ 
	sme = n;
}
function wclose()
{
	window.close();
}
function myalert(title,msg)
{
	window.open('myalert.php?title='+title+'&msg='+msg+'', '_blank', 'width='+300+',height='+120+', toolbar=0,location=no,status=0,scrollbars=0,resizable=0,left=300,top=250');
}
function shake(n) 
{
	if (self.moveBy) 
	{
		for (i = 12; i > 0; i--) 
		{
			for (j = n; j > 0; j--) 
			{
				self.moveBy(0,i);
				self.moveBy(i,0);
				self.moveBy(0,-i);
				self.moveBy(-i,0);
         }
      }
   }
}

function testBot()
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	var barabash = '<iframe src=captcha.php name=captcha width=100% height=240 marginwidth=2 marginheight=2 frameborder=0></iframe>';
	top.frames['mtop'].document.getElementById('toptext').innerHTML = '<div><img width=0 height=5></div><table class=blue cellpadding=0 cellspacing=1 width=90% align=center><tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td><b>Поиграй в одну интересную игру</b></td></tr></table></td></tr><tr><td class=mainb height=265 bgcolor=FFFFFF valign=top><table width=100% align=center cellpadding=0 cellspacing=0><tr><td>'+barabash+'</td></tr></table></td></tr></table>';
	
}
}

function claimAva()
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	var barabash = '<iframe src=claim_ava.php name=claim_ava width=100% height=240 marginwidth=2 marginheight=2 frameborder=0></iframe>';
	top.frames['mtop'].document.getElementById('toptext').innerHTML = '<div><img width=0 height=5></div><table class=blue cellpadding=0 cellspacing=1 width=90% align=center><tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td><b>Возврат Образов</b></td></tr></table></td></tr><tr><td class=mainb height=265 bgcolor=FFFFFF valign=top><table width=100% align=center cellpadding=0 cellspacing=0><tr><td>'+barabash+'</td></tr></table></td></tr></table>';
	
}
}

function arenainfo(aid)
{
	NewWnd = window.open('arenainfo.php?arena='+aid, 'Arena', 'width='+500+',height='+500+', toolbar=0,location=no,status=0,scrollbars=1,resizable=0,left=20,top=20');
}
function setchan(n) // init chat
{
if (top.frames['look'])
if (top.frames['look'].document.getElementById('usr'+n))
{
	cit = new Array();
	cit[0] = 'Локация';
	cit[1] = 'Город';
	cit[2] = 'Мир';
	for (i = 0;i <=2; i++)
	{
		top.frames['look'].document.getElementById('usr'+i).innerHTML = '<a href=menu.php?load=c_user&to='+i+' class=menu target=menu>'+cit[i]+'</a>';
	}
	top.frames['look'].document.getElementById('usr'+n).innerHTML = '<b>'+cit[n]+'</b>';
	show_us = n;
}
}
function makechat() // init chat
{
if (top.frames['talk'])
if (top.frames['talk'].document.getElementById('tbox'))
{
	top.frames['talk'].document.getElementById('tbox').innerHTML = ChatMsg;
}
}
function addforge(r1,rmax) // init chat
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	rnum = top.frames['mtop'].document.getElementById('r'+r1).value;
	if ((rmax >= rnum) && (rnum > 0))
	{
		if (top.frames['mtop'].document.getElementById('rudnum'))
		{
			top.frames['mtop'].document.getElementById('rudnum').innerHTML = rnum;
			top.frames['mtop'].document.getElementById('rudon').innerHTML = '?';
			top.frames['mtop'].document.getElementById('rudabutton').innerHTML = '<input type=button value=Переплавить onclick="top.frames[\'menu\'].document.location= \'menu.php?load=blacksmith&action=forge&id='+r1+'&num='+rnum+'\';">';
			top.frames['mtop'].document.getElementById('rimg').src = 'pic/stuff/else/'+rudaimg[r1];
			top.frames['mtop'].document.getElementById('iimg').src = 'pic/stuff/else/ingot'+rudaimg[r1];
		}
	}
	else
	{
		alert('У вас нет такого количества руды.');
	}
}
}
function forge(ruda1,ruda2,ruda3,ruda4,ruda5,ruda6,ruda7,per,col) // init chat
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	if (col < 0)
		c = '?';
	else
		c = '<b>'+col+'</b>';
	main = "<table height=100% width=100%><tr><td><table width=95%><tr valign=top><td align=center width=33%><b>Руда</b><br><div id=leftruda><img src=pic/stuff/else/ruda.gif id=rimg></div></td><td width=33% align=center><b>Переплавка</b><br><table><tr><td>Количество:</td><td id=rudnum>?</td></tr><tr><td>Результат:</td><td id=rudon>"+c+"</td></tr></table><font id=rudabutton><input type=button value=Переплавить disabled></font></td><td align=center><b>Слиток</b><br><div id=rightruda><img src=pic/stuff/else/slitok.gif id=iimg></div></td></tr><tr><td colspan=3 height=20><table width=85% cellspacing=1 bgcolor=8C9AAD align=center height=15><tr><td bgcolor=BDC7DE align=center width="+per+"%>"+per+"%</td><td bgcolor=E6EAEF></td></tr></table></td></tr></table> </td></tr></table>";
	left = '<tr><td align=center width=60><img src=pic/stuff/else/'+rudaimg[1]+' width=35 height=35></td><td align=center><b>Бронза</b><br><table cellspacing=0><tr><td><input type=text value='+ruda1+' size=3 id=r1></td><td>/ '+ruda1+'</td><td><input type=button value=» onclick="top.addforge(1,'+ruda1+');"></td></tr></table></td></tr>';
	left += '<tr><td align=center width=60><img src=pic/stuff/else/'+rudaimg[2]+' width=35 height=35></td><td align=center><b>Железо</b><br><table cellspacing=0><tr><td><input type=text value='+ruda2+' size=3 id=r2></td><td>/ '+ruda2+'</td><td><input type=button value=» onclick="top.addforge(2,'+ruda2+');"></td></tr></table></td></tr>';
	left += '<tr><td align=center width=60><img src=pic/stuff/else/'+rudaimg[3]+' width=35 height=35></td><td align=center><b>Роза</b><br><table cellspacing=0><tr><td><input type=text value='+ruda3+' size=3 id=r3></td><td>/ '+ruda3+'</td><td><input type=button value=» onclick="top.addforge(3,'+ruda3+');"></td></tr></table></td></tr>';
	left += '<tr><td align=center width=60><img src=pic/stuff/else/'+rudaimg[4]+' width=35 height=35></td><td align=center><b>Серебро</b><br><table cellspacing=0><tr><td><input type=text value='+ruda4+' size=3 id=r4></td><td>/ '+ruda4+'</td><td><input type=button value=» onclick="top.addforge(4,'+ruda4+');"></td></tr></table></td></tr>';
	left += '<tr><td align=center width=60><img src=pic/stuff/else/'+rudaimg[5]+' width=35 height=35></td><td align=center><b>Золото</b><br><table cellspacing=0><tr><td><input type=text value='+ruda5+' size=3 id=r5></td><td>/ '+ruda5+'</td><td><input type=button value=» onclick="top.addforge(5,'+ruda5+');"></td></tr></table></td></tr>';
	left += '<tr><td align=center width=60><img src=pic/stuff/else/'+rudaimg[6]+' width=35 height=35></td><td align=center><b>Ветрий</b><br><table cellspacing=0><tr><td><input type=text value='+ruda6+' size=3 id=r6></td><td>/ '+ruda6+'</td><td><input type=button value=» onclick="top.addforge(6,'+ruda6+');"></td></tr></table></td></tr>';
	left += '<tr><td align=center width=60><img src=pic/stuff/else/'+rudaimg[7]+' width=35 height=35></td><td align=center><b>Крентаврий</b><br><table cellspacing=0><tr><td><input type=text value='+ruda7+' size=3 id=r7></td><td>/ '+ruda7+'</td><td><input type=button value=» onclick="top.addforge(7,'+ruda7+');"></td></tr></table></td></tr>';
	top.frames['mtop'].document.getElementById('toptext').innerHTML = '<div><img width=0 height=5></div><table class=blue cellpadding=0 cellspacing=1 width=90% align=center><tr><td class=bluetop width=34%><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td><b>Руда в рюкзаке</b></td></tr></table></td><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td><b>Результат работы</b></td></tr></table></td></tr><tr><td class=mainb height=265 bgcolor=FFFFFF valign=top><table width=85% align=center cellpadding=0 cellspacing=0>'+left+'</table></td><td class=mainb height=265 bgcolor=FFFFFF valign=top>'+main+'</td></tr></table>';
}
}
function domir(sk,main)
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	g = 0;
	
	if (top.frames['mtop'].document.getElementById('pernum'))
	if ((top.frames['mtop'].document.getElementById('pernum').innerHTML != '0%') && ((top.frames['mtop'].document.getElementById('pernum').innerHTML != '100%')))
	{
		g = 1;
		
	}
	if (g == 0)
		top.frames['mtop'].document.getElementById('toptext').innerHTML = '<div><img width=0 height=5></div><table class=blue cellpadding=0 cellspacing=1 width=500 align=center><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td><b>'+sk+'</b></td></tr></table></td></tr><tr><td class=mainb height=265 bgcolor=FFFFFF valign=top>'+main+'</td></tr></table>';
}
}
function sleep(img) // add text to chat
{
if (top.frames['mbar'])
if (top.frames['mbar'].document.getElementById('sleep'))
{
	top.frames['mbar'].document.getElementById('sleep').src= "pic/"+img;
	if (img == 'sleep.gif')
		top.frames['mbar'].document.getElementById('sleep').title= "Сесть отдохнуть";
	else
		top.frames['mbar'].document.getElementById('sleep').title= "Подняться с земли";
	
}
}
function add(time,from,t,type,whom,more) // add text to chat
{
if (top.frames['talk'])
if (top.frames['talk'].document.getElementById('tbox'))
{
	if (whom == player_name)
		wh = from;
	else
		wh = whom;
	//if (player_name)
	theResult = t.indexOf(player_name+' ');
	theResult2 = t.indexOf('[<b>'+player_name+'</b>]');
	if (theResult2 != -1)
		style = 'red2';
	else if (theResult != -1)
		style = 'red';
	else
		style = '';
	ign = 0;
	for (i = 1;i<=12;i++)
	{
		if ( (ignor[i] != '') && (ignor[i] == from) )
			ign = 1;
	}
	if (ign == 0)
	if ( (from == player_name) || (sme == 0) || (( (sme == 1) &&  (theResult != -1) ) || (type != 2) || (whom == 'Арена')))
	{
		//alert(sme);
		if (!(more))
		more = '';
		if (whom == "")
			whom = "Без города";
		if (type == 1)
			msg = "<div class=chat><font class=time"+style+">"+time+"&nbsp;</font><a onclick=top.entertext('"+from+"'); style='cursor:hand'><b>"+from+"</b> "+more+"</a>:&nbsp;"+t+"</div>";
		else if (type == 2)
		{
			pr = '';
			msg = "<div class=chat><font class=time"+style+">"+time+"&nbsp;</font><b><a onclick=top.textenter('/город'); style='cursor:hand'><font class=city>["+whom+"]&nbsp;</font></a><a onclick=top.entertext('"+from+"'); style=cursor:hand>"+from+"</a>"+pr+"</b> "+more+":&nbsp;"+t+"</div>";
		}
		else if (type == 3)
			msg = "<div class=chat><font class=time"+style+">"+time+"&nbsp;</font><b><a onclick=top.textenter('/группа'); style='cursor:hand'><font class=party>["+whom+"]&nbsp;</font></a><a onclick=top.entertext('"+from+"'); style=cursor:hand>"+from+"</a></b> "+more+":&nbsp;"+t+"</div>";
		else if (type == 4)
			msg = "<div class=chat><font class=timered>"+time+" </font><b><a onclick=top.textenter('/приват&nbsp;"+wh+"'); style='cursor:hand'><font class=private>[Приват&nbsp;для&nbsp;"+whom+"]&nbsp;</font></a><a onclick=top.entertext('"+from+"'); style=cursor:hand>"+from+"</a></b>:&nbsp;"+t+"</div>";
		else if (type == 5) // Kicks
			msg = "<div class=chatsmall><font class=time"+style+">"+time+" </font><font class=kick>"+t+"</font></div>";
		else if (type == 6) // system
			msg = "<div class=chatsmaller><font class=time>"+time+" </font>"+t+"</div>";
		else if (type == 7)
			msg = "<div class=chat><font class=time"+style+">"+time+"&nbsp;</font><b><a onclick=top.textenter('/клан'); style='cursor:hand'><font class=сparty>["+whom+"]&nbsp;</font></a><a onclick=top.entertext('"+from+"'); style=cursor:hand>"+from+"</a></b> "+more+":&nbsp;"+ t +"</div>";
		else if (type == 8)
			msg = "<div class=chat><font class=timegreen>"+time+"&nbsp;</font>&nbsp;"+ t +"</div>";
		else if (type == 9)
			msg = "<div class=chat><font class=time"+style+">"+time+"&nbsp;</font><b><a onclick=top.textenter('/переговоры'); style='cursor:hand'><font class=party>["+whom+"]&nbsp;</font></a><a onclick=top.entertext('"+from+"'); style=cursor:hand>"+from+"</a></b>:&nbsp;"+ t +"</div>";
		else if (type == 10)
			msg = "<table cellpadding=0 cellspacing=0><tr><td><font class=time"+style+">"+time+"&nbsp;</font></td><td ><b><a onclick=top.textenter('/бог'); style='cursor:hand'><font color=FF0000>["+whom+"]&nbsp;</font></a><a onclick=top.entertext('"+from+"'); style=cursor:hand>"+from+"</a></b>:&nbsp;"+ t +"</td></tr></table>";
		else if (type == 11)
			msg = "<table cellpadding=0 cellspacing=0><tr><td style='filter:GLOW(color=CCCCCC, strength=4)'><font class=time"+style+">"+time+"&nbsp;</font><b><font color=FF0000>"+whom+"&nbsp;</font><a onclick=top.textenter('/бог'); style='cursor:hand'><font color=AA0000>[Б]</font></a>:&nbsp;<font class=god><b>"+ t +"</b></font></td></tr></table>";
		else if (type == 12)
			msg = "<table cellpadding=0 cellspacing=0><tr><td><font class=time"+style+">"+time+"&nbsp;</font><b><a onclick=\"top.textenter('/отбога "+from+"');\" style='cursor:hand'><font color=FF0000>["+whom+"]&nbsp;</font></a><a onclick=top.entertext('"+from+"'); style=cursor:hand>"+from+"</a></b>:&nbsp;"+ t +"</td></tr></table>";
		else if (type == 13)
			msg = "<div class=chat><font class=time"+style+">"+time+"&nbsp;</font><b><a onclick=top.textenter('/общий'); style='cursor:hand'><font class=party>["+whom+"]&nbsp;</font></a><a onclick=top.entertext('"+from+"'); style=cursor:hand>"+from+"</a></b>:&nbsp;"+ t +"</div>";
		top.frames['talk'].document.getElementById('tbox').innerHTML = msg + top.frames['talk'].document.getElementById('tbox').innerHTML;
		ChatMsg = msg+ChatMsg;
	}
}
}
function doreguest(r)
{
	reg_text += '</table>';
	var iframe = top.frames['mtop'].document.getElementById('iframe'+r+'').contentWindow;
	if (iframe)
	{
		if (iframe.document.getElementById('regall'))
		iframe.document.getElementById('regall').innerHTML = reg_text;
	}
	
}
function tatol(sid,id,id1,name1,id2,name2,sum,p,num,hp1,hp2)
{
	if (id == -1)
		reg_text = '<table width=100% cellspacing=1 bgcolor=7C8A9D cellpadding=3><tr bgcolor=D7DBDF><TD  align=center width=40%><b>Имя</b></td><TD  align=center  width=40%><b>Имя</b></td><TD  align=center><b>Сумма</b></td></tr><tr><td colspan=4 bgcolor=E7EBEF align=center>'+p+'</td></tr>';
	else
	{
		hpone = "";
		hptwo = "";
		if (num == 0)
			ent = "<table cellpadding=0 cellspacing=0 width=80><tr><TD><input type=text name=sgold value=0 size=3 maxlength=3></td><td>&nbsp;<input type=submit value=Поставить style=width:80></td></tr></table>";
		else
			ent = "";
		if (num == -1)
		{
			hpone = "<font color=005500>Жизни: "+hp1+"</font>";
			hptwo = "<font color=005500>Жизни: "+hp2+"</font>";
		}

			
		reg_text += '<tr bgcolor=D7DBDF><TD><form action=menu.php target=menu><table cellpadding=0 cellspacing=0 width=100%><input type=hidden name=load value=arena><input type=hidden name=action value=3><input type=hidden name=sidd value='+id+'><input type=hidden name=id value='+sid+'><input type=hidden name=reg value='+id1+'><input type=hidden name=do value=total><Tr><td width=15><a href=../fullinfo.php?name='+name1+' target=_blank><img src=pic/game/info.gif width=13 height=13></td><td width=100%>&nbsp;'+name1+'</td></tr><tr><td colspan=2>'+ent+hpone+'</td></tr></table></form></td><TD><form action=menu.php target=menu><table cellpadding=0 cellspacing=0 width=100%><input type=hidden name=sidd value='+id+'><input type=hidden name=load value=arena><input type=hidden name=action value=3><input type=hidden name=id value='+sid+'><input type=hidden name=reg value='+id2+'><input type=hidden name=do value=total><Tr><td width=15><a href=../fullinfo.php?name='+name2+' target=_blank><img src=pic/game/info.gif width=13 height=13></td><td width=100%>&nbsp;'+name2+'</td></tr><tr><td colspan=2>'+ent+hptwo+'</td></tr></table></form></td><TD align=center>'+sum+'</td></tr>';
		
	}
}
function regdo(sid,id,name,level,tim,allowbet,p)
{
	if (id == -1)
		reg_text = '<table width=100% cellspacing=1 bgcolor=7C8A9D cellpadding=3><tr bgcolor=D7DBDF><TD  align=center width=10><b>Время</b></td><TD  align=center><b>Имя персонажа</b></td><TD  align=center width=10><b>Уровень</b></td><TD align=center width=100><b>Действие</b></td></tr><tr><td colspan=4 bgcolor=E7EBEF align=center>'+p+'</td></tr>';
	else
	{
		if (allowbet == 1)
				ent = "<table cellpadding=0 cellspacing=0 width=100% ><tr><td>Ставка: </td><TD><input type=text name=sgold value=0 size=3 maxlength=3></td></tr><tr><td colspan=2><form action=menu.php target=menu><input type=hidden name=load value=arena><input type=hidden name=action value=1><input type=hidden name=id value='"+sid+"'><input type=hidden name=reg value='"+id+"'><input type=hidden name=do value=accept><input type=submit value=Подтвердить style=width:100></td></tr></table>";
			else
				ent = "<table cellpadding=0 cellspacing=0 width=100% ><td colspan=2><form action=menu.php target=menu><input type=hidden name=load value=arena><input type=hidden name=action value=1><input type=hidden name=id value='"+sid+"'><input type=hidden name=reg value='"+id+"'><input type=hidden name=do value=accept><input type=submit value=Подтвердить></td></tr></table>";
		reg_text += '<tr bgcolor=D7DBDF><TD  align=center width=40>'+tim+'</td><TD><table cellpadding=0 cellspacing=0><Tr><td><a href=../fullinfo.php?name='+name+' target=_blank><img src=pic/game/info.gif></td><td>&nbsp;'+name+'</td></tr></table></td><TD width=60 align=center>'+level+'</td><TD align=center width=100>'+ent+'</td></tr></form>';
	}
}
function asktrade(trade_id,ask1,ask2)
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('mybut'))
{
	if (ask1 == 0)
		sl1 = '<input type=submit value=Предложить style=width:80 onclick="top.frames[\'menu\'].document.location = \'menu.php?load=trade&action=tradestg1&trade_id='+trade_id+'&stg=1\';"> <input type=submit value=Поменять style=width:70 disabled>';
	if (ask2 == 0)
		sl2 = '';
	if ((ask1 == 1) && ((ask2 == 1) || (ask2 == 2)))
		sl1 = '<input type=submit value=Предложить style=width:80 disabled> <input type=submit value=Поменять style=width:70 onclick="top.frames[\'menu\'].document.location = \'menu.php?load=trade&action=tradestg2&trade_id='+trade_id+'&stg=1\';">';
	if (ask2 == 1)
		sl2 = '<input type=submit value=Предложить style=width:80 disabled>';
	if ((ask1 == 2) || ( (ask1 == 1) && (ask2 == 0) ) )
		sl1 = '<input type=submit value=Предложить style=width:80 disabled> <input type=submit value=Поменять style=width:70 disabled>';
	if (ask2 == 2)
		sl2 = '<input type=submit value=Предложить style=width:80 disabled> <input type=submit value=Поменять style=width:70 disabled>';
	top.frames['mtop'].document.getElementById('mybut').innerHTML = sl1;
	top.frames['mtop'].document.getElementById('hisbut').innerHTML = sl2;
}
}
function tradeweight(wgi)
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('cweig'))
{
	if (wgi <= top.frames['mtop'].document.getElementById('mweig').innerHTML)
		top.frames['mtop'].document.getElementById('cweig').innerHTML = wgi;
	else
		top.frames['mtop'].document.getElementById('cweig').innerHTML = '<font color=red>'+wgi+'</font>';
}
}
function addtrade(t,obj_id,wh,what,name,count,trade_id)
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById(wh))
{
	
	if (t == 1)
	{
		if (top.frames['mtop'].document.getElementById(wh+'count'+obj_id))
			top.frames['mtop'].document.getElementById(wh+'count'+obj_id).innerHTML = count;
		else
		{
			cl = '<b>Количество:</b>&nbsp;<font id='+wh+'count'+obj_id+'>'+count+'</font></b><br>';
			if (top.frames['mtop'].document.getElementById(wh+'nc'+obj_id))
				top.frames['mtop'].document.getElementById(wh+'nc'+obj_id).innerHTML = cl;
			else 
			t = 0;
			
		}
	}
	if (t == 0)
	{
		sl1='';
		sl2='';
		if (!top.frames['mtop'].document.getElementById(wh+'obtrade'+obj_id))
		{
			sl1='<table cellpadding=0 cellspacing=0 width=100%><tr><td id='+wh+'obtrade'+obj_id+'>';
			sl2='</td></tr></table>';
		}
		if (count > 1)
			cl = '<b>Количество:</b>&nbsp;<font id='+wh+'count'+obj_id+'>'+count+'</font></b><br>';
		else
			cl = '';
		lng = '';
		if (wh == 'mytr')
		lng = '[<a href=menu.php?load=trade&action=delobj&trade_id='+trade_id+'&obj_id='+obj_id+'&stg=1 class=menu target=menu><b>Очистить</b></a>]';
		
		mp = sl1+'<table width=100% cellpadding=0 cellspacing=0><tr><TD><b>'+name+'</b>&nbsp;<a href=# onmouseout=hide_info(this); onmouseover=tooltip(this,\"'+what+'\"); class=party>[<b>i</b>]</a></td><td align=right>'+lng+'</td></tr></table><font id='+wh+'nc'+obj_id+'>'+cl+'</font><div align=center><img height=5></div>'+sl2;
		if (sl1 != '')
			top.frames['mtop'].document.getElementById(wh).innerHTML += mp;
		else
			top.frames['mtop'].document.getElementById(wh+'obtrade'+obj_id).innerHTML = mp;

	}
	if (t == 2)
	{
		top.frames['mtop'].document.getElementById(wh).innerHTML =  '';
	}
}
}
function trade(maxwg,myname,hisname)
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	ran = Math.random() *9999;
	invrnd = ran;
	inform = '<table width=230 height=290 bgcolor=8C9AAD cellpadding=1 cellspacing=1><tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing="0" cellpadding="0" width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname>Вместимость <font id=cweig></font>&nbsp;(<font id=mweig>'+maxwg+'</font>)</td></tr></table></td></tr><tr><td bgcolor=F7FBFF><iframe src="iframe.php?ran='+ran+'" id=iframe'+ran+' width="235" height="100%" marginwidth="0" marginheight="0" frameborder="0" style="background-color: #AAAAAA;"></iframe></td></tr></table>';
	mtxt = '<table width=100% height=290 bgcolor=8C9AAD cellpadding=1 cellspacing=1><tr><td class=bluetop><table cellpadding=0 cellspacing=0 width=100%><tr><td class=gal><table cellspacing="0" cellpadding="0" width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname><table width=100% cellpadding=0 cellspacing=0><tr><TD>'+myname+'</td><td id=mybut align=right></td></tr></table></td></tr></table></td></tr><tr><td bgcolor=F7FBFF height=50% valign=top><table cellpadding=4 width=100%><tr><tD id=mytr ></td></tr></table></td></tr><tr><td class=bluetop><table cellpadding=0 cellspacing=0 width=100%><tr><td class=gal><table cellspacing="0" cellpadding="0" width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname><table width=100% cellpadding=0 cellspacing=0><tr><TD>'+hisname+'</td><td id=hisbut align=right></td></tr></table></td></tr></table></td></tr><tr><td bgcolor=F7FBFF height=50% valign=top><table cellpadding=4 width=100%><tr><td id=hetr></td></tr></table></td></tr></table>';
	top.frames['mtop'].document.getElementById('toptext').innerHTML = '<div><img height=3></div><table width=95% align=center><tr><TD width=240>'+inform+'</td><td>'+mtxt+'</td></tr></table>';
}
}
function makeobj(num,text,num1,text1,num2,text2,num3,text3)
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	if (num == 0)
	{
		clearTimeout(MakeTimer);
		if (top.frames['mtop'].document.getElementById('makebutton'))
			top.frames['mtop'].document.getElementById('makebutton').innerHTML = '<input type=button value=Изготовить disabled>';
		
		if (top.frames['mtop'].document.getElementById('maketext'))
			top.frames['mtop'].document.getElementById('maketext').innerHTML = '&nbsp;- '+text;
	}
	if (num < 99)
	{
		num = num + 1;	
		if (top.frames['mtop'].document.getElementById('perbar'))
		{
			if (num1 == num)
				top.frames['mtop'].document.getElementById('maketext').innerHTML = '&nbsp;- '+text1;
			if (num2 == num)
				top.frames['mtop'].document.getElementById('maketext').innerHTML = '&nbsp;- '+text2;
			if (num3 == num)
				top.frames['mtop'].document.getElementById('maketext').innerHTML = '&nbsp;- '+text3;
			top.frames['mtop'].document.getElementById('pernum').innerHTML = num+'%';
			top.frames['mtop'].document.getElementById('perbar').innerHTML = '<table width=99% cellspacing=1 bgcolor=8C9AAD align=center height=15><tr><td bgcolor=BDC7DE align=center width='+num+'%></td><td bgcolor=E6EAEF> </td></tr></table>';
			clearTimeout(MakeTimer);
			MakeTimer = setTimeout("makeobj("+num+",'"+text+"',"+num1+",'"+text1+"',"+num2+",'"+text2+"',"+num3+",'"+text3+"');",200);
		}
	}
	else
	{
		if (top.frames['mtop'].document.getElementById('pernum'))
			top.frames['mtop'].document.getElementById('pernum').innerHTML = '100%';
		if (top.frames['mtop'].document.getElementById('perbar'))
			top.frames['mtop'].document.getElementById('perbar').innerHTML = '<table width=99% cellspacing=1 bgcolor=8C9AAD align=center height=15><tr><td bgcolor=BDC7DE align=center></td></tr></table>';		
	}
		
}
}
function kopka(title,pic,per1,text1,per2,text2,per3,text3,per4,text4,skill,nm)
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	if (nm == 1)
		x = 0;
	x = x + 1;
	if (x == 1)
	{
		clearTimeout(KopTimer);
		text = '<table cellpadding=0 cellspacing=0 width=500 height=60><tr><td><table cellpadding=3 cellspacing=3 width=400><tr><td width=200><b><font color=AAAAAA>- Результаты работы</font></td><td id=perto><table width=150 height=15 cellpadding=1 cellspacing=1 bgcolor=8C9AAD><tr><td width='+x+' bgcolor=BDC7DE id=ltd> </td><td bgcolor=F7FBFF> </td></tr></table></b></td></tr><tr><td colspan=2><b> - <font id=ktext>Результат действий.</font></b></td></tr></table></td><td id=mimg width=100> </td></tr></table><br><table cellpadding=3 cellspacing=3 width=400><tr><Td><b><font color=AAAAAA> - Информация</font><br><br>'+skill+'</b></td></tr></table>';
		main = '<table width=90% cellpadding=5 align=center><tr><td><table class=blue cellpadding=0 cellspacing=1 width=100% align=center><tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td>'+title+'</td></tr></table></td></tr><tr><td class=mainb height=265 bgcolor=FFFFFF valign=top>'+text+'</td></tr></table></td></tr></table>';
		top.frames['mtop'].document.getElementById('toptext').innerHTML = main;
	}
	else
	{
		if (top.frames['mtop'].document.getElementById('ltd'))
		{
			top.frames['mtop'].document.getElementById('ltd').width = x;
			if (x == per1)
				top.frames['mtop'].document.getElementById('ktext').innerHTML = text1;
			if (x == per2)
				top.frames['mtop'].document.getElementById('ktext').innerHTML = text2;
			if (x == per3)
				top.frames['mtop'].document.getElementById('ktext').innerHTML = text3;
			if (x == per4)
				top.frames['mtop'].document.getElementById('ktext').innerHTML = text4;
		}
		if (x > per2)
		{
			if (pic != "")
			{
				y = x-50;
				if (top.frames['mtop'].document.getElementById('mimg'))
				top.frames['mtop'].document.getElementById('mimg').innerHTML = "<img src="+pic+" style='filter:alpha(Opacity="+(y)+");'>";
			}
		}
			
	}
	if (x != 150)
	{
		if (top.frames['mtop'].document.getElementById('ktext'))
		{
			clearTimeout(KopTimer);
			KopTimer = setTimeout("kopka('"+title+"','"+pic+"',"+per1+",'"+text1+"',"+per2+",'"+text2+"',"+per3+",'"+text3+"',"+per4+",'"+text4+"',2);",150);
		}
		else
			x = 0;
	}
	else
	{
		if (top.frames['mtop'].document.getElementById('perto'))
			top.frames['mtop'].document.getElementById('perto').innerHTML = "<table width=150 height=15 cellpadding=1 cellspacing=1 bgcolor=8C9AAD><tr><td bgcolor=BDC7DE id=ltd align=center>Завершено</td></tr></table>";
		x = 0;
	}
}
}
function mtext(time,name,where,n)
{
if (n == 1)
	add(time,'','<font class=italic><b>'+name+' </b> уходит на <b>'+svet[where]+'</b>.</font>',5,'');
else
	add(time,'','<font class=italic><b>'+name+' </b> входит в комнату.</font>',5,'');
}
function city(name,pic,menu,text,info,p)
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	if (p == 1)
	{
		p = '';
		mt = menu;
		menu = '';
	}
	else
	{
		p = ' height=180';
		mt = '';
	}
		
	main = '<table class=blue cellpadding=0 cellspacing=1 width=100%><tr><td class=bluetop><table cellpadding=0 cellspacing=0 width=100%><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td>'+text+'</td></tr></table></td></tr><tr><td class=mainb height=265 bgcolor=FFFFFF valign=top>'+info+'</td></tr></table>';
	top.frames['mtop'].document.getElementById('toptext').innerHTML = '<table width=95% align=center cellspacing=0 cellpadding=3 height=300 ><tr><td width=140 valign=top height=120><img src=pic/'+pic+' alt='+mt+'></td><td rowspan=2>'+main+'</td></tr><tr><td valign=top '+p+' width=140>'+menu+'&nbsp;</td></tr></table>';
}
}

function reset() // Reset text
{	
if (top.frames['mbar'])
{
	top.frames['mbar'].document.getElementById('ebar').focus();
	top.frames['mbar'].document.getElementById('ebar').value = '';
	top.frames['mbar'].document.getElementById('ebar').focus();
}
}

function clearchat() // clear chat
{	
if (top.frames['talk'])
if (top.frames['talk'].document.getElementById('tbox'))
{
	top.frames['talk'].document.getElementById('tbox').innerHTML = '';
	ChatMsg = '';
}
}
function textenter(text) // add text
{	
if (top.frames['mbar'])
{
	
	top.frames['mbar'].document.getElementById('ebar').focus();
	top.frames['mbar'].document.getElementById('ebar').value = text+' '+top.frames['mbar'].document.getElementById('ebar').value;
	top.frames['mbar'].document.getElementById('ebar').focus();
}
}
function entertext(text) // add text
{	
if (top.frames['mbar'])
{
	
	top.frames['mbar'].document.getElementById('ebar').focus();
	top.frames['mbar'].document.getElementById('ebar').value = top.frames['mbar'].document.getElementById('ebar').value+' '+text+' ';
	top.frames['mbar'].document.getElementById('ebar').focus();
}
}
function sh(x,x2) // set HP
{	
if (top.frames['info'])
{
	if (top.frames['info'].document.getElementById('hpscore'))
	{
		top.frames['info'].document.getElementById('hp1').width = x/x2*100;
		top.frames['info'].document.getElementById('hp2').width = 100-x/x2*100;
		top.frames['info'].document.getElementById('hpscore').innerHTML = x+'/'+x2;
	}
	
}
}

function addMute(time)
{
	if (top.frames['users'])
	if (top.frames['users'].document.getElementById('mute'))
	{
		top.frames['users'].document.getElementById('mute').innerHTML = '<img src=pic/mute.gif onmouseout="hide_info(this);" onmouseover="tooltip(this,\'Бан чата, осталось : '+time+'\');">';
	}

}
function dMute()
{
	if (top.frames['users'])
	if (top.frames['users'].document.getElementById('mute'))
	{
		top.frames['users'].document.getElementById('mute').innerHTML = '';
	}

}
function du(text) // del users
{	
if (top.frames['users'])
if (top.frames['users'].document.getElementById('userlist'))
{
	top.frames['users'].document.getElementById('userlist').innerHTML = '';
	user_text = '';
	if (text)
		top.frames['users'].document.getElementById('myclantext').innerHTML = '<a href=menu.php?load=clan class=menu target=menu><font class=userclan>['+text+']</font></a>';
	
}
}
function settarget(name,lvl) // change target
{
if (top.frames['info'])
if (top.frames['info'].document.getElementById('mytarget'))
{
	top.frames['info'].document.getElementById('mytarget').innerHTML = name+' '+lvl+' ур';
}
}
function au(party,id,name,per,color,text,cid, m) // add users
{	
clan = '';
if (text)
	if (text != '')
		clan = '<a href=menu.php?load=clan&city_id='+cid+' class=menu target=menu><font class=userclan>['+text+']</font></a>';


if (party == 0)
	par = '<a href=menu.php?load=addparty&id='+id+' target=menu><img src="pic/game/noparty.gif" width="13" height="13" border="0" alt=""></a>';
else if (party == 1)
	par = '<img src="pic/game/party.gif" width="13" height="13" border="0" alt="">';
else 
	par = '';
if (per != -1)
{
	if (per == 3)
		hp = '<table cellpadding=0 cellspacing=1 bgcolor=333333 width=10 height=10><tr><td bgcolor=CC0000 height='+(per*3+1)+' width=10></td></tr></table>';
	else 
		hp = '<table cellpadding=0 cellspacing=1 bgcolor=333333 width=10 height=10><tr><td bgcolor=F6FAFF height='+(10-(per*3+1))+' width=10></td></tr><tr><td bgcolor=CC0000 height='+(per*3+1)+'></td></tr></table>';
}
else
	hp = '';

if(m == 1)
{
	mute = "<img src=pic/mute.gif>"
}
else
{
	mute = "";
}
	
user_text += '<div id=text'+id+'><table cellpadding=2 cellspacing=0 width=100% id=text'+id+'><tr><td width=12>'+hp+'</td><td width=40>'+mute+'<a href="../fullinfo.php?name='+name+'" target="_blank"><img src=pic/game/info.gif width=13 height=13></a></td> <td width=18>'+par+'</td> <td width=18><a href=\"menu.php?load=settarget&t_name='+name+'&t_id='+id+'\" target=menu><img src=pic/game/attack.gif width=15 height=15></a></td><td width=20>[<a onclick=\'top.textenter("/приват&nbsp;'+name+'");\' style=cursor:hand><font color=00237B><b>П</b></font></a>]</td> <td><a onclick=\'top.entertext("'+name+'");\' style=cursor:hand class='+colors[color]+'>'+name+'</a>&nbsp;'+clan+'</td></tr></table></div>'
}
function fu(num,cit)
{
if (top.frames['users'])
if (top.frames['users'].document.getElementById('userlist'))
{
	ct = new Array();
	ct[cit] = 'SELECTED';
	if (num == 2)
		top.frames['users'].document.getElementById('n_id').innerHTML ='<form action="menu.php" method="post" target="menu"><table align=center><input type="hidden" name="load" value="c_user"><input type="hidden" name="to" value="2"><Tr><td><select name=city><option value="0" '+ct[0]+'>Без города</option><option value="1"  '+ct[1]+'>Академия</option><option value="2" '+ct[2]+'>Шамаал</option><option value="3" '+ct[3]+'>Хроно</option><option value="4" '+ct[4]+'>Иллюзив</option><option value="5" '+ct[5]+'>Эндлер</option><option value="6" '+ct[6]+'>Шелтер</option><option value="14" '+ct[14]+'>Морок</option></select></td><td><input type="submit" value="Обновить" style=width:70></td></tr></table></form>';
	else
		top.frames['users'].document.getElementById('n_id').innerHTML = '';
	top.frames['users'].document.getElementById('userlist').innerHTML = user_text;
}
}
function sm(x,x2) // set MANA
{	
if (top.frames['info'])
{
	if (top.frames['info'].document.getElementById('manascore'))
	{
		top.frames['info'].document.getElementById('mana1').width = x/x2*100;
		top.frames['info'].document.getElementById('mana2').width = 100-x/x2*100;
		top.frames['info'].document.getElementById('manascore').innerHTML = x+'/'+x2;
	}
	
}
}
function rchat() // refresh chat
{	
if (top.frames['info'])
	if (top.frames['info'].document.getElementById('map'))
		if (top.frames['info'].document.getElementById('map').innerHTML == 'Загрузка..')
			if (top.frames['emap'])
			top.frames['emap'].document.location = 'map.php';
s = '';
if (top.frames['users'].document.getElementById('zagr'))
	s = '&ru=1'
else
	s = '';
if (top.frames['info'].document.getElementById('effect'))
	if (top.frames['info'].document.getElementById('effect').innerHTML == '')
	{
		s = s + '&effect=1';
	}
if (top.frames['ref'])
	top.frames['ref'].document.location = 'ref.php?bln='+balan+s;
ChatTimer = setTimeout("rchat();",13000);
}

function inf(id,city_rank,cname,rating,pic,name,sex,race,h_up,s_up,str,dex,intt,wis,con,expp,level,gold,amulet,amulettext,amuletid,ring1,ring1text,ring1id,ring2,ring2text,ring2id,body,bodytext,bodyid,sword,swordtext,swordid,glove,glovetext,gloveid,helmet,helmettext,helmetid,cloak,cloaktext,cloakid,shield,shieldtext,shieldid,legs,legstext,legsid,avtorizate,pet) // character information
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	pt = '';
	if (pet > 0)
		pt = ' (<a href=menu.php?load=pet target=menu class=menu2><b>К списку о животных</b></a>)';
	top.frames['mtop'].document.getElementById('topname').innerHTML = 'Информация'+pt;
	if (h_up > 0)
		up = '<img src=pic/game/up.gif border=0 width=8 height=8>';
	else
		up = '';
	if (city_rank != "")
		city_rank = '<tr><td class=info1><font size=1>Должность:</font></td><td class=info2><font size=1><font color=red>'+city_rank+'</font></font></td></tr>';
	nick = '';
	if (avtorizate == 1)
		nick = '<tr><td colspan=2><font color=red>* Имя проверяется администрацией *</font></td></tr>';
	samulet = '<a href=menu.php?load=useobj&obj_id='+amuletid+' target=menu><img src=pic/stuff/'+amulet+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+amulettext+'");></a>';
	sring1 = '<a href=menu.php?load=useobj&obj_id='+ring1id+' target=menu><img src=pic/stuff/'+ring1+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+ring1text+'");></a>';
	sring2 = '<a href=menu.php?load=useobj&obj_id='+ring2id+' target=menu><img src=pic/stuff/'+ring2+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+ring2text+'");></a>';
	sbody = '<a href=menu.php?load=useobj&obj_id='+bodyid+' target=menu><img src=pic/stuff/'+body+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+bodytext+'");></a>';
	ssword = '<a href=menu.php?load=useobj&obj_id='+swordid+' target=menu><img src=pic/stuff/'+sword+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+swordtext+'");></a>';
	sglove = '<a href=menu.php?load=useobj&obj_id='+gloveid+' target=menu><img src=pic/stuff/'+glove+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+glovetext+'");></a>';
	shelmet = '<a href=menu.php?load=useobj&obj_id='+helmetid+' target=menu><img src=pic/stuff/'+helmet+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+helmettext+'");></a>';
	scloak = '<a href=menu.php?load=useobj&obj_id='+cloakid+' target=menu><img src=pic/stuff/'+cloak+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+cloaktext+'");></a>';
	sshield = '<a href=menu.php?load=useobj&obj_id='+shieldid+' target=menu><img src=pic/stuff/'+shield+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+shieldtext+'");></a>';
	slegs = '<a href=menu.php?load=useobj&obj_id='+legsid+' target=menu><img src=pic/stuff/'+legs+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+legstext+'");></a>';
	
	img = '<table cellpadding=0 cellspacing=0 width=280><tr><td background=pic/game/b2slot.gif width=64 height=32 align=center>'+samulet+'</td><td rowspan=5 width=150 align=center><img src=pic/obraz/'+pic+'></td><td rowspan=2 background=pic/game/bslot.gif  width=64  height=64 align=center>'+shelmet+'</td></tr><tr><td  height=32><table width=100% height=100% cellpadding=0 cellspacing=0><tr><td background=pic/game/b3slot.gif align=center width=32>'+sring1+'</td><td  background=pic/game/b3slot.gif align=center>'+sring2+'</td></tr></table></td></tr><tr><td background=pic/game/b4slot.gif height=70 align=center>'+sbody+'</td><td background=pic/game/b4slot.gif  height=70 align=center>'+scloak+'</td></tr><tr><td background=pic/game/b4slot.gif  height=70 align=center>'+ssword+'</td><td background=pic/game/b4slot.gif  height=70 align=center>'+sshield+'</td></tr><tr><td background=pic/game/bslot.gif  height=64 align=center>'+sglove+'</td><td background=pic/game/bslot.gif  height=64 align=center>'+slegs+'</td></tr></table>';
	inform = '<table width=240 cellpadding=1 cellspacing=1><tr><td class=info1>Имя:</td><td class=info2>'+name+'</td></tr><tr><td class=info1>Уровень:</td><td class=info2>'+level+'</td></tr><tr><td class=info1>Опыт:</td><td class=info2>'+expp+'</td></tr><tr><td class=info1>Раса:</td><td class=info2>'+race+'</td></tr><tr><td class=info1>Пол:</td><td class=info2>'+sex+'</td></tr><tr><td colspan=2 height=0 bgcolor=888888></td></tr><tr><td class=info1>Увеличений:</td><td class=info2 id=h_p>'+h_up+'</td></tr></tr><tr><td class=info1small>&nbsp;&nbsp;» Сила:</td><td class=info2small id=upp>'+str+'&nbsp;<a href=menu.php?load=addparam&param=1 target=menu>'+up+'</a></td></tr><tr><td class=info1small>&nbsp;&nbsp;» Подвижность:</td><td class=info2small id=updex>'+dex+'&nbsp;<a href=menu.php?load=addparam&param=2 target=menu>'+up+'</a></td></tr><tr><td class=info1small>&nbsp;&nbsp;» Интеллект:</td><td class=info2small id=upintt>'+intt+'&nbsp;<a href=menu.php?load=addparam&param=3 target=menu>'+up+'</a></td></tr><tr><td class=info1small>&nbsp;&nbsp;» Мудрость:</td><td class=info2small id=upwis>'+wis+'&nbsp;<a href=menu.php?load=addparam&param=4 target=menu>'+up+'</a></td></tr><tr><td class=info1small>&nbsp;&nbsp;» Телосложение:</td><td class=info2small id=upcon>'+con+'&nbsp;<a href=menu.php?load=addparam&param=5 target=menu>'+up+'</a></td><tr><td colspan=2 height=0 bgcolor=888888></td></tr><tr><td class=info1>Уроков:</td><td class=info2>'+s_up+'</td></tr><tr><td class=info1>Золото:</td><td class=info2>'+gold+'</td></tr><tr><td class=info1>Рейтинг:</td><td class=info2>'+rating+' <a href=# onclick=\"javascript:NewWnd=window.open(\'fight.php?id=\'+'+id+', \'fight\', \'width=\'+550+\',height=\'+500+\', toolbar=0,location=no,status=0,scrollbars=1,resizable=0,left=20,top=20\');\" class=menu2>[Список]</a></td></tr><tr><td class=info1>Город:</td><td class=info2>'+cname+'</td></tr>'+city_rank+nick+'</table>';
	
	top.frames['mtop'].document.getElementById('toptext').innerHTML = '<table cellpadding=5 align=center width=80% ><tr><td width=290>'+img+'</td><td align=right valign=top>'+inform+'</td></tr></table>';
}
}

function aflict(n,what) // all aflictions
{
if (top.frames['info'])
if (top.frames['info'].document.getElementById('effect'))
{
	var	affl= new Array();
	affl[1] = 'Страх';
	affl[2] = 'Ранения';
	affl[3] = 'Кровотечение';
	affl[4] = 'Каменное&nbsp;тело';
	affl[5] = 'Невидимость';
	affl[6] = 'Зоркость';
	affl[7] = 'Подсечка';
	affl[8] = 'Проклятие';
	affl[9] = 'Жажда&nbsp;крови';
	affl[10] = 'Слепота';
	affl[11] = 'Ожог';
//	affl[12] = 'Скорость';
	affl[12] = 'Благословление';
	affl[13] = 'Скорость';
	affl[14] = 'Сопротивление';
	affl[15] = 'Ясный&nbsp;взор';
	affl[16] = 'Уверенность';
	affl[17] = 'Смелость';
	affl[18] = 'Нечувствительность';
	affl[19] = 'Видение';
	affl[20] = 'Ярость';
	affl[21] = 'Подготовка';
	affl[22] = 'Парализация';
	affl[23] = 'Медлительность';
	affl[24] = 'Бурнэ';
	affl[25] = 'Крита';
	affl[26] = 'Ярра';
	affl[27] = 'Алана';
	affl[28] = 'Медлительность';
	if (n == 1)
		top.frames['info'].document.getElementById('effect').innerHTML = "";
	if (what != 0)
		if (!(top.frames['info'].document.getElementById('afl'+what)))
			top.frames['info'].document.getElementById('effect').innerHTML += '<font id=afl'+what+'><img src=pic/stuff/aff/'+what+'.gif alt='+affl[what]+' onmouseout="hide_info(this);" onmouseover="tooltip(this,\''+affl[what]+'\');"></font>';
}

}
function delaflict(what) // delete afliction
{
if (top.frames['info'])
if (top.frames['info'].document.getElementById('afl'+what))
{
	top.frames['info'].document.getElementById('afl'+what).innerHTML = '';
}
}

function rbal(x1,x2) // reset balance
{
if (top.frames['info'])
{
	if (top.frames['info'].document.getElementById('bal'))
	if (top.frames['info'].document.getElementById('bal1'))
	{
		balan = 1;
		b = Math.round(x1/x2*100);
		c = 101 - b;
		top.frames['info'].document.getElementById('bal1').width = b;
		top.frames['info'].document.getElementById('bal2').width = c;
		top.frames['info'].document.getElementById('bal').innerHTML = '<b>Нет</b>';
		x1 = x1-2;
		if (x1 > 2)
		{
			clearTimeout(BalanceTimer);
			BalanceTimer = setTimeout("rbal("+x1+","+x2+");",200);
		}
		else
		{
			balan = 0;
			top.frames['info'].document.getElementById('bal1').width = 1;
			top.frames['info'].document.getElementById('bal2').width = 100;
			top.frames['info'].document.getElementById('bal').innerHTML = 'Есть';
		}
		mx1 = x1;
	}
}
}
function drbal(x1,x2) // reset drink balance 
{
if (top.frames['info'])
{
	if (top.frames['info'].document.getElementById('dbal'))
	{
		
		b = Math.round(x1/x2*100);
		c = 101 - b;
		top.frames['info'].document.getElementById('dbal1').width = b;
		top.frames['info'].document.getElementById('dbal2').width = c;
		top.frames['info'].document.getElementById('dbal').innerHTML = '<b>Нет</b>';
		x1 = x1-2;
		if (x1 > 2)
		{
			clearTimeout(DrinkTimer);
			DrinkTimer = setTimeout("drbal("+x1+","+x2+");",200);
		}
		else
		{
			top.frames['info'].document.getElementById('dbal1').width = 1;
			top.frames['info'].document.getElementById('dbal2').width = 100;
			top.frames['info'].document.getElementById('dbal').innerHTML = 'Есть';
		}
	}
}
}
function block(b) // create skill set
{
if (top.frames['menu'])
{
	top.frames['enter'].document.location = 'enter.php?load=block&id='+b;
}
}
function setblock(was,now)
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	blok[1] = 'Блок головы';
	blok[2] = 'Блок тела';
	blok[3] = 'Блок рук';
	blok[4] = 'Блок ног';
	for (i = 1;i <= 4; i++)
	if (top.frames['mtop'].document.getElementById('blk'+i))
		if (i != now)
			top.frames['mtop'].document.getElementById('blk'+i).innerHTML = '» '+blok[i];
	if (top.frames['mtop'].document.getElementById('blk'+now))
		top.frames['mtop'].document.getElementById('blk'+now).innerHTML = '» <b>'+blok[now]+'</b>';
}
}
function dowarskills(bl,links) // war skills
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	blok = new Array();
	blok[1] = 'Блок головы';
	blok[2] = 'Блок тела';
	blok[3] = 'Блок рук';
	blok[4] = 'Блок ног';
	blok[bl] = '<b>' + blok[bl] + '</b>';
	ran = Math.random() *9999;
	skillid = ran;
	top.frames['mtop'].document.getElementById('topname').innerHTML = 'Атакующие действия';
	top.frames['mtop'].document.getElementById('toptext').innerHTML = '<div><img height=10 width=0></div><table width=95% height=290 align=center cellspacing=1 cellpadding=0 class=blue><tr><td width=150 class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td>Эликсиры</td></tr></table></td><td class=bluetop><table cellpadding=0 cellspacing=0 width=100%><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td>Атакующие действия</td></tr></table></td></tr><tr><td class=mainb valign=top><table cellpadding=0 cellspacing=0 width=100% height=100%><tr><td valign=top height=120>'+links+'</td></tr><tr><td valign=top height=80><table cellspacing=1 bgcolor=8C9AAD width=100% cellpadding=3><tr bgcolor=BDCBDE><td style=cursor:hand onmouseover=this.bgColor=\"#DAE8FB\" onmouseout=this.bgColor=\"#BDCBDE\" onclick=top.block(1); id=blk1>» '+blok[1]+'</td></tr><tr bgcolor=BDCBDE><td style=cursor:hand onmouseover=this.bgColor=\"#DAE8FB\" onmouseout=this.bgColor=\"#BDCBDE\"  onclick=top.block(2);  id=blk2>» '+blok[2]+'</td></tr>'+
	'<tr bgcolor=BDCBDE><td style=cursor:hand onmouseover=this.bgColor=\"#DAE8FB\" onmouseout=this.bgColor=\"#BDCBDE\"  onclick=top.block(3);  id=blk3>» '+blok[3]+'</td></tr><tr bgcolor=BDCBDE><td style=cursor:hand onmouseover=this.bgColor=\"#DAE8FB\" onmouseout=this.bgColor=\"#BDCBDE\"  onclick=top.block(4);  id=blk4>» '+blok[4]+'</td></tr></table></td></tr><tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td>Запоминание</td></tr></table></td></tr><tr><td height=1 bgcolor=8898AF></td></tr><tr><td id=remember align=center></td></tr></table></td><td class=mainb valign=top rowspan=2><table cellpadding=0 cellspacing=0 height=100% width=100%><tr><td><iframe src=sframe.php?ran='+ran+' name=sframe'+ran+' width=100% height=100% marginwidth=2 marginheight=2 frameborder=0></iframe></td></tr></table></td></tr></table>';
}
}
function remreset()
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('remember'))
{
	if (Rem)
		clearTimeout(Rem);
	top.frames['mtop'].document.getElementById('remember').innerHTML = "";
}
}
function remem(text,kickto,onme,sk_id,sk_num)
{
if (balan == 1)
{
	if (top.frames['mtop'])
	if (top.frames['mtop'].document.getElementById('remember'))
	{
		
		if (kickto != 0)
			top.frames['mtop'].document.getElementById('remember').innerHTML = "<table width=100%><tr><td class=skillname align=center>"+text+"<br>Место: "+mesto[kickto]+"<br><a onclick=top.remreset(); href=# class=lin><b>[Сбросить]</b></a></td></tr></table>";
		if (onme == 1)
			top.frames['mtop'].document.getElementById('remember').innerHTML = "<table width=100%><tr><td class=skillname align=center>"+text+"<br>Действие: На себя<br><a onclick=top.remreset(); href=# class=lin><b>[Сбросить]</b></a></td></tr></table>";
		else if (onme == 2)
			top.frames['mtop'].document.getElementById('remember').innerHTML = "<table width=100%><tr><td class=skillname align=center>"+text+"<br>Действие: На цель<br><a onclick=top.remreset(); href=# class=lin><b>[Сбросить]</b></a></td></tr></table>";
		if ( (kickto == 0) && (onme == 3))
		{
			top.frames['mtop'].document.getElementById('remember').innerHTML = "<table width=100%><tr><td class=skillname align=center>"+text+"<br><a onclick=top.remreset(); href=# class=lin><b>[Сбросить]</b></a></td></tr></table>";
		}
		clearTimeout(Rem);
		Rem = setTimeout("remem('"+text+"',"+kickto+","+onme+","+sk_id+","+sk_num+");",mx1*100);
	}
}
else
{
	if (top.frames['mtop'])
	if (top.frames['mtop'].document.getElementById('remember'))
	{
		top.frames['menu'].document.location = 'menu.php?load=attack&skill_id='+sk_id+'&num='+sk_num+'&kickto='+kickto+'&kwho='+onme;
		top.frames['mtop'].document.getElementById('remember').innerHTML = "";
	}
}
}
function createtop(n,text) // create skill set
{
if ((n == 0) || (n == -1))
	SkillText = '';
toptext = '<font id=delall'+n+'><img height=1 width=0><table class=blue cellpadding=2 cellspacing=1 width=99% align=center><tr><td bgcolor=BDCBDE><b> <font id=del'+n+'><font onclick=setattr('+n+',1); style="cursor:hand">»</font></font> '+text+'</b></td></tr>';
SkillText += toptext;	
toppertext[n] = toptext; 
topper[n] = '<font id=delall'+n+'><img height=1 width=0><table class=blue cellpadding=2 cellspacing=1 width=99% align=center><tr><td bgcolor=BDCBDE><b> <font id=del'+n+'><font onclick=setattr('+n+',2); style="cursor:hand">+</font></font> '+text+'</b></td></tr></table></font>';
if (n == 0)
{
	toptext = '<input type=hidden name=num value=1><input type=hidden name=skill_id value=0><tr class=mainb><td><table width=99% cellspacing=0 cellpadding=1 align=center><tr><td width=35% class=skillname><b>Обычный удар</b></td><td width=70 class=skillname>Ударить по</td><td width=50><select name=kickto class=skill id=kickto><option value=1>Голове</option><option value=2>Телу</option><option value=3>Рукам</option><option value=4>Ногам</option></select></td><td align=right><input type="submit" value="Выполнить" style=width:70 class=skill onclick="top.remem(\'Удар кулаком\',document.getElementById(\'kickto\').value,3,0,1);"></td></tr></form></table></td></tr>';
	SkillText += toptext;
	toppertext[n] += toptext;
}
if (n == -1)
{
  	//n = 0;
    toptext = '<input type=hidden name=num value=1><input type=hidden name=skill_id value=0><tr class=mainb><td><table width=99% cellspacing=0 cellpadding=1 align=center><tr><td width=35% class=skillname><b>Обычный удар</b></td><td width=70 class=skillname>Ударить по</td><td width=50><select name=kickto class=skill id=kickto><option value=1>Голове</option><option value=2>Телу</option><option value=3>Рукам</option><option value=4>Ногам</option></select></td><td align=right><input type="submit" value="Выполнить" style=width:70 class=skill onclick="top.remem(\'Удар кулаком\',document.getElementById(\'kickto\').value,3,0,1);"></td></tr></form></table></td></tr>';
    //toptext += '<input type=hidden name=num value=2><input type=hidden name=skill_id value=0><tr class=mainb><td><table width=99% cellspacing=0 cellpadding=1 align=center><tr><td width=35% class=skillname><b>Броcить снежок</b></td><td width=70 class=skillname>Бросить в</td><td width=50><select name=kickto02 class=skill id=kickto02><option value=1>Голову</option><option value=2>Тело</option><option value=3>Руки</option><option value=4>Ноги</option></select></td><td align=right><input type="submit" value="Выполнить" style=width:70 class=skill onclick="top.remem(\'Бросить снежок\',document.getElementById(\'kickto02\').value,3,0,2);"></td></tr></form></table></td></tr>';
	SkillText += toptext;
	toppertext[n] += toptext;
}

}
function mains(type,name,sk,num) 
{
tx = "<input type=hidden name=load value=attack><input type=hidden name=num value="+num+"><input type=hidden name=skill_id value="+sk+"><tr class=mainb><td><table width=99% cellspacing=0 cellpadding=1 align=center><tr><td width=35%  class=skillname><b>"+name+"</b></td>";
if (type == 1)
{
	toptext = tx+"<td width=70 class=skillname>Ударить по</td><td width=50><select name=kickto"+sk+num+" id=kickto"+sk+num+" class=skill ><option value=1>Голове</option><option value=2>Телу</option><option value=3>Рукам</option><option value=4>Ногам</option></select></td><td align=right><input type='submit' value='Выполнить' style=width:70 class=skill onclick=\"top.remem('"+name+"',document.getElementById(\'kickto"+sk+num+"\').value,3,"+sk+","+num+");\"></td></tr></table></td></tr>";
	SkillText += toptext;
	toppertext[sk]+= toptext;
}
else if (type == 2)
{
	toptext = tx+"<td width=70 class=skillname></td><td width=50></td><td align=right><input type='submit' value='Выполнить' style=width:70 class=skill onclick=\"top.remem('"+name+"',0,3,"+sk+","+num+");\"></td></tr></table></td></tr>";
	SkillText += toptext;
	toppertext[sk]+= toptext;
}
else if (type == 3)
{
	toptext = tx+"<td width=70 class=skillname>Выполнить</td><td width=50><select name=kwho class=skill id=kwho"+sk+num+"><option value=1>На себя</option><option value=2>На цель</option></select></td><td align=right><input type='submit' value='Выполнить' style=width:70 class=skill onclick=\"top.remem('"+name+"',0,document.getElementById(\'kwho"+sk+num+"\').value,"+sk+","+num+");\"></td></tr></table></td></tr>";
	SkillText += toptext;
	toppertext[sk]+= toptext;
}
else if (type == 4)
{
	toptext = tx+"<td width=70 class=skillname>Выстрел в</td><td width=50><select name=kickto"+sk+num+" id=kickto"+sk+num+" class=skill ><option value=1>Голову</option><option value=2>Тело</option><option value=3>Руки</option><option value=4>Ноги</option></select></td><td align=right><input type='submit' value='Выполнить' style=width:70 class=skill onclick=\"top.remem('"+name+"',document.getElementById(\'kickto"+sk+num+"\').value,3,"+sk+","+num+");\"></td></tr></table></td></tr>";
	SkillText += toptext;
	toppertext[sk]+= toptext;
}
}
function endtop() // create skill set
{
SkillText += '</table></font>';	
}
function gotoskills(ac) // Skill cache
{
if (top.frames['menu'])
	if (SkillText != '')
		top.frames['menu'].document.location = 'menu.php?load=do&action='+ac;
	else
		top.frames['menu'].document.location = 'menu.php?load=do&no=1&action='+ac;
}
function addbookpage(page,n)
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('rightbookpage'))
{
	s = '<table width=100%><tr><td align=center><b>Страница </b>';
	for (i=1; i<=page; i=i+1)
	{
		if (n == i)
			 s += ' '+i+' ';
		else
			s += '<a href=menu.php?load=magicbook&page='+i+' target=menu class=booklink> '+i+' </a>';
	}
	s += '</td></tr></table>';
	top.frames['mtop'].document.getElementById('rightbookpage').innerHTML += s;
}
}
function addbook(id,name,n) // draw magic book
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById(n+'book'))
	{
		if (n == 'left')
			s = '<font id=b'+n+id+'><table width=100% cellpadding=0 cellspacing=1><tr><td>» '+name+'</td><td width=60><a href=menu.php?load=book&do=del&id='+id+' target=menu class=booklink>[Удалить]</a></td></tr></table></font>';
		else
			s = '<font id=b'+n+id+'><table width=100% cellpadding=0 cellspacing=1><tr><td>» '+name+'</td><td width=60><a href=menu.php?load=book&do=add&id='+id+' target=menu class=booklink>[Записать]</a></td></tr></table></font>';
		top.frames['mtop'].document.getElementById(n+'book').innerHTML += s;
	}
}
function delbook(id,where) // draw magic book
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('b'+where+id))
{
	top.frames['mtop'].document.getElementById('b'+where+id).innerHTML = '';
}
}
function book(wis) // draw magic book
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	left = '<div align=center><b>Книга заклинаний ('+wis+')</b></div><div id=leftbook></div>';
	right = '<div align=center><b>Список свитков</b></div><table cellpadding=0 cellspacing=0 height=80% width=100%><tr><td id=rightbook valign=top></td></tr></table><font id=rightbookpage></font>';
	text = '<table width=88% height=100% cellpadding=8 align=center><tr valign=top><td width=50%>'+left+'</td><td width=50%>'+right+'</td></tr></table>';
	top.frames['mtop'].document.getElementById('toptext').innerHTML = '<div><img height=8 width=0></div><table width=500 height=280 background=pic/game/viewbook.jpg align=center><tr><td>'+text+'</td></tr></table>';
}
}
function scrol(page1,page2,typ) // draw magic book
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	if (typ == 1)
	{
		text = '<table width=88% height=100% cellpadding=8 align=center><tr valign=top><td width=50%><div align=justify>'+page1+'</div></td><td width=50%><div align=justify>'+page2+'</div></td></tr></table>';
		top.frames['mtop'].document.getElementById('toptext').innerHTML = '<div><img height=8 width=0></div><table width=500 height=280 background=pic/game/viewbook.jpg align=center><tr><td>'+text+'</td></tr></table>';
	}
	if (typ == 2)
		top.frames['mtop'].document.getElementById('toptext').innerHTML = '<div><img height=8 width=0></div><table align=center cellpadding=0 cellspacing=0><tr><td width=339 height=50 background="pic/stuff/else/scrolltop.gif"></td></tr><tr><td height=190 background="pic/stuff/else/scrollcenter.gif" valign=top align=center>'+page1+'</td></tr><tr><td height=39 background="pic/stuff/else/scrollbottom.gif"></td></tr></table>';
}
}
function settop(text)
{
if (top.frames['mtop'].document.getElementById('topname'))
	top.frames['mtop'].document.getElementById('topname').innerHTML = text;
}
function inv(pic,cw,w,quality,amulet,amulettext,amuletid,ring1,ring1text,ring1id,ring2,ring2text,ring2id,body,bodytext,bodyid,sword,swordtext,swordid,glove,glovetext,gloveid,helmet,helmettext,helmetid,cloak,cloaktext,cloakid,shield,shieldtext,shieldid,legs,legstext,legsid) // character information
{
if (top.frames['mtop'])
if (top.frames['mtop'].document.getElementById('toptext'))
{
	ran = Math.random() *9999;
	invrnd = ran;
	top.frames['mtop'].document.getElementById('topname').innerHTML = 'Инвентарь';
	start = "<a href=menu.php?load=useobj&obj_id=";
	samulet = start+amuletid+' target=menu><img src=pic/stuff/'+amulet+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+amulettext+'");></a>';
	sring1 = start+ring1id+' target=menu><img src=pic/stuff/'+ring1+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+ring1text+'");></a>';
	sring2 = start+ring2id+' target=menu><img src=pic/stuff/'+ring2+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+ring2text+'");></a>';
	sbody = start+bodyid+' target=menu><img src=pic/stuff/'+body+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+bodytext+'");></a>';
	ssword = start+swordid+' target=menu><img src=pic/stuff/'+sword+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+swordtext+'");></a>';
	sglove = start+gloveid+' target=menu><img src=pic/stuff/'+glove+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+glovetext+'");></a>';
	shelmet = start+helmetid+' target=menu><img src=pic/stuff/'+helmet+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+helmettext+'");></a>';
	scloak = start+cloakid+' target=menu><img src=pic/stuff/'+cloak+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+cloaktext+'");></a>';
	sshield = start+shieldid+' target=menu><img src=pic/stuff/'+shield+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+shieldtext+'");></a>';
	slegs = start+legsid+' target=menu><img src=pic/stuff/'+legs+' onmouseout=hide_info(this);  onmouseover=tooltip(this,"'+legstext+'");></a>';
	img = '<table cellpadding=0 cellspacing=0 width=280><tr><td background=pic/game/b2slot.gif width=64 height=32 align=center>'+samulet+'</td><td rowspan=5 width=150 align=center><img src=pic/obraz/'+pic+'></td><td rowspan=2 background=pic/game/bslot.gif  width=64  height=64 align=center>'+shelmet+'</td></tr><tr><td  height=32><table width=100% height=100% cellpadding=0 cellspacing=0><tr><td background=pic/game/b3slot.gif align=center width=32>'+sring1+'</td><td  background=pic/game/b3slot.gif align=center>'+sring2+'</td></tr></table></td></tr><tr><td background=pic/game/b4slot.gif height=70 align=center>'+sbody+'</td><td background=pic/game/b4slot.gif  height=70 align=center>'+scloak+'</td></tr><tr><td background=pic/game/b4slot.gif  height=70 align=center>'+ssword+'</td><td background=pic/game/b4slot.gif  height=70 align=center>'+sshield+'</td></tr><tr><td background=pic/game/bslot.gif  height=64 align=center>'+sglove+'</td><td background=pic/game/bslot.gif  height=64 align=center>'+slegs+'</td></tr></table>';
	inform = '<table width=240 height=263 bgcolor=8C9AAD cellpadding=1 cellspacing=1><tr bgcolor=BDCBDE><td valign=top height=32><table width=100% height=32><tr><td background=pic/stuff/else/bag'+quality+'.gif height=30 width=28></td><td align=center>Качество рюкзака:<br><b>'+bquality[quality]+'</b></td></tr></table></td></tr>'+
	'<tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing="0" cellpadding="0" width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname>Вместимость '+cw+' ('+w+')</td></tr></table></td></tr>'+
		
	'<tr><td bgcolor=F7FBFF><iframe src="iframe.php?ran='+ran+'" id="iframe'+ran+'" width="235" height="200" marginwidth="0" marginheight="0" frameborder="0" style="background-color: #AAAAAA;"></iframe></td></tr></table>';
	top.frames['mtop'].document.getElementById('toptext').innerHTML = '<table cellpadding=5 align=center width=80%><tr><td width=290>'+img+'</td><td align=right valign=top>'+inform+'</td></tr></table>';
}
}
function ttext(topp,text)
{
fr = top.frames['mtop'];
if (fr)
if (fr.document.getElementById('toptext'))
{
	fr.document.getElementById('topname').innerHTML = topp;
	fr.document.getElementById('toptext').innerHTML = text;
}
}
function gomap(dir) // Update map
{
	var informationFrame = top.frames['info'].document;
	if (typeof informationFrame !== "undefined") {
		if (informationFrame.getElementById('map')) {
			if (show_us == 0)
				if (top.frames['users'].document.getElementById('userlist'))
					top.frames['users'].document.getElementById('userlist').innerHTML = '&nbsp;<font id=zagr>Загрузка...</font>';
			top.frames['info'].document.getElementById('maploc').innerHTML = ' - <b>Переход..</b>';
			if (top.frames['emap'])
				top.frames['emap'].document.location = 'map.php?dir=' + dir;
		}
	}
}
function shop(city,per,text,menu)
{
fr = top.frames['mtop'];
if (fr)
if (fr.document.getElementById('toptext'))
{
	ran = Math.random() *9999;
	sho = ran;
	if (per != 0)
		cit = 'Налог города '+city+'  на покупку вещей составляет <b>'+per+'%</b>';
	else
		cit = '';
	fr.document.getElementById('toptext').innerHTML = '<div><img width=0 height=5></div><table class=blue cellpadding=0 cellspacing=1 width=95% align=center><tr><td class=bluetop width=34%><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td><b>Имеющийся товар</b></td></tr></table></td><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td><b>'+text+'</b></td></tr></table></td></tr><tr><td class=mainb height=265 bgcolor=FFFFFF valign=top><table width=80% align=center height=80%><tr><td valign=top>'+menu+'</td></tr></table><table width=90% align=center><tr><td align=center>'+cit+'</td></tr></table></td><td class=mainb height=265 bgcolor=FFFFFF valign=top><iframe src=iframe.php?ran='+ran+' name=iframe'+sho+'  id=iframe'+sho+'  width=100% height=100% marginwidth=2 marginheight=2 frameborder=0></iframe></td></tr></table>';
	
}
}
function mysell(city,per,text,menu)
{
fr = top.frames['mtop'];
if (fr)
if (fr.document.getElementById('toptext'))
{
	ran = Math.random() *9999;
	sho = ran;
	fr.document.getElementById('toptext').innerHTML = '<div><img width=0 height=5></div><table class=blue cellpadding=0 cellspacing=1 width=95% align=center><tr><td class=bluetop width=240><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td><b>Имеющийся товар</b></td></tr></table></td><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td><b>'+text+'</b></td></tr></table></td></tr><tr><td class=mainb height=265 bgcolor=FFFFFF valign=top><iframe src="iframe.php?ran='+ran+'" name="iframe" id="iframe" width="240" height="265" marginwidth="0" marginheight="0" frameborder="0" style="background-color: #AAAAAA;"></iframe></td><td class=mainb height=265 bgcolor=FFFFFF valign=top>'+menu+'</td></tr></table>';
}
}
function addshop(i,text)
{
	if (top.frames['mtop'])
	{
		fr = top.frames['mtop'].document.getElementById('iframe'+sho);
		if (fr)
		{
			if (fr.contentDocument.getElementById('iframetext'))
			{
				if (i == 0)
				{
					shoptext = '';
					shopnum = text;
				}
				else if (i == -1)
				{
					if (top.frames['mtop'].document.getElementById('ggold'))
						top.frames['mtop'].document.getElementById('ggold').innerHTML = text;	
					fr.contentDocument.getElementById('iframetext').innerHTML = shoptext;	
				}
				else
				{
					 shoptext += text;	
				}	
			}
		}
	}
}
function shoppager(page,maxpage,sh)
{
	p = '';
	for (i = 1; i <= maxpage ; i=i+10)
	{
		e = i + 9;
		if (e > maxpage)
			e = maxpage;
		if (i == page)
			p += "|<b>"+i+"-"+e+"</b>|";
		else
			p += "|<a href=menu.php?load=buy&do=show&show="+sh+"&page="+i+" class=menu2 target=menu>"+i+"-"+e+"</a>|";
	}
	shoptext += '<table width=100%><Tr><td align=center>'+p+'</td></tr></table>';
}
function addinvobj(id,num,text)
{
fr = top.frames['mtop'].document.frames['iframe'+invrnd];
if (top.frames['mtop'])
if (fr)
{
	if (top.frames['mtop'].document.getElementById('mytrobtrade'+id))
		top.frames['mtop'].document.getElementById('mytrobtrade'+id).innerHTML = '';
	if (fr.document.getElementById('objfull'+id))
	if (fr.document.getElementById('objfull'+id).innerHTML != '')
	{
		if (fr.document.getElementById('objnum'+id))
			fr.document.getElementById('objnum'+id).innerHTML = num;
	}
	else
	{
		if (fr.document.getElementById('objfull'+id))
			fr.document.getElementById('objfull'+id).innerHTML += text;
	}
}
}
function invobj(id,num)
{
fr = top.frames['mtop'].document.frames['iframe'+invrnd];
fr2 = top.frames['mtop'];
if (top.frames['mtop'])
if (fr)
{
	if (fr.document.getElementById('objnum'+id))
	{
		if (num == 0)
			fr.document.getElementById('objfull'+id).innerHTML = '';	
		else
			fr.document.getElementById('objnum'+id).innerHTML = num;	
	}
}
else if (fr2.document.getElementById('objnum'+id))
{
	
	if (num == 0)
	{
		if (fr2.document.getElementById('objfull'+id))
		{
			fr2.document.getElementById('objfull'+id).innerHTML = '';	
			fr2.document.getElementById('objfull2'+id).innerHTML = '';	
		}
	}
	else
		fr2.document.getElementById('objnum'+id).innerHTML = num;	
}
}
function addmenu(name,text)
{
fr = top.frames['mtop'];
if (fr)
	if (fr.document.getElementById('upmenutext'))
	{
		if (fr.document.getElementById('upimg'))
			if (fr.document.getElementById('upimg').innerHTML == '')
			{
				fr.document.getElementById('upimg').innerHTML = '&nbsp;<img src=pic/game/att.gif>';
				
			}
		fr.document.getElementById('upmenutext').innerHTML += '<table align=center><tr><td><a href=menu.php?load='+text+' target=menu class=menu2>'+name+'</a></td></tr></table>';
	}
}

function map(went, id, name, pic, sz_name, s_name, sv_name, z_name,
			 v_name, jz_name, j_name, jv_name, isinfo, save, build, tmi)
{
	informationFrame = top.frames['info'].document;
	topFrame = top.frames['mtop'].document;
	if (typeof informationFrame !== "undefined") {
		$(informationFrame).ready(function(event) { //корректное событие при загрузке фрейма(костыль)
			if (informationFrame.getElementById('map')) {
				if (typeof topFrame !== "undefined") {
					$(topFrame).ready(function(event) { //корректное событие при загрузке фрейма(костыль)
						if (topFrame.getElementById('upmenutext')) {
							topFrame.getElementById('upimg').innerHTML = '';
							topFrame.getElementById('upmenutext').innerHTML = '';
						}
					});
				}
				if (isinfo == 1)
					imap = '<td width=18 align=center><a href=# onclick="javascript:Room=window.open(\'room.php?id=' + id + '\', \'Room\', \'width=\'+500+\',height=\'+300+\', toolbar=0,location=0,status=0,scrollbars=0,resizable=0,left=100,top=100\');"><img  src=pic/game/more.gif width=15 height=15 alt="Просмотреть описание"></a></td>';
				else
					imap = '';
				if (build == 1)
					ibuild = '<td width=18 align=center><img  src=pic/game/house.gif width=16 height=15 alt="Жилой район. Разрешена постройка домов."></td>';
				else if (build == 2)
					ibuild = '<td width=18 align=center><img  src=pic/game/house.gif width=16 height=15 alt="Палатки. Разрешена постройка магазинов."></td>';
				else
					ibuild = '';

				if (save == 1)
					isave = '<td width=18 align=center><img  src=pic/game/def.gif width=15 height=15 alt="Защитная зона города"></td>';
				else
					isave = '';
				informationFrame.getElementById('maploc').innerHTML = '<table cellpadding=0 cellspacing=0><tr><td><b class=inv>' + name + '</b></td>' + imap + isave + ibuild + '</tr></table>';
				if (pic != '') {
					p = ' bgcolor=B8C7D8 background=pic/map/' + pic;
					name = '&nbsp;';
				} else
					p = 'bgcolor=B8C7D8';
				informationFrame.getElementById('map').innerHTML = '<table width=100% height=170 cellspacing=0 style=cursor:hand cellpadding=0><tr bgcolor=EBF1F7 align=center><td width=33% height=33% onclick=parent.gomap("1");>' + sz_name + '</td><td width=1 bgcolor=8C9AAD></td><td onclick=parent.gomap("2");>' + s_name + '</td><td width=1 bgcolor=8C9AAD></td><td width=33% onclick=parent.gomap("3");>' + sv_name + '</td></tr><tr><td colspan=5 bgcolor=8C9AAD height=1></td></tr><tr bgcolor=EBF1F7 align=center><td onclick=parent.gomap("4");>' + z_name + '</td><td width=1 bgcolor=8C9AAD></td><td ' + p + ' class=map>' + name + '</td><td width=1 bgcolor=8C9AAD><td onclick=parent.gomap("5");>' + v_name + '</td></tr><tr><td colspan=5 bgcolor=8C9AAD height=1></td></tr><tr bgcolor=EBF1F7 align=center><td height=33% onclick=parent.gomap("6");>' + jz_name + '</td><td width=1 bgcolor=8C9AAD><td onclick=parent.gomap("7");>' + j_name + '</td><td width=1 bgcolor=8C9AAD><td onclick=parent.gomap("8");>' + jv_name + '</td></tr></table>';
				if (went == 1)
					rbal(50 - tmi * 10, 50 - tmi * 10);
			}
		});
	}
}
ChatTimer = setTimeout("rchat();",13000);

