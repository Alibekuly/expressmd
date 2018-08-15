<?php
require_once 'simple_html_dom.php'; // библиотека для парсинга

for ($i=30; $i < 38; $i++) { 
	$html = file_get_html('http://www.integra-international.net/firms/directory/contacts?page='.$i.'&firm=*&country=*&city=*&filter=All'); 
	$y = 1;
	foreach($html->find('tr') as $element) 
		foreach($element->find('td') as $td) 
			if ($y % 2 == 0){
	       		echo $td . '<br>';
	       		$y++;
			}else{
				$y++;
			}
}

?>