ALTER TABLE `shop_gifts` CHANGE `key` `gift_key` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `shop_orders` CHANGE `key` `order_key` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
