<?php

function get_keys($arr, $path = '', $depth = 0)
{
	$return = array();
	if($depth > 0)
	{
		$path .= '.';
	}
	if(++$depth < 10)
	{
		foreach($arr as $key => $val)
		{
			$return[$id] = $id = $path . $key;
			if (is_array($val))
			{
				$return = array_merge($return, get_keys($val, $id, $depth));
			}
		}
	}
	return $return;
}

function show_error($message)
{
	$return = '<style type="text/css">* { font-size: 12px; font-family: Arial; color: #333333; }' . PHP_EOL;
	$return .= 'h1 { color: #FFFFFF; margin: 0px; font-size: 24px; border-bottom: 1px solid #CCCCCC; background-color: #333333; padding: 10px; }' . PHP_EOL;
	$return .= 'p { padding: 15px; margin: 0px; }' . PHP_EOL;
	$return .= '</style>' . PHP_EOL;
	
	$return .= '<div style="width: 500px; margin: 0 auto; border: 1px solid #CCCCCC; background-color: #F4F4F4;">' . PHP_EOL
			. '<h1>MongoDB Error</h1>' . PHP_EOL
			. '<p>' . $message . '</p>' . PHP_EOL
			. '</div>';
	die($return);
}

function pagination($current_page = 1, $limit, $total, $link)
{
	$return = '<div class="pagination">' . PHP_EOL;

	$total_pages = ceil($total / $limit);
	$num_links = 10;
	$mid_way = floor($num_links / 2);
	
	if($num_links >= $total_pages)
	{
		$start = 1;
		$end = $total_pages;
	}
	elseif($current_page > $mid_way)
	{
		$start = $current_page - ($mid_way - 1);
		$end = $current_page + $mid_way;
	}
	elseif($current_page <= $mid_way)
	{
		$start = 1;
		$end = $num_links;
	}
	
	if($end > $total_pages)
	{
		$start = $total_pages - ($num_links - 1);
		$end = $total_pages;
	}
	
	if($current_page != 1)
	{
		$return .= '<a href="' . $link . '&amp;p=1">&laquo;</a>';		
		$return .= '<a href="' . $link . '&amp;p=' . ($current_page - 1) . '">&lsaquo;</a>';		
	}

	for($i = $start; $i <= $end; $i++)
	{
		$return .= '<a href="' . $link . '&amp;p=' . $i . '"' . (($current_page == $i) ? ' class="current"' : '') . '>' . $i . '</a>';
	}
	
	if($current_page != $total_pages)
	{
		$return .= '<a href="' . $link . '&amp;p=' . ($current_page + 1) . '">&rsaquo;</a>';
		$return .= '<a href="' . $link . '&amp;p=' . $total_pages . '">&raquo;</a>';		
	}
	
	$start_obj = (($current_page - 1) * $limit);
	$end_obj = ((($current_page - 1) * $limit) + $limit);
	if($end_obj > $total)
	{
		$end_obj = $total;
	}
	$return .= '&nbsp;&nbsp;Currently showing ' . $start_obj . '-' . $end_obj . ' out of ' . $total . '.';
	$return .= '</div>';
	
	return $return;
}

function a($text, $url, $extras = '')
{
	$return = '<a href="' . $url . '"';
	$return .= (($extras != '') ? ' ' . $extras : '') . '>';
	$return .= $text . '</a>';
	
	return $return;
}

function url($db = NULL, $collection = NULL, $action = NULL, $offset = NULL, $sort = NULL, $extras = '')
{
	if($db === NULL)
	{
		return $_SERVER['PHP_SELF'];
	}
	$return = $_SERVER['PHP_SELF'] . '?';
	$return .= 'db=' . $db;
	$return .= ($collection !== NULL) ? '&amp;c=' . $collection : '';
	$return .= ($offset !== NULL) ? '&amp;o=' . $offset : '';
	if($sort !== NULL && is_array($sort))
	{
		foreach($sort as $key => $val)
		{
			$return .= '&amp;sort[' . $key . ']=' . $val;
		}
	}
	$return .= ($action !== NULL) ? '&amp;action=' . $action : '';
	$return .= $extras;
	
	return $return;
}

function breadcrumbs($crumbs)
{
	$return = '<div id="breadcrumbs">';
//	$return .= '<strong>Breadcrumbs: </strong>';
	for($i = 0; $i < count($crumbs); $i++)
	{
		$return .= $crumbs[$i];
		if($i + 1 != count($crumbs))
		{
			$return .= ' &rsaquo; ';
		}
	}
	$return .= '</div>';
	
	return $return;
}