<?php

namespace Manara\Business\locator\Application\lib;

use Manara\Business\locator\Application\lib\Admin;
use Manara\Business\locator\Application\lib\CustomQuery;

/**
 * Description of display
 *
 * @author rodrigo
 */
class display extends Admin {

    private $db_custom;
    private $get;

    public function __construct() {
        parent::__construct();

        $this->db_custom = new CustomQuery();
        $this->get = $_REQUEST;
    }

    private $attribute;
    private $contents;
    private $type = 'miles';
    private $min = '0';
    private $max = '50';

    public function getPanelDisplay($attrs, $content) {

        $this->setAttributes($attrs)
                ->setContents($content)
                ->setType()
                ->setMax()
                ->setMin()
                ->getTemplate();
    }

    public function getTemplate() {
        $key = $this->db_custom->__select('setting_manara_business_locator');
        
        $this->view->render('public_search_display.html.twig', array(
            'data' => $this->getConfig(),
            'item' => $key,
            'post' => array(
                'postcode' => $this->post('postcode'),
                'distance' => $this->post('distance') ,
                ),
            'retailers' => $this->setReturnListofRetailers()
        ));
    }

    private function setReturnListofRetailers() {

        $data = $this->getLatitude($this->post('postcode'));
 
        if (!is_null($this->post('postcode'))) {
            return $this->db_custom->__selects('latitude_manara_business_locator');
        } else {
             
            return $this->db_custom->getListofRetailers(array(
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'distance' => $this->post('distance')
                    )
            );
        }
    }

    private function getConfig() {

        return array(
            'min' => $this->min,
            'max' => $this->max,
            'type' => $this->type,
            'text' => $this->contents,
        );
    }

    /**
     * 
     * @param array $attr
     * @return \Manara\Business\locator\Application\lib\display
     */
    private function setAttributes($attr) {
        $this->attribute = $attr;
        return $this;
    }

    /**
     * 
     * @param type $content
     * @return \Manara\Business\locator\Application\lib\display
     */
    private function setContents($content = null) {
        $this->contents = $content;
        return $this;
    }

    /**
     * 
     * @return \Manara\Business\locator\Application\lib\display
     */
    private function setType() {
        $this->type = 
                isset($this->attribute['type']) ? sanitize_text_field($this->attribute['type']) : $this->type;
        return $this;
    }

    /**
     * 
     * @return \Manara\Business\locator\Application\lib\display
     */
    private function setMin() {
        $this->min = isset($this->attribute['min']) 
                ? sanitize_text_field($this->attribute['min']) : $this->min;
        return $this;
    }

    private function setMax() {
        $this->max = isset($this->attribute['max']) 
                ? sanitize_text_field($this->attribute['max']) : $this->max;
        return $this;
    }

}
