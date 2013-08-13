<?php

//Adds a filter to form id 26. Replace 26 with your actual form id
add_filter( "gform_pre_render_4", sijaishaku_plugin_populate_checkbox );
add_filter( "gform_admin_pre_render_4", sijaishaku_plugin_populate_checkbox );

function sijaishaku_plugin_populate_checkbox( $form ) {

    //Creating choices
    $choices = array(
                    array( "text" => "Test 1", "value" => "test1" ),
                    array( "text" => "Test 2", "value" => "test2" ),
                    array( "text" => "Test 3", "value" => "test3" )
                    );

    $inputs = array(
                    array( "label" => "Test 1", "id" => 4.1 ), //replace 2 in 2.1 with your field id
                    array( "label" => "Test 2", "id" => 4.2 ), //replace 2 in 2.2 with your field id
                    array( "label" => "Test 2", "id" => 4.3 ), //replace 2 in 2.3 with your field id
                );

    //Adding items to field id 2. Replace 2 with your actual field id. You can get the field id by looking at the input name in the markup.
    foreach( $form["fields"] as &$field ){
        //replace 2 with your checkbox field id
        if( $field["id"] == 4 ){
            $field["choices"] = $choices;
            $field["inputs"] = $inputs;
        }
    }

    return $form;
}

?>