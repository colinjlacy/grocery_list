<?php
/**
 * Created by PhpStorm.
 * User: colinjlacy
 * Date: 6/26/14
 * Time: 8:49 AM
 */

namespace classes;


class PDF {
    private function url_string() {
        $list = $_GET;
        return $list;
    }

    public function pdf_config() {

        $config_data = array(
            // metadata
            'creator' => "Colin J Lacy",
            'keywords' => "grocery, list",

            // formatting
            'left_margin' => 30,
            'top_margin' => 20,
            'right_margin' => 30

        );

        return $config_data;
    }

    public function data_pull() {

        $list = $this->url_string();

        $id = $list['id'];
        $title = $list['title'];

        include("inc/db.inc");

        // if no db connection info, then you can't connect
        if(!$con) {

            // let somebody know
            die('Could not connect: ' . mysqli_error($con));

        }

        // build the list query
        $items_sql = "SELECT * FROM list_items WHERE list_id = '$id'";

        // execute the query and save the returned object
        $retval = mysqli_query($con, $items_sql);

        // if no returned object
        if(!$retval) {

            // let somebody know
            die('Could not retrieve data ' . mysqli_error($con));

        // if there is a returned object
        } else {

            // return the ID of the inserted row
            $items = array();

            while($row = $retval -> fetch_assoc()) {

                $items[] = $row;

            }

        }

        $print_list = array(
            'title' => $title,
            'items' => $items
        );

        return $print_list;

    }

    public function templatize_data($data_array, $username) {

        $html = file_get_contents('views/pdf-header.html');

        $html .= "<h1>" . $data_array['title'] . "</h1>";
        $html .= "<p>A grocery list, by <strong>" . $username . "</strong></p>";

        $i = 1;

        $html .= '<table cellpadding="10"><tbody>';

        foreach($data_array['items'] as $item) {
            $html .= "<tr><td>" . $i . ". " . $item['name'] . "</td></tr>";
            $i++;
        }

        $html .= "</tbody></table>";

        return $html;

    }

    public function logging($file, $log_entry) {
        file_put_contents($file, $log_entry, FILE_APPEND | LOCK_EX);
    }

}