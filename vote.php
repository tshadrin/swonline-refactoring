<?php
$add_vote = "";
$i = 0;
$max = 0;

$SQL = "select id, text from sw_website_vote where active=1 LIMIT 0,1";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $voteId= $row_num[0];
    $voteText = $row_num[1];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
	
if(isset($voteId) && is_numeric($voteId))
{
	$voteId = (integer)$voteId;

	$SQL = "SELECT id, answer, nb FROM sw_website_vote_answer WHERE  pollid = $voteId";
	$row_num = sql_query_num( $SQL );
	while ( $row_num )
	{
		++$i;
		$voteAnsId[$i] = $row_num[0];
		$voteAnswer[$i] = $row_num[1];
		$voteNb[$i] =$row_num[2];
		$max += $row_num[2];
		$row_num = sql_next_num( );
	}
	if ( $result )
	{
		mysqli_free_result( $result );
	}
	if ( $max == 0 )
	{
		$max = 1;
	}
	
	if ( isset( $dovote ) && $dovote == "true" )
	{
		for ($k = 1 ; $k <= $i; ++$k )
		{
			if ( $vote == $voteAnsId[$k] )
			{
				$ip = getip( );
				$SQL = "select count(*) as num from sw_website_vote_results where ip='{$ip}' and pollid={$voteId}";
				$row_num = sql_query_num( $SQL );
				while ( $row_num )
				{
					$c_num = $row_num[0];
					$row_num = sql_next_num( );
				}
				if ( $result )
				{
					mysqli_free_result( $result );
				}
				if ($c_num != 0)
				{
					$add_vote = "Ваш голос не добавлен<br>";
					break;
				}
				else
				{
					$SQL = "Insert into sw_website_vote_results (pollid,votedFor,ip) values ({$voteId}, {$voteAnsId[$k]}, '{$ip}')";
					sql_do( $SQL );
					$SQL = "Update sw_website_vote_answer set nb=nb+1 where id={$voteAnsId[$k]}";
					sql_do( $SQL );
					++$voteNb[$k];
					++$max;
					$add_vote = "Ваш голос добавлен<br>";
					break;
				}
			}
			else
			{
				$add_vote = "Ваш голос не добавлен<br>";
			}
		}
	}
	
	for ($k=1 ; $k <= $i; ++$k )
	{
		 if ( $k == 1 ) 
			print "<form action=index.php method=post><table width=95% align=center><input type=hidden name=load value={$load}><input type=hidden name=dovote value=true><tr><td align=center class=vote>{$add_vote}<b>{$voteText}</b></td></tr></table>";
	   

		$per = round( $voteNb[$k] / $max * 100 * 1.2 );
		$per2 = 120 - $per;
			$per2 = 120 - $per;
		print "<table width=130 align=center cellpadding=0 cellspacing=1><tr><td width=10>
		<input type=radio name=vote value={$voteAnsId[$k]} class=votearea></td>
		<td class=ssmall align=left width=110 align=right>{$voteAnswer[$k]} </td><td width=10>
		<font class=ans>({$voteNb[$k]})</font></td></tr><tr><td colspan=3 align=center>
		<table width=100 height=5 bgcolor=A6B1A6 cellpadding=0 cellspacing=1 align=center><tr>";
		
		if ($per > 0 )
		{
			print "<td bgcolor=C6D3C6 width={$per}></td>";
		}
		if ($per2 > 0 )
		{
			print "<td bgcolor=EDF1F1 width={$per2}></td>";
		}
		print "</tr></table></td><td></td></tr>";
	}
	print "</table>";
	if ( $i != 0 )
	{
		print "<table width=70% align=center><tr><td align=center><input type=submit value=Голосовать class=button></td></tr></table></form>";
	}
}else{
	print "<table  width=95% align=center cellpadding=0 cellspacing=1><tr><TD align='center'><b>Нет активных голосований.</b></TD></tr></table>
	<table width=130 align=center cellpadding=0 cellspacing=1><tr><td width=10></td>
		<td class=ssmall align=left width=110 align=right></td><td width=10></td></tr>";
}

	
?>
