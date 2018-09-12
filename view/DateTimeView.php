<?php

class DateTimeView {
	
	public function show() {
		$timeString = date('Y-m-d H:i:s'); 
		return '<p>' . $timeString . '</p>';
	}
}