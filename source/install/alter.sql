
ALTER TABLE `qoacy`.`question` 
CHANGE COLUMN `created` `created` TIMESTAMP NOT NULL ;
ALTER TABLE `qoacy`.`answer` 
ADD COLUMN `good_count` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `created`,
ADD COLUMN `bad_count` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `good_count`;
