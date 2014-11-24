<?php

/**
 * Sample Yandex.Market Yml generator
 */

class MyYmlGenerator extends YmlGenerator {
    
    protected function shopInfo() {
        return array(
            'name'=>'Вася',
            'company'=>'Петя',
            'url'=> Yii::app()->getRequest()->getBaseUrl(true),
//            'platform'=>'',
//            'version'=>'',
//            'agency'=>'',
//            'email'=>''
      );
    }
    
    protected function currencies() {
        $currencies = array(
            array(
                'id'    => 'RUR',
                'rate'  => 1
            )
        );
        foreach($currencies as $currecy) {
            $this->addCurrency($currecy['id'], $currecy['rate']);
        }
    }
    
    protected function categories() {
        $categories = Category::model()->published()->findAll();
        foreach($categories as $category) {
            $this->addCategory($category->name, $category->id, $category->parent_id);
        }  
    }
    
    protected function offers() {
        $offers = Offer::model()->published()->findAll();
        foreach($offers as $offer) {
            $this->addOffer(
                $offer->id,
                array(
                    'url' => $offer->getUrl(),
                    'price' => $offer->price,
                    'currencyId' => 'RUR',
                    'categoryId' => $offer->good->category_id,
                    'name' => $offer->name,
                    'description' => strip_tags($offer->description)
                )
            );
        }
    }
}
