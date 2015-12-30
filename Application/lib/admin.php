<?php

namespace Manara\Business\locator\Application\lib;

use Manara\Business\locator\Application\lib\loadFile;
use Manara\Business\locator\Application\lib\Model;

class Admin {

    protected $view;
    protected $model;

    public function __construct() {
        $this->view = new loadFile();
        $this->model = new Model();
    }

    public function panel() {

        $this->view->render('panel.html.twig'
                , array('menu' => $this->menuBuilderAdmin())
        );
    }

    public function add() {

        //check post code
        $post_code = isset($_POST['postcode']) ? $_POST['postcode'] : null;
        $data = $this->getLatitude($post_code);

        if (isset($_POST['name']) && !is_null($_POST['name'])) {
            $this->model->__save('latitude_manara_business_locator', $_POST);
            $this->redirect('_list');
        }

        // save data
        $this->view->render('add_retailer.html.twig'
                , array('menu' => $this->menuBuilderAdmin(), 'data' => $data)
        );
    }

    public function _list() {

        $data = $this->model->__selects('latitude_manara_business_locator');

        $current_panel = get_current_screen();
        $this->view->render('list_retailer.html.twig'
                , array('menu' => $this->menuBuilderAdmin(), 'data' => $data
            , 'url' =>
            array(
                'edit' => "admin.php?page=" . $current_panel->parent_file . "&p=edit&id=",
                'delete' => "admin.php?page=" . $current_panel->parent_file . "&p=delete&id="
            )
                )
        );
    }

    public function edit() {

        $data = $this->model->__select('latitude_manara_business_locator', array('latitude_id' =>
            isset($_GET['id']) ? $_GET['id'] :
                    (isset($_POST['latitude_id']) ? $_POST['latitude_id'] : 0 )));

        if (isset($_POST['postcode']) && !is_null($_POST['postcode']) && $data->postcode != $_POST['postcode']) {
            $search = $this->getLatitude($_POST['postcode']);

            $data->longitude = $search['longitude'];
            $_POST['longitude'] = $search['longitude'];
            $data->latitude = $search['latitude'];
            $_POST['latitude'] = $search['latitude'];
            $data->country = $search['country'];
            $_POST['country'] = $search['country'];
            $data->county = $search['county'];
            $_POST['county'] = $search['county'];
            $data->postcode = $search['postcode'];
            $_POST['postcode'] = $search['postcode'];
            $data->data = $search['date'];
            $_POST['data'] = $search['date'];

            $this->model->__save('latitude_manara_business_locator', $_POST);

            $data = $this->model->__select('latitude_manara_business_locator', array('latitude_id' =>
                isset($_GET['id']) ? $_GET['id'] :
                        (isset($_POST['latitude_id']) ? $_POST['latitude_id'] : 0 )));
        } elseif (isset($_POST['postcode']) && !is_null($_POST['postcode'])) {
            $this->model->__save('latitude_manara_business_locator', $_POST);

            $data = $this->model->__select('latitude_manara_business_locator', array('latitude_id' =>
                isset($_GET['id']) ? $_GET['id'] :
                        (isset($_POST['latitude_id']) ? $_POST['latitude_id'] : 0 )));
        }

        $this->view->render('edit_retailer.html.twig'
                , array('menu' => $this->menuBuilderAdmin(), 'data' => $data)
        );
    }

    public function delete() {

        $data = $this->model->__select('latitude_manara_business_locator', array('latitude_id' =>
            isset($_GET['id']) ? $_GET['id'] :
                    (isset($_POST['latitude_id']) ? $_POST['latitude_id'] : 0 )));

        if (isset($_POST['latitude_id'])) {
            $this->model->__delete('latitude_manara_business_locator', array('latitude_id' => isset($_POST['latitude_id']) ? $_POST['latitude_id'] : 0));

            $this->redirect('_list');
        }

        $this->view->render('delete_retailer.html.twig'
                , array('menu' => $this->menuBuilderAdmin(), 'data' => $data)
        );
    }

    /**
     * KEY 
     */
    public function key() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['settings_id'])) {
                $data['settings_id'] = $_POST['settings_id'];
            }

            $data['key'] = $_POST['google_key'];
            $data['data'] = date('Y-m-d');

            $this->model->__save('setting_manara_business_locator', $data);
        }


        $get_key = $this->model->__select('setting_manara_business_locator');
        $this->view->render('add_google_key.html.twig'
                , array('menu' => $this->menuBuilderAdmin(), 'data' => $get_key)
        );
    }

    protected function getLatitude($post_code) {
        $latitude = new Latitude();

        $get_key = $this->model->__select('setting_manara_business_locator');
        return $latitude->googleLatitude($post_code, isset($get_key->key) ? $get_key->key : null );
    }

    public function menuBuilderAdmin() {

        $current_panel = get_current_screen();

        return array(
            array('url' => "admin.php?page=" . $current_panel->parent_file, 'icon' => 'fa fa-tachometer', 'name' => 'Dashboard'),
            array('url' => "admin.php?page=" . $current_panel->parent_file . "&p=key", 'icon' => 'fa fa-key', 'name' => 'Add Google Key'),
            array('url' => "admin.php?page=" . $current_panel->parent_file . "&p=add", 'icon' => 'fa fa-plus-square', 'name' => 'Add new Retailers'),
            array('url' => "admin.php?page=" . $current_panel->parent_file . "&p=_list", 'icon' => 'fa fa-th-list', 'name' => 'List new Retailers'),
        );
    }

    public function redirect($page) {
        $current_panel = get_current_screen();
        wp_redirect("admin.php?page=" . $current_panel->parent_file . "&p={$page}");
    }

}
