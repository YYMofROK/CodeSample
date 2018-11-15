###################################################################
#
# @ 지정된 DB 안에 모든 테이블 삭제 처리
#
###################################################################

SET @tables = NULL;
	SELECT GROUP_CONCAT(table_schema, '.', table_name) INTO @tables
	FROM information_schema.tables 
	WHERE table_schema = '[TARGET DB NAME]'; -- specify DB name here.
SET @tables = CONCAT('DROP TABLE ', @tables);
PREPARE stmt FROM @tables;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
