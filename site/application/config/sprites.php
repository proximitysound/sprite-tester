<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Global Arrays **/

$config['version'] = '0.4.1'; // Current Version

$UPLOADGROUP = array('Admin','Manager','Tester','Artist');
$config['uploadGroup'] = $UPLOADGROUP;

$TESTERGROUP = array('Admin','Manager','Tester');
$config['testerGroup'] = $TESTERGROUP;

$MANAGERGROUP = array('Admin','Manager',);
$config['managerGroup'] = $MANAGERGROUP;

$FEEDBACK = array(
	'1' => 'Technical Issue',
	'2' => 'Creative Feedback',
	'3' => 'General Note',
	'4' => 'Site Feedback'
	);
$config['feedback_type'] = $FEEDBACK;

$PROGRESS = array(
'0' => '',
'1' => 'Stand',
'2' => 'Stand (up)',
'3' => 'Stand (down)',
'4' => 'Walk',
'5' => 'Walk (up)',
'6' => 'Walk (down)',
'7' => 'Tall grass',
'8' => 'Tall grass (up)',
'9' => 'Tall grass (down)',
'10' => 'Walk upstairs (1F)',
'11' => 'Walk upstairs (2F)',
'12' => 'Walk downstairs (2F)',
'13' => 'Walk downstairs (1F)',
'14' => 'Swim',
'15' => 'Swim (up)',
'16' => 'Swim (down)',
'17' => 'Tread water',
'18' => 'Tread water (up)',
'19' => 'Tread water (down)',
'20' => 'Attack',
'21' => 'Attack (up)',
'22' => 'Attack (down)',
'23' => 'Sword primed',
'24' => 'Sword primed (up)',
'25' => 'Sword primed (down)',
'26' => 'Spin attack',
'27' => 'Spin attack (left)',
'28' => 'Spin attack (up)',
'29' => 'Spin attack (down)',
'30' => 'Poke',
'31' => 'Poke (up)',
'32' => 'Poke (down)',
'33' => 'Dash charge',
'34' => 'Dash charge (up)',
'35' => 'Dash charge (down)',
'36' => 'Dash',
'37' => 'Dash (up)',
'38' => 'Dash (down)',
'39' => 'Bonk',
'40' => 'Bonk (up)',
'41' => 'Bonk (down)',
'42' => 'Fall',
'43' => 'Zap',
'44' => 'Death',
'45' => 'Asleep',
'46' => 'Awake',
'47' => 'Grab',
'48' => 'Grab (up)',
'49' => 'Grab (down)',
'50' => 'Lift',
'51' => 'Lift (up)',
'52' => 'Lift (down)',
'53' => 'Carry',
'54' => 'Carry (up)',
'55' => 'Carry (down)',
'56' => 'Throw',
'57' => 'Throw (up)',
'58' => 'Throw (down)',
'59' => 'Push',
'60' => 'Push (up)',
'61' => 'Push (down)',
'62' => 'Tree pull',
'63' => 'Item get',
'64' => 'Crystal get',
'65' => 'Boss kill',
'66' => 'File select',
'67' => 'Dungeon map',
'68' => 'World map',
'69' => 'Bow',
'70' => 'Bow (up)',
'71' => 'Bow (down)',
'72' => 'Boomerang',
'73' => 'Boomerang (up)',
'74' => 'Boomerang (down)',
'75' => 'Hookshot',
'76' => 'Hookshot (up)',
'77' => 'Hookshot (down)',
'78' => 'Powder',
'79' => 'Powder (up)',
'80' => 'Powder (down)',
'81' => 'Rod',
'82' => 'Rod (up)',
'83' => 'Rod (down)',
'84' => 'Bombos',
'85' => 'Ether',
'86' => 'Quake',
'87' => 'Hammer',
'88' => 'Hammer (up)',
'89' => 'Hammer (down)',
'90' => 'Shovel',
'91' => 'Swag duck',
'92' => 'Bug net',
'93' => 'Read book',
'94' => 'Prayer',
'95' => 'Cane',
'96' => 'Cane (up)',
'97' => 'Cane (down)',
'98' => 'Bunny stand',
'99' => 'Bunny stand (up)',
'100' => 'Bunny stand (down)',
'101' => 'Bunny walk',
'102' => 'Bunny walk (up)',
'103' => 'Bunny walk (down)',
);
$config['progress'] = $PROGRESS;


