--
-- Set character set the client will use to send SQL statements to the server
--
SET NAMES 'utf8';

--
-- Set default database
--
USE sellerate;

--
-- Drop table `migration`
--
DROP TABLE IF EXISTS migration;

--
-- Drop table `user`
--
DROP TABLE IF EXISTS user;

--
-- Drop table `rate`
--
DROP TABLE IF EXISTS rate;

--
-- Drop table `cash_desk`
--
DROP TABLE IF EXISTS cash_desk;

--
-- Drop table `employee`
--
DROP TABLE IF EXISTS employee;

--
-- Set default database
--
USE sellerate;

--
-- Create table `employee`
--
CREATE TABLE employee (
  id INT(11) NOT NULL AUTO_INCREMENT,
  last_name VARCHAR(255) DEFAULT NULL,
  first_name VARCHAR(255) DEFAULT NULL,
  middle_name VARCHAR(255) DEFAULT NULL,
  photo VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Create table `cash_desk`
--
CREATE TABLE cash_desk (
  id INT(11) NOT NULL AUTO_INCREMENT,
  desk_number VARCHAR(255) NOT NULL,
  description VARCHAR(255) DEFAULT NULL,
  date_add DATETIME NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Create index `UK_cash_desk_desk_number` on table `cash_desk`
--
ALTER TABLE cash_desk
  ADD UNIQUE INDEX UK_cash_desk_desk_number(desk_number);

DELIMITER $$

--
-- Create trigger `insert_date_add`
--
CREATE
TRIGGER insert_date_add
	BEFORE INSERT
	ON cash_desk
	FOR EACH ROW
BEGIN
  SET NEW.date_add = NOW();
END
$$

DELIMITER ;

--
-- Create table `rate`
--
CREATE TABLE rate (
  id INT(11) NOT NULL AUTO_INCREMENT,
  employee_id INT(11) NOT NULL,
  desk_number VARCHAR(255) NOT NULL,
  check_number VARCHAR(255) NOT NULL,
  total DECIMAL(10, 2) DEFAULT NULL,
  date_purchase DATETIME DEFAULT NULL,
  date_add DATETIME DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Create index `UK_rate` on table `rate`
--
ALTER TABLE rate
  ADD UNIQUE INDEX UK_rate(desk_number, check_number);

DELIMITER $$

--
-- Create trigger `insert_rate_date_add`
--
CREATE
TRIGGER insert_rate_date_add
	BEFORE INSERT
	ON rate
	FOR EACH ROW
BEGIN
  SET NEW.date_add = NOW();
END
$$

DELIMITER ;

--
-- Create foreign key
--
ALTER TABLE rate
  ADD CONSTRAINT FK_rate_desk_number FOREIGN KEY (desk_number)
    REFERENCES cash_desk(desk_number) ON DELETE NO ACTION;

--
-- Create foreign key
--
ALTER TABLE rate
  ADD CONSTRAINT FK_rate_employee_id FOREIGN KEY (employee_id)
    REFERENCES employee(id) ON DELETE NO ACTION;

--
-- Create table `user`
--
CREATE TABLE user (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role INT(11) NOT NULL,
  full_name VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;

--
-- Create table `migration`
--
CREATE TABLE migration (
  version VARCHAR(180) NOT NULL,
  apply_time INT(11) DEFAULT NULL,
  PRIMARY KEY (version)
)
ENGINE = INNODB,
CHARACTER SET utf8,
COLLATE utf8_general_ci;