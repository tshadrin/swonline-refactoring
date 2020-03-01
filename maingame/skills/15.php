<?php

$game_skill_type_dmg[15] = 1;
$game_skill_num[15] = 1;
$game_skill_afflict_percent[15][1] = 8;
$game_skill_afflict[15][1] = ",aff_bleed_power=10,aff_bleed_time={$cur_time}+5*12";
$game_skill_afflict_text[15][1] = "[<b>{$target_name}</b>] <font class=italic><b>{$target_name}</b> истекает кровью.</font>";
$game_skill_name[15][1] = "Удар кинжалом";
$game_skill_dmg[15][1] = $dex_dmg * 0.88;
$game_skill_textnum[15][1] = 3;
$game_skill_text[15][1][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>silno ударил{$sex_a} кинжалом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[15][1][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>сделал{$sex_a} выпад и silno ударил{$sex_a} кинжалом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[15][1][3] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>провел{$sex_a} silniy удар кинжалом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_block[15][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} удар кинжалом {$po_mestu[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[15][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} удар кинжалом {$po_mestu[$kickto]}, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[15][1] = 1;
$game_skill_canblock[15][1] = 1;
$game_skill_wepon[15][1] = 5;
$game_skill_canmiss[15][1] = 1;
$game_skill_bad[15][1] = 1;
$game_skill_same_room[15][1] = 1;
$game_skill_type[15][1] = 1;
$game_skill_percent[15][1] = 0;
$game_skill_name[15][2] = "Режущий удар";
$game_skill_afflict_percent[15][2] = 15;
$game_skill_afflict[15][2] = ",aff_bleed_power=20,aff_bleed_time={$cur_time}+5*12";
$game_skill_afflict_text[15][2] = "[<b>{$target_name}</b>] <font class=italic><b>{$target_name}</b> истекает кровью.</font>";
$game_skill_dmg[15][2] = $dex_dmg * 1.3;
$game_skill_mana[15][2] = 7;
$game_skill_textnum[15][2] = 2;
$game_skill_text[15][2][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>нанёс{$sex_a} silniy <font class=atype>режущий  </font> удар кинжалом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[15][2][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>у{$ushol} в сторону, и нанес{$sex_la} silniy <font class=atype>режущий </font> удар кинжалом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_block[15][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>режущий </font> удар кинжалом {$po_mestu[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[15][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>режущий </font> удар кинжалом {$po_mestu[$kickto]}, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[15][2] = 1;
$game_skill_canblock[15][2] = 1;
$game_skill_wepon[15][2] = 5;
$game_skill_canmiss[15][2] = 1;
$game_skill_bad[15][2] = 1;
$game_skill_same_room[15][2] = 1;
$game_skill_type[15][2] = 1;
$game_skill_percent[15][2] = 0;
$game_skill_name[15][3] = "Удар в горло";
$game_skill_afflict_percent[15][3] = 30;
if ( $num == 3 )
{
    $kickto = 1;
}
$game_skill_afflict[15][3] = ",aff_bleed_power=25,aff_bleed_time={$cur_time}+5*12";
$game_skill_afflict_text[15][3] = "[<b>{$target_name}</b>] <font class=italic><b>{$target_name}</b> истекает кровью.</font>";
$game_skill_dmg[15][3] = $dex_dmg * 1.8;
$game_skill_mana[15][3] = 15;
$game_skill_textnum[15][3] = 2;
$game_skill_text[15][3][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>нанес{$sex_a} silniy удар кинжалом в <font class=atype><b>горло </b></font> {$sopernika2}.";
$game_skill_text[15][3][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>провел{$sex_a}  silniy удар кинжалом <font class=atype><b>в горло </b></font> {$sopernika2}.";
$game_skill_block[15][3] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>проводил{$sex_a} удар кинжалом <font class=atype><b>в горло</b></font>, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[15][3] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>проводил{$sex_a} удар кинжалом <font class=atype><b>в горло</b></font>, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[15][3] = 1;
$game_skill_canblock[15][3] = 1;
$game_skill_wepon[15][3] = 5;
$game_skill_canmiss[15][3] = 1;
$game_skill_bad[15][3] = 1;
$game_skill_same_room[15][3] = 1;
$game_skill_type[15][3] = 1;
$game_skill_percent[15][3] = 0;
if ( $num == 4 )
{
    $kickto = rand( 1, 2 );
}
$game_skill_name[15][4] = "Удар сзади";
$game_skill_mana[15][4] = 25;
if ( $cur_time < $pl_aff_invis[$player_id] && $pl_aff_see[$target_id] < $cur_time )
{
    $game_skill_afflict_percent[15][4] = 100;
    $game_skill_afflict[15][4] = ",aff_bleed_power=35,aff_bleed_time={$cur_time}+4*12";
    $game_skill_afflict_text[15][4] = "[<b>{$target_name}</b>] <font class=italic><b>{$target_name}</b> истекает кровью.</font>";
    $game_skill_dmg[15][4] = $dex_dmg * 2.8;
    $game_skill_textnum[15][4] = 2;
    $game_skill_text[15][4][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>скрытно подо{$ushol} к {$sopernika4} и провёл{$sex_a} silniy удар кинжалом <font class=atype><b>в спину</b></font>.";
    $game_skill_text[15][4][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>подкрал{$las} к {$sopernika4} и нанес{$sex_a} silniy удар кинжалом <font class=atype><b>в спину</b></font>.";
    $rn = rand( 1, 2 );
    if ( $pl_block[$target_id] == $kickto )
    {
        if ( $rn == 1 )
        {
            $game_skill_text[15][4][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>скрытно подо{$ushol} к {$sopernika4} и <font color=red>пробив блок </font> провёл{$sex_a} silniy удар кинжалом <font class=atype><b>в спину</b></font>.";
            $game_skill_text[15][4][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>подкрал{$las} к {$sopernika4} и <font color=red>пробив блок </font> нанес{$sex_a} silniy удар кинжалом <font class=atype><b>в спину</b></font>.";
            $game_skill_canblock[15][4] = 0;
        }
        else
        {
            $game_skill_canblock[15][4] = 1;
        }
    }
}
else
{
    $game_skill_dmg[15][4] = 1;
    $game_skill_textnum[15][4] = 1;
    if ( $cur_time < $pl_aff_see[$target_id] )
    {
        $game_skill_text[15][4][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b> попытал{$las} подкрасться, но {$target_name} заметил{$sex2_a} это.";
    }
    else
    {
        $game_skill_text[15][4][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b> попытал{$las} подкрасться к {$sopernika4}, но безуспешно.";
    }
}
$game_skill_block[15][4] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>проводил{$sex_a} удар кинжалом <font class=atype><b>в спину</b></font>, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[15][4] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>проводил{$sex_a} удар кинжалом <font class=atype><b>в спину</b></font>, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[15][4] = 1;
$game_skill_wepon[15][4] = 5;
$game_skill_canmiss[15][4] = 0;
$game_skill_bad[15][4] = 1;
$game_skill_same_room[15][4] = 1;
$game_skill_type[15][4] = 1;
$game_skill_percent[15][4] = 0;
if ( $pl_emune[$target_id] & 1 )
{
    $game_skill_afflict_percent[$skill_id][$num] = 0;
    $game_skill_afflict[$skill_id][$num] = "";
}
?>
