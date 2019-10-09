<?php

/**
	PHP >=7.0
	Step 1 - First, open control terminal
	Step 2 - Then execute : php hangman.php
	Step 3 - Finally...  Enjoy
**/

function display_UTF8_Hangman($list_utf8_hangman, $attempt) : void
{
	if (array_key_exists($attempt, $list_utf8_hangman))
	{
		echo $list_utf8_hangman[$attempt] . PHP_EOL;
	}
}

function display_word($word) : void
{
	foreach($word as $letter)
	{
		echo $letter;
	}
	echo "\r\n\r\n";
}

function hide_word($word) : array
{
	$hidden_word = [];
	for($i=0; $i<count($word); $i++) 
	{
		$hidden_word[$i] = "_ ";
	}
	return $hidden_word;
}

function pick_word($list_words) : string
{
	$nb = mt_rand(0, count($list_words)-1);
	return $list_words[$nb];
}

function select_letter($list_alphabets, &$list_input)
{
	$letter = strtolower(readline("Enter your letter : \r\n"));
	if (in_array($letter, $list_alphabets))
	{
		if (!in_array($letter, $list_input))
		{
			array_push($list_input, $letter);
			return $letter;
		}
		else
		{
			echo "You have already used this letter ... Please try again!";
			select_letter($list_alphabets, $list_input);
		}
	}
	else
	{
		echo "Please try again, $letter is not a letter. ";
		select_letter($list_alphabets, $list_input);
	}
}

function check_letter(&$hidden_word, $word, $letter) : bool
{
	$check = false;
	for ($i=0; $i<count($word); $i++)
	{
		if ($word[$i] === $letter)
		{
			$hidden_word[$i] = $letter;
			$check = true;
		}
	}
	return $check;
}

function check_word($hidden_word, $word) : bool
{
	if (!array_diff($hidden_word, $word))
	{
		return true;
	}
	return false;
}

function play() : void
{
	$list_alphabets = range('a', 'z');
	$list_words = ["multimedia", "computer", "cartography", "window", "breakfast"];
	$list_utf8_hangman = 
	[
		"6" => "
		#######
		# 
		#
		#
		#
		#
		#
		###", 
		"5" => "
		#######
		#    ███
		#     
		#
		#
		#
		#
		###",
		"4" => "
		#######
		#    ███
		#     █
		#  
		#
		#
		#
		###", 
		"3" => "
		#######
		#    ███
		#     █
		#    ▓ 
		#
		#
		#
		###", 
		"2" => "
		#######
		#    ███
		#     █
		#    ▓ ▒
		#     
		#
		#
		###", 
		"1" => "
		#######
		#    ███
		#     █
		#    ▓ ▒
		#     ▒
		#    
		#
		###", 
		"0" => "
		#######
		#    ███
		#     █
		#    ▓ ▒
		#     ▒
		#    █ █
		###"
	];

	echo "\r\n##############################" . PHP_EOL;
	echo "###---------HANGMAN--------###" . PHP_EOL;
	echo "##############################" . PHP_EOL;

	$attempt = 6;
	$the_end = false;
	$list_input = [];

	$word = str_split(pick_word($list_words));
	$hidden_word = hide_word($word);

	do
	{
		display_word($hidden_word);
		$letter = select_letter($list_alphabets, $list_input);
		foreach($list_input as $k => $input)
		{
			if($k == 0)
			{
				echo "\r\nInput letters list : '$input'";
			}
			else
			{
				echo ", '$input'";
			}
		}
		echo "\n\r";
		$check = check_letter($hidden_word, $word, $letter);
		if(!$check)
		{
			$attempt--;
			echo "Wrong letter, You still have $attempt attempt !\r\n";
		}
		else
		{
			$the_end = check_word($hidden_word, $word);
			if ($the_end)
			{
				display_word($word);
				echo "Congrat.. You win !!!! \r\n";
			}
			else
			{
				echo "Good... Continue ! \r\n";
			}
		}
		display_UTF8_Hangman($list_utf8_hangman, $attempt);
		echo "\r\n#########################\r\n";
	}while(!$the_end && $attempt > 0);

	if ($attempt == 0)
	{
		echo "Game Over !!! Try again\r\n";
	}
}

do
{
	play();
	$replay = readline("Continue Yes or No ?");
}while(strtolower($replay) == 'Yes' or strtolower($replay) == 'y');

