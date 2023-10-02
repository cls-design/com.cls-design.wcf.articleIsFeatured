<?php

use wcf\system\database\table\column\DefaultFalseBooleanDatabaseTableColumn;
use wcf\system\database\table\PartialDatabaseTable;

return  [
	PartialDatabaseTable::create('wcf1_article')
		->columns([
			DefaultFalseBooleanDatabaseTableColumn::create('articleIsFeatured')
		]),
];