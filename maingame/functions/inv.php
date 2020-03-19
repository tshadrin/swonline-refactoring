<?php

function inventory( $id )
{
    global $iobj_id2;
    global $info_canon;
    global $player_name;
    global $player_id;
    global $info_obj;
    global $info_obj_id;
    global $info_obj_active;
    global $info_obj_type;
    global $info_obj_place;
    global $info_obj_pic;
    global $obj_img;
    global $obj_img2;
    global $obj_alt;
    global $obj_alt2;
    global $player;
    global $iobj_id;
    global $obj_id2;
    global $race_str;
    global $race_dex;
    global $race_int;
    global $race_wis;
    global $race_con;
    global $cur_weight;
    global $raceId;
    global $str;
    global $dex;
    global $int;
    global $con;
    global $wis;
    global $result;
    $bagquality[0] = "плохое";
    $bagquality[1] = "нормальное";
    $bagquality[2] = "чорошее";
    $bagquality[3] = "отличное";
    $SQL = "select bag_q,str,dex,intt,wis,con,race,pic,pic_server from sw_users where id={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $bag_q = $row_num[0];
        $str = $row_num[1];
        $dex = $row_num[2];
        $int = $row_num[3];
        $wis = $row_num[4];
        $con = $row_num[5];
        $raceId = $row_num[6];
        $pic = $row_num[7];
        $pic_server = $row_num[8];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $num = getobjinfo( "sw_obj.owner = {$player_id} and room = 0", "useobj" );
    prepareinfo( $num );
    $text = "";
	$text = "<ul class='tabs'>
	<li title=\"Все вещи\" ><a href='#.item.tab1, .item.tab2, .item.tab3, .item.tab4, .item.tab5' id='allItems'><img src=\"pic/game/tabs/allbag.png\" ></a></li>
	<li title=\"Расходники\"><a href='#.item.tab2'><img src=\"pic/game/tabs/pot.png\" ></a></li>
	<li title=\"Экипировка\"><a href='#.item.tab3'><img src=\"pic/game/tabs/equip.png\" ></a></li>
	<li title=\"Лут\"><a href='#.item.tab4'><img src=\"pic/game/tabs/loot.png\" ></a></li>
	<li title=\"Подарки\"><a href='#.item.tab5'><img src=\"pic/game/tabs/gifts.png\" ></a></li></ul>
	<script type=\"text/javascript\" src=\"jquery.min.js\"></script>
	<script>
    window.onload = function() {
	\$('ul.tabs').each(function(){
    var \$active, \$content, \$links = \$(this).find('a');

    \$active = \$(\$links.filter('[href=\"'+location.hash+'\"]')[0] || \$links[0]);
    \$active.addClass('active');

    \$content = \$(\$active[0].hash);

    \$links.not(\$active).each(function () {
      \$(this.hash.substring(1)).hide();
    });

    \$(this).on('click', 'a', function(e){
      \$active.removeClass('active');
      \$content.hide();

      \$active = \$(this);
      \$content = \$(this.hash);

      \$active.addClass('active');
      \$content.show();
      e.preventDefault();
    });
  });
$('#allItems').click();  
};
</script>
	
	";
    $i = 1;
    for ( ; $i <= $num; ++$i )
    {
        if ( $info_obj_active[$i] == 0 )
        {
            $text = $text.$info_obj[$i];
        }
    }
    $player['text'] = $text;
    $t = $player['text'];
    $max_weight = round( ( $race_str[$raceId] + $str ) * ( 1 + $bag_q / 9 ) );
    if ( $pic == "" )
    {
        $pic = "no_obraz.gif";
    }
    if ( $pic_server == 1 )
    {
        $pic = "".$pic;
    }
    else
    {
        $pic = "".$pic;
    }
    print "<script>top.inv('{$pic}',{$cur_weight},{$max_weight},{$bag_q},'{$obj_img['1']}','{$obj_alt['1']}','{$iobj_id['1']}','{$obj_img['2']}','{$obj_alt['2']}','{$iobj_id['2']}','{$obj_img2['2']}','{$obj_alt2['2']}','{$iobj_id2['2']}','{$obj_img['3']}','{$obj_alt['3']}','{$iobj_id['3']}','{$obj_img['4']}','{$obj_alt['4']}','{$iobj_id['4']}','{$obj_img['5']}','{$obj_alt['5']}','{$iobj_id['5']}','{$obj_img['6']}','{$obj_alt['6']}','{$iobj_id['6']}','{$obj_img['7']}','{$obj_alt['7']}','{$iobj_id['7']}','{$obj_img['8']}','{$obj_alt['8']}','{$iobj_id['8']}','{$obj_img['9']}','{$obj_alt['9']}','{$iobj_id['9']}');</script>";
}

?>
