<?php 
namespace player128\AmoApi\Support;

// Функция для 'красивого' вывода массиово и объектов
function Aprint_r($array)
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}
// Вывод значения с переносом до и после строки
function Aecho($value)
{
	echo "<br>".$value."<br>";
}