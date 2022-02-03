<?php
const BOARDSIZE = 5; 
const GUESSES = 15; 
const MAXHITS = 6;
const MAXSHIPS = 3;

$board = array_fill(0,BOARDSIZE,array_fill(0,BOARDSIZE,"🌫")); 
$board2 = array_fill(0,BOARDSIZE,array_fill(0,BOARDSIZE,"🌫")); 

print ("Let's play Battleships!\n"); 
//print($board); 

function print_board($board){ 
    foreach($board as $row){ 
        foreach($row as $element){ 
            print("$element"); 
        } 
        print("\n"); 
    } 
} 

function random_pos(){ 

    return rand(0, BOARDSIZE-1); 

} 

function explode_ship(){
    $explosion = 1;
    return $explosion;
}


function no_dupes(array $input_array) {
    return count($input_array) === count(array_flip($input_array));//works by merging to of the same values together   together
}

print_board($board); 
//print_board($board2); 
$player1_current_ships = 0;
$player2_current_ships = 0;



function set_up_game(&$p_player1_ship_row_array, &$p_player1_ship_col_array, &$p_player2_ship_row_array, &$p_player2_ship_col_array){

$current_players_set = 0;
while($current_players_set < 2){


$p_ship_row_array = array();
$p_ship_col_array = array();

    
$ships_set_up = false; 

while($ships_set_up == false){

$ship_row = random_pos(); 
$ship_col = random_pos(); 
array_push($p_ship_row_array, $ship_row);
array_push($p_ship_col_array, $ship_col);

$ship2_row = random_pos(); 
$ship2_col = random_pos(); 


while(($ship2_row== $ship_row)&&($ship2_col == $ship_col)){
    $ship2_row = random_pos(); 
    $ship2_col = random_pos();  
}
array_push($p_ship_row_array,$ship2_row);
array_push($p_ship_col_array,$ship2_col);

$row_or_col = rand(1,2);
if($row_or_col == 1){
    $ship2_row_tail = $ship2_row;
    $ship2_col_tail = $ship2_col +1;
    if($ship2_col_tail > BOARDSIZE-1){
        $ship2_col_tail = $ship2_col -1;
    }
}else{
    $ship2_col_tail = $ship2_col;
    $ship2_row_tail = $ship2_row +1;
    if($ship2_row_tail > BOARDSIZE-1){
        $ship2_row_tail = $ship2_row -1;
    }
}

array_push($p_ship_row_array, $ship2_row_tail);
array_push($p_ship_col_array, $ship2_col_tail);

$ship3_row = random_pos(); 
$ship3_col = random_pos(); 
while(($ship3_row== $ship_row)&&($ship3_col == $ship_col)|| ($ship3_row== $ship2_row)&&($ship3_col == $ship2_col) ){
    $ship2_row = random_pos(); 
    $ship2_col = random_pos();  
}
array_push($p_ship_row_array, $ship3_row);
array_push($p_ship_col_array, $ship3_col);

$row_or_col = rand(1,2);


if($row_or_col == 1){
    $ship3_row_tail = $ship3_row;
    $ship3_col_tail = $ship3_col +1;
    
    if($ship3_col_tail > BOARDSIZE-1){
        $ship3_col_tail = $ship3_col -1;
    }
}else{
    $ship3_col_tail = $ship3_col;
    $ship3_row_tail = $ship3_row +1;
    if($ship3_row_tail > BOARDSIZE-1){
        $ship3_row_tail = $ship3_row -1;
    }
}

if($row_or_col == 1){
    $ship3_row_extend = $ship3_row;
    $ship3_col_extend = $ship3_col +2;

    if($ship3_col_extend > BOARDSIZE-1){
        $ship3_col_extend = $ship3_col -1;
    }
}else{
    $ship3_col_extend = $ship3_col;
    $ship3_row_extend = $ship3_row +2;
    if($ship3_row_extend > BOARDSIZE-1){
        $ship3_row_extend = $ship3_row -1;
    }
}


array_push($p_ship_row_array , $ship3_row_tail);
array_push($p_ship_col_array ,$ship3_col_tail);
array_push($p_ship_row_array ,$ship3_row_extend);
array_push($p_ship_col_array ,$ship3_col_extend);

$length=count($p_ship_row_array);
$ships_rows_cols = array();

for($i=0;$i<$length-1;$i++){
    array_push($ships_rows_cols ,"(".$p_ship_row_array[$i].",".$p_ship_col_array[$i].")");
}

$ships_set_up = no_dupes($ships_rows_cols);

if (in_array(6, $p_ship_row_array)|| in_array(-1, $p_ship_row_array)|| in_array(6, $p_ship_col_array)||in_array(-1, $p_ship_row_array)){
    $ships_set_up = false;
}

if($current_players_set < 1){
    $p_player1_ship_row_array = $p_ship_row_array;
    $p_player1_ship_col_array = $p_ship_col_array;
}else{
    $p_player2_ship_row_array = $p_ship_row_array;
    $p_player2_ship_col_array = $p_ship_col_array;
}

}//end inner while
$current_players_set ++;

}//end outer while

}//end set up game function

function instance_of_game(&$p_ship_row_array, &$p_ship_col_array,&$p_board, &$p_current_ships, &$p_ship2_parts,&$p_ship3_parts, &$p_turn , &$p_guess_row, &$p_guess_col ){

    
    if(($p_guess_row =="") || ($p_guess_col == "") ||
           ($p_guess_row < 0) || ($p_guess_col < 0) ||
           ($p_guess_row > BOARDSIZE) || ($p_guess_col > BOARDSIZE))
        {
            print("Oops, that's not even in the ocean. \n");
        } else
    if(($p_guess_row == $p_ship_row_array[0])&&($p_guess_col == $p_ship_col_array[0])){
        print ("Congratulations! You sunk my 1st battleship!\n");
        $p_board[$p_guess_row][$p_guess_col] = "💥";
        
        $p_current_ships += explode_ship();
        
    } else if(($p_guess_row == $p_ship_row_array[1])&&($p_guess_col == $p_ship_col_array[1])|| ($p_guess_row == $p_ship_row_array[2])&&($p_guess_col == $p_ship_col_array[2])){
        $p_ship2_parts --;
        echo("you have hit a ship!");
        $p_board[$p_guess_row][$p_guess_col] = "💥";
        if($p_ship2_parts == 0){
            print ("Congratulations! You sunk my 2nd battleship!\n");
            $p_current_ships += explode_ship();
        }
        
        
    }else if(($p_guess_row == $p_ship_row_array[3])&&($p_guess_col == $p_ship_col_array[3]) || ($p_guess_row == $p_ship_row_array[4])&&($p_guess_col == $p_ship_col_array[4]) || ($p_guess_row == $p_ship_row_array[5])&&($p_guess_col == $p_ship_col_array[5])){
        $p_ship3_parts --;
        echo("you have hit a ship!");
        $p_board[$p_guess_row][$p_guess_col] = "💥";
        if($p_ship3_parts == 0){
            print ("Congratulations! You sunk my 3rd battleship!\n");
            $p_current_ships += explode_ship();
        }
        
    }else if ($p_board[$p_guess_row][$p_guess_col] == "🌊") {
        print("You guesses that one already. \n");
    }
    else {
        print ("You missed my battleship!\n");
        $p_board[$p_guess_row][$p_guess_col] = "🌊";
        if ($p_turn == GUESSES){
            print("Game over you lost!\n");
            $p_board[$p_ship_row_array[0]][$p_ship_col_array] = "⛴";
            $p_board[$p_ship_row_array[1]][$p_ship_col_array] = "⛴";
            $p_board[$p_ship_row_array[2]][$p_ship_col_array] = "⛴";
            $p_board[$p_ship_row_array[3]][$p_ship_col_array] = "⛴";
            $p_board[$p_ship_row_array[4]][$p_ship_col_array] = "⛴";
            $p_board[$p_ship_row_array[5]][$p_ship_col_array] = "⛴";
     }
    }
    
    printf ("After guess %s of %s\n",$p_turn,GUESSES);
    print_board($p_board);
    $p_turn++;
    
}

$player1_ship_row_array = array();
$player1_ship_col_array = array();
$player2_ship_row_array = array();
$player2_ship_col_array = array();

set_up_game($player1_ship_row_array, $player1_ship_col_array, $player2_ship_row_array, $player2_ship_col_array);




$player1_turn = 1;
$player1_ship2_parts = 2;
$player1_ship3_parts = 3;
$player2_turn = 1;
$player2_ship2_parts = 2;
$player2_ship3_parts = 3;

echo("PLayer 1..\n");
printf ("Battleship 1 at (%s,%s)\n",$player1_ship_row_array[0],$player1_ship_col_array[0]); 
printf ("Battleship 2 at (%s,%s), (%s,%s)\n",$player1_ship_row_array[1],$player1_ship_col_array[1], $player1_ship_row_array[2],$player1_ship_col_array[2]); 
printf ("Battleship 3 at (%s,%s), (%s,%s), (%s,%s)\n",$player1_ship_row_array[3],$player1_ship_col_array[3], $player1_ship_row_array[4], $player1_ship_col_array[4], $player1_ship_row_array[5], $player1_ship_col_array[5]); 

echo("PLayer 2..\n");
printf ("Battleship 1 at (%s,%s)\n",$player2_ship_row_array[0],$player2_ship_col_array[0]); 
printf ("Battleship 2 at (%s,%s), (%s,%s)\n",$player2_ship_row_array[1],$player2_ship_col_array[1], $player2_ship_row_array[2],$player2_ship_col_array[2]); 
printf ("Battleship 3 at (%s,%s), (%s,%s), (%s,%s)\n",$player2_ship_row_array[3],$player2_ship_col_array[3], $player2_ship_row_array[4], $player2_ship_col_array[4], $player2_ship_row_array[5], $player2_ship_col_array[5]); 


$rotate_players = false;
while(($player1_current_ships != MAXSHIPS)|| ($player2_current_ships != MAXSHIPS) ||($player1_turn != GUESSES)|| ($player2_turn != GUESSES)){

if($rotate_players == false){
    echo("Player 1's turn");
    $guess_row = readline("Guess a row: ");
    $guess_col = readline("Guess a column: ");
    instance_of_game($player1_ship_row_array, $player1_ship_col_array,$board, $player1_current_ships, $player1_ship2_parts,$player1_ship3_parts, $player1_turn, $guess_row,$guess_col);
    $rotate_players = true;
}else{
    echo("Player 2's turn"); 
    $guess_row = readline("Guess a row: ");
    $guess_col = readline("Guess a column: ");
    instance_of_game($player2_ship_row_array, $player2_ship_col_array,$board2, $player2_current_ships, $player2_ship2_parts,$player2_ship3_parts, $player2_turn, $guess_row,$guess_col);
    $rotate_players = false;
}

if($player1_current_ships == MAXSHIPS){
    break;
}

}//end while loop

if($player1_current_ships == MAXSHIPS){
    print("game over player1 has won!");
}else if($player2_current_ships == MAXSHIPS){
    print("game over player2 has won!");
}


?>