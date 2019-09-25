<?php
namespace helpers;

class Board
{
	public static function draw(Array $intersections, $whoPlaysNext): String
	{

		$html = '<table style="background-color: grey;" >';
			$rows = count($intersections)+1;
			for($i=0; $i<$rows; $i++){
				$html .= '<tr>';
				for($g=0; $g<$rows; $g++){
					$html .= '<td style="border: solid 1px; height: 50px; width: 50px;">';
					$html .= '</td>';
				}
				$html .= '</tr>';
			}
		$html .= '</table>';

		$html .= '<table style="position:absolute;z-index:100;left:37px;top:37px;" >';
			foreach ($intersections as $row => $intersection){
				$html .= '<tr>';
					foreach ($intersection as $col => $stoneColor){
						$html .= '<td style="border: solid 1px transparent; height: 50px; width: 50px; background-color: '.$stoneColor.'" >';
							$html .= self::addStoneLink($whoPlaysNext, $row, $col);
								$html .= '<div style="width: 50px; height: 50px;" ></div>';
							$html .= '</a>';
						$html .= '</td>';
					}
				$html .= '</tr>';
			}
		$html .= '</table>';

		return $html;
	}

	public static function addStoneLink($whoPlaysNext, $row, $col){
		return '<a href="/place_'.$whoPlaysNext.'_stone/'. $row .'/'. $col .'" >';
	}

	public static function t($word){
		$translations = [
			'black' => 'Negro',
			'white' => 'Blanco'
		];
		return $translations[$word];
	}
}