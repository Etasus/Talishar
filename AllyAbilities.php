<?php

function PlayAlly($cardID, $player, $subCards="-")
{
  $allies = &GetAllies($player);
  array_push($allies, $cardID);
  array_push($allies, 2);
  array_push($allies, AllyHealth($cardID));
  array_push($allies, 0);//Frozen
  array_push($allies, $subCards);//Subcards
  array_push($allies, GetUniqueId());//Unique ID
  array_push($allies, AllyEntersArenaCounters($cardID));//Misc Counters
  array_push($allies, 0);//Life Counters
  array_push($allies, 1);//Ability/effect uses
  if($cardID == "UPR414") { WriteLog("Ouvia lets you transform an ashling."); Transform($player, "Ash", "UPR042"); }
  return count($allies) - AllyPieces();
}

function DestroyAlly($player, $index)
{
  $allies = &GetAllies($player);
  AllyDestroyAbility($player, $allies[$index]);
  for($j = $index+AllyPieces()-1; $j >= $index; --$j)
  {
    unset($allies[$j]);
  }
  $allies = array_values($allies);
}

function AllyHealth($cardID)
{
  switch($cardID)
  {
    case "MON219": return 6;
    case "MON220": return 6;
    case "UPR406": return 6;
    case "UPR407": return 5;
    case "UPR408": return 4;
    case "UPR409": return 3;
    case "UPR410": return 2;
    case "UPR411": return 2;
    case "UPR412": return 6;
    case "UPR413": return 7;
    case "UPR414": return 4;
    case "UPR415": return 4;
    case "UPR416": return 1;
    case "UPR417": return 3;
    default: return 1;
  }
}

function AllyDestroyAbility($player, $cardID)
{
  global $mainPlayer;
  switch($cardID)
  {
    case "UPR410": if($player == $mainPlayer) GainActionPoints(1); break;
    default: break;
  }
}

function AllyStartTurnAbilities($player)
{
  $allies = &GetAllies($player);
  for($i=0; $i<count($allies); $i+=AllyPieces())
  {
    switch($allies[$i])
    {
      case "UPR414": WriteLog("Ouvia lets you transform an ashling."); Transform($player, "Ash", "UPR042"); break;
      default: break;
    }
  }
}

function AllyEntersArenaCounters($cardID)
{
  switch($cardID)
  {
    case "UPR417": return 1;
    default: return 0;
  }
}

function AllyDamagePrevention($player, $index, $damage)
{
  $allies = &GetAllies($player);
  $cardID = $allies[$index];
  switch($cardID)
  {
    case "UPR417":
      if($allies[$index+6] > 0)
      {
        $damage -= 3;
        if($damage < 0) $damage = 0;
        --$allies[$index+6];
      }
      return $damage;
    default: return $damage;
  }
}

?>
