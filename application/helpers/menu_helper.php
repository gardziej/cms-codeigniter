<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if (!function_exists('printMenuVertical')) {
    function printMenuVertical($menu)
    {
    	foreach ($menu AS $id => $dane)
    	{
    		echo '<li>';
    		if ($dane['link_typ'] != 0)
    			{
    				echo '<a href="'.$dane['link_value'].'"';
    			}
    			else
    			{
    				echo '<p class="nav-header"';
    			}

    		if (isSet($dane['children']) AND count($dane['children']) > 0)
    			{
    				echo ' class="dropdown-toggle" data-toggle="dropdown" ';
    			}

    		echo '>';

    		echo $dane['tekst'];

    		if ($dane['link_typ'] != 0)
    			{
    				echo '</a>';
    			}
    			else
    			{
    				echo '</p>';
    			}

    		if (isSet($dane['children']) AND count($dane['children']) > 0)
    		{
    			echo '<ul class="nav nav-stacked subMenu">';
    			printMenuVertical($dane['children']);
    			echo '</ul>';
    		}

    		echo '</li>'."\n";

    	}
    }
}



if (!function_exists('printMenuHorizontal')) {
    function printMenuHorizontal($menu)
    {
    	foreach ($menu AS $id => $dane)
    	{
    		echo '<li>';
    		if ($dane['link_typ'] != 0)
    			{
    				echo '<a href="'.$dane['link_value'].'"';
    			}
    			else
    			{
    				echo '<p class="navbar-text"';
    			}

    		if (isSet($dane['children']) AND count($dane['children']) > 0)
    			{
    				echo ' class="dropdown-toggle" data-toggle="dropdown" ';
    			}

    		echo '>';

    		echo $dane['tekst'];

    		if (isSet($dane['children']) AND count($dane['children']) > 0)
    			{
    				echo ' <span class="caret"></span></a>';
    			}

    		if ($dane['link_typ'] != 0)
    			{
    				echo '</a>';
    			}
    			else
    			{
    				echo '</p>';
    			}

    		if (isSet($dane['children']) AND count($dane['children']) > 0)
    		{
    			echo '<ul class="dropdown-menu">';
    			printMenuHorizontal($dane['children']);
    			echo '</ul>';
    		}

    		echo '</li>'."\n";

    	}
    }
}

if (!function_exists('buildTree'))
{
    function buildTree( $ar, $pid = 0 ) {
        $op = array();
        foreach( $ar as $item ) {
            if( $item['parent_id'] == $pid ) {
                $op[$item['id']] = $item;
                // using recursion
                $children =  buildTree( $ar, $item['id'] );
                if( $children ) {
                    $op[$item['id']]['children'] = $children;
                }
            }
        }
        return $op;
    }
}

if (!function_exists('printTree'))
{
    function printTree($menu)
    {
    	foreach ($menu AS $id => $dane)
    	{
    		echo '<li rel="'.$id.'"';
    		echo ' data-link_typ="'.$dane['link_typ'].'"';
    		echo ' data-link_value="'.$dane['link_value'].'"';
    		echo ' data-jstree=\'{ "opened" : true';
    		if ($dane['typ'] != '') echo ', "type":"'.$dane['typ'].'"';
    		echo '}\'>'.$dane['tekst'];
    		if (isSet($dane['children']) AND count($dane['children']) > 0)
    		{
    			echo '<ul>';
    			printTree($dane['children']);
    			echo '</ul>';
    		}
    		echo '</li>';
    	}
    }
}
