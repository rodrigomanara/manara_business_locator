<?php

namespace Manara\Business\locator\Application\lib;

use Manara\Business\locator\Application\lib\loadFile;
use Manara\Business\locator\Application\lib\Model;
use Manara\Business\locator\Application\Helpers\Sanitizer\__Global as GlobalsRequest;

class Admin extends GlobalsRequest {

    protected $view;
    protected $model;

    public function __construct() {
        parent::__construct();

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
        $post_code = $this->post('postcode'); //isset($_POST['postcode']) ? $_POST['postcode'] : null;
        $data = $this->getLatitude($post_code);

        if (!is_null($this->post('name'))) {
            $this->model->__save('latitude_manara_business_locator', $this->post());
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

        if (!is_null($this->get('id'))) {
            $id = array('latitude_id' => $this->get('id'));
        } elseif (!is_null($this->post('latitude_id'))) {
            $id =  array('latitude_id' => $this->post('latitude_id'));
        } else {
            $id = array('latitude_id' => 0);
        }


        $data = $this->model->__select('latitude_manara_business_locator' ,$id);


        if (!is_null($this->post('postcode')) && $data->postcode != $this->post('postcode')) {
            $search = $this->getLatitude($this->post('postcode'));

            $data->longitude = $search['longitude'];
            $this->setPost('longitude', $search['longitude']);
            $data->latitude = $search['latitude'];
            $this->setPost('latitude', $search['latitude']);
            $data->country = $search['country'];
            $this->setPost('country', $search['country']);
            $data->county = $search['county'];
            $this->setPost('county', $search['county']);
            $data->postcode = $search['postcode'];
            $this->setPost('postcode', $search['postcode']);
            $data->data = $search['date'];
            $this->setPost('data', $search['date']);

            $this->model->__save('latitude_manara_business_locator', $this->post());

            $data = $this->model->__select('latitude_manara_business_locator' , $id);
        
            
        } elseif (!is_null($this->post('postcode'))) {
        
            $this->model->__save('latitude_manara_business_locator', $this->post());
            $data = $this->model->__select('latitude_manara_business_locator' , $id);
        }

        $this->view->render('edit_retailer.html.twig'
                , array('menu' => $this->menuBuilderAdmin(), 'data' => $data)
        );
    }

    public function delete() {

        if (!is_null($this->get('id'))) {
            $id = array('latitude_id' => $this->get('id'));
        } elseif (!is_null($this->post('latitude_id'))) {
            $id = array('latitude_id' => $this->post('latitude_id'));
        } else {
            $id = array('latitude_id' => 0);
        }
        
        $data = $this->model->__select('latitude_manara_business_locator' , $id);
        
        if (!is_null($this->post('latitude_id'))) {
            $this->model->__delete('latitude_manara_business_locator' , $id);
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

        if (!is_null($this->post('settings_id'))) {
            $data['settings_id'] = $this->post('settings_id');


            $data['key'] = $this->post('google_key');
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
