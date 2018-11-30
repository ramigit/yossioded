CREATE TABLE wp_attachment_extra_fields (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `field-label` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
        `slug` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
        `input-type` int(5) DEFAULT NULL,
        `help-text` text CHARACTER SET utf8,
        `ordering` int(10) DEFAULT '0',
        `required` tinyint(1) DEFAULT '0',
        `enabled` tinyint(1) DEFAULT '0',
        PRIMARY KEY (`id`)
        );
