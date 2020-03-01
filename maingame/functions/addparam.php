<?
function addparametr()
{
	global $param,$player_id,$race_str,$race_dex,$race_int,$race_wis,$race_con,$result;
	$param = (integer) $param;
	$p=array();
	$p[1] = 'str';
	$p[2] = 'dex';
	$p[3] = 'intt';
	$p[4] = 'wis';
	$p[5] = 'con';
	$par = $p[$param];
	if ($par <> '')
	{
		$SQL="select h_up from sw_users where id=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$h_up=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		If ($h_up > 0)
		{
				$h_up--;
				$SQL="UPDATE sw_users SET $par=$par+1,h_up=$h_up where id=$player_id";
				SQL_do($SQL);
				getinfo($player_id);
		}
	}
}

?>