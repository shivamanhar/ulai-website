<?php

use Propel\Runtime\ActiveQuery\Criteria;

class SBrandsHelper {

    /**
     * Returns an array of brands ordering by total products in brand
     *
     * @param int $limit Limit of returned brands
     * @return an array of brands sorted by totalProducts in brand with brand fields name, url, total and brand model
     */
    public static function mostProductBrands($limit = 6, $withImages = FALSE) {
        $total_in_brand = $tmp = Array();

        $model = SBrandsQuery::create();
        if ($withImages)
            $model = $model->where('SBrands.Image IS NOT NULL');
        $model = $model
                ->joinWithI18n(MY_Controller::getCurrentLocale())
                ->orderByPosition()
                ->find();

        foreach ($model as $brand) {
            $total_in_brand[$brand->getId()]['name'] = $brand->getName();
            $total_in_brand[$brand->getId()]['url'] = $brand->getUrl();
            $total_in_brand[$brand->getId()]['full_url'] = 'brand/' . $brand->getUrl();
            $total_in_brand[$brand->getId()]['img_fullpath'] = '/uploads/shop/brands/' . $brand->getImage();
            $total_in_brand[$brand->getId()]['total'] = SProductsQuery::create()->filterByBrandId($brand->getId())->distinct()->filterByActive(true)->count();
            $total_in_brand[$brand->getId()]['model'] = $brand;
        }

        foreach ($total_in_brand as &$ma) {
            $tmp[] = &$ma['total'];
        }

        //array_multisort($tmp, SORT_ASC, $total_in_brand);

        return array_slice($total_in_brand, 0, $limit);
    }

    public static function getBrandsCharaters($hasBrand = false, $lang = array('EN')) {
        $total_in_brand = array();
        if (!$hasBrand) {

            if (in_array("EN", $lang)) {
                for ($i = 65; $i <= 90; $i++) {
                    $total_in_brand[mb_convert_case(iconv("CP1251", "UTF-8", chr($i)), MB_CASE_UPPER)] = array();
                }
            }

            if (in_array("UA", $lang)) {

                for ($i = 192; $i <= 223; $i++) {
                    $total_in_brand[mb_convert_case(iconv("CP1251", "UTF-8", chr($i)), MB_CASE_UPPER)] = array();

                    if ($i == 195)
                        $total_in_brand[mb_convert_case(iconv("CP1251", "UTF-8", chr(165)), MB_CASE_UPPER)] = array();
                    if ($i == 197)
                        $total_in_brand[mb_convert_case(iconv("CP1251", "UTF-8", chr(170)), MB_CASE_UPPER)] = array();
                    if ($i == 200) {
                        $total_in_brand[mb_convert_case(iconv("CP1251", "UTF-8", chr(178)), MB_CASE_UPPER)] = array();
                        $total_in_brand[mb_convert_case(iconv("CP1251", "UTF-8", chr(175)), MB_CASE_UPPER)] = array();
                    }
                }
                if (!in_array("RU", $lang)) {
                    unset($total_in_brand[mb_convert_case(iconv("CP1251", "UTF-8", chr(218)), MB_CASE_UPPER)]);
                    unset($total_in_brand[mb_convert_case(iconv("CP1251", "UTF-8", chr(219)), MB_CASE_UPPER)]);
                    unset($total_in_brand[mb_convert_case(iconv("CP1251", "UTF-8", chr(221)), MB_CASE_UPPER)]);
                }
            }
            if (in_array("RU", $lang) && !in_array("UA", $lang)) {

                for ($i = 192; $i <= 223; $i++) {
                    $total_in_brand[mb_convert_case(iconv("CP1251", "UTF-8", chr($i)), MB_CASE_UPPER)] = array();
                }
            }
        }

        foreach (SBrandsQuery::create()->joinWithI18n(MY_Controller::getCurrentLocale())->orderBy('SBrandsI18n.Name', Criteria::ASC)->find() as $brand) {
            $total_in_brand[mb_convert_case(mb_substr($brand->getName(), 0, 1), MB_CASE_UPPER)][$brand->getId()]['name'] = $brand->getName();
            $total_in_brand[mb_convert_case(mb_substr($brand->getName(), 0, 1), MB_CASE_UPPER)][$brand->getId()]['url'] = $brand->getUrl();
            $total_in_brand[mb_convert_case(mb_substr($brand->getName(), 0, 1), MB_CASE_UPPER)][$brand->getId()]['total'] = SProductsQuery::create()
                    ->joinWithI18n(MY_Controller::getCurrentLocale())
                    ->filterByBrandId($brand->getId())
                    ->distinct()
                    ->filterByActive(true)
                    ->count();
            $total_in_brand[mb_convert_case(mb_substr($brand->getName(), 0, 1), MB_CASE_UPPER)][$brand->getId()]['model'] = $brand;
        }

        return $total_in_brand;
    }

}

/* End of file SBrandsHelper.php */