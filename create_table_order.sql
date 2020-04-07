CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '注文ID',
  `name` varchar(255) DEFAULT NULL COMMENT '名前',
  `email` varchar(255) DEFAULT NULL COMMENT 'メールアドレス',
  `food`varchar(255) DEFAULT NULL COMMENT '商品',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
