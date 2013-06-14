<?php
		$updateRecordsArray     = t3lib_div::_GP("recordsArray");
		$target_table			= t3lib_div::_GP("target");
		$i = 0;
		foreach ($updateRecordsArray as $id => $record_temparr) {
			$arr_ids[$i] = $id;
			$arr_new_sort[$i] = $record_temparr[0];
			$i++;
			$query = "UPDATE records SET recordListingID = " . $listingCounter . " WHERE recordID = " . $recordIDValue;
		};
		sort ($arr_new_sort);
		foreach ($arr_new_sort as $k => $sort_ind) {
			$query = "UPDATE ".$target_table." SET sorting= " . $sort_ind . " WHERE uid = " . $arr_ids[$k];
			mysql_query($query) or die('Error, update query failed');
		};
		echo 'Ok';				
?>