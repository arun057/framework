<?php
function find_grandchildren($categories, $parent, $page_categories) {
    $gc = '';
    foreach ($categories as $category) {
        $checked =  (isset($page_categories)) ?  
            ((array_search ($category->id, $page_categories) !== FALSE) ? 'checked' : '') : '';

        // if child category
        if (($category->parent_id == $parent) && $category->id != 0) {
            $input = '<input type="checkbox" name="categorys[]" value="'. $category->id . '" ' . $checked . ' />';
            $gc .= '<li style="list-style:none">' . $input . $category->name . '</li>';
        }
    }
    return $gc;
}

function list_categories($categories, $parent, $close_ul, $all_categories, $page_categories) {

    foreach( $categories as $category ) {

        //        echo $category->parent_id . ',' . $category->id . ' => ' . $category->name . '<br/>';

        if( empty( $category->name )) continue;

        $checked =  (isset($page_categories)) ?  
            ((array_search ($category->id, $page_categories) !== FALSE) ? 'checked' : '') : '';

        // if child category
        if (($category->parent_id == $parent) && $category->id != 0) {
            $grandchildren = find_grandchildren($all_categories, $category->id, $page_categories);
            $input = ($grandchildren) ? '' : '<input type="checkbox" name="categorys[]" value="'. $category->id . '" ' . $checked . ' />';
            echo '<li style="list-style:none">' . $input . $category->name;
            if ($grandchildren) 
                echo '<ul style="margin-left: -30px; font-size:9px">' . $grandchildren . '</ul>';
            echo '</li>';
        }
        else if ($category->id == 0) {
            $parent = $category->parent_id;
            echo '</ul>';
            echo '<div class="cms_category">' . $category->name . '</div><ul style="margin-left: -20px; font-size:9px">';
        }
    }
}

?>