<?php

namespace exchange\classes;

/**
 * 
 *
 * @author kolia
 */
class Prices extends ExchangeBase {

    protected function import_() {
        $data = array();
        $i = 0;
        foreach ($this->importData as $offer) {
            $data[$i]['price'] = str_replace(',', '.', (string) $offer->Цены->Цена->ЦенаЗаЕдиницу);
            $data[$i]['price_in_main'] = str_replace(',', '.', (string) $offer->Цены->Цена->ЦенаЗаЕдиницу);
            
            if (property_exists($offer, 'Количество')) {
                $data[$i]['stock'] = (int) $offer->Количество;
            }
            
            $data[$i]['external_id'] = (string) $offer->Ид;

            $i++;
        }
        $this->updateBatch('shop_product_variants', $data, 'external_id');
    }

}
