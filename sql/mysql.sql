#
# Table structure for table `xent_gen_users`
#

CREATE TABLE `xent_gen_users` (
    `ID_USER`        INT(5)       NOT NULL DEFAULT '0',
    `id_job`         INT(5)       NOT NULL DEFAULT '0',
    `id_typeposte`   INT(5)       NOT NULL DEFAULT '0',
    `id_location`    INT(5)       NOT NULL DEFAULT '0',
    `id_title`       INT(5)       NOT NULL DEFAULT '0',
    `pictpro`        VARCHAR(255) NOT NULL DEFAULT '',
    `priority`       INT(5)       NOT NULL DEFAULT '0',
    `career_summary` TEXT         NOT NULL,
    PRIMARY KEY (`ID_USER`),
    UNIQUE KEY `ID_USER_2` (`ID_USER`),
    KEY `ID_USER` (`ID_USER`)
)
    ENGINE = ISAM;

#
# Dumping data for table `xent_gen_users`
#

#
# Table structure for table `xent_gen_titles`
#

CREATE TABLE `xent_gen_titles` (
    `ID_TITLE` INT(5)       NOT NULL AUTO_INCREMENT,
    `title`    VARCHAR(255) NOT NULL DEFAULT '',
    KEY `ID_TITLE` (`ID_TITLE`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 3;

#
# Dumping data for table `xent_gen_titles`
#

#
# Table structure for table `xent_gen_jobs`
#

CREATE TABLE `xent_gen_jobs` (
    `ID_JOB`      INT(5)       NOT NULL AUTO_INCREMENT,
    `job`         VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT         NOT NULL,
    KEY `ID_TITLE` (`ID_JOB`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 4;

#
# Dumping data for table `xent_gen_jobs`
#

# 
# Table structure for table `xent_gen_locations`
# 

CREATE TABLE `xent_gen_locations` (
    `ID_LOCATION` INT(5)       NOT NULL AUTO_INCREMENT,
    `address`     VARCHAR(255) NOT NULL DEFAULT '',
    `city`        VARCHAR(255) NOT NULL DEFAULT '',
    `state`       VARCHAR(255) NOT NULL DEFAULT '',
    `country`     VARCHAR(255) NOT NULL DEFAULT '',
    `zipcode`     VARCHAR(255) NOT NULL DEFAULT '',
    KEY `ID_LOCATION` (`ID_LOCATION`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 9;

# 
# Dumping data for table `xent_gen_locations`
# 

# 
# Table structure for table `xent_gen_typeposte`
# 

CREATE TABLE `xent_gen_typeposte` (
    `ID_TYPEPOSTE` INT(5)       NOT NULL AUTO_INCREMENT,
    `typeposte`    VARCHAR(255) NOT NULL DEFAULT '',
    KEY `ID_TYPEPOSTE` (`ID_TYPEPOSTE`)
)
    ENGINE = ISAM
    AUTO_INCREMENT = 6;

# 
# Dumping data for table `xent_gen_typeposte`
# 

INSERT INTO `xent_gen_typeposte`
VALUES (1, 'Permanent');
INSERT INTO `xent_gen_typeposte`
VALUES (2, 'Temporaire');
INSERT INTO `xent_gen_typeposte`
VALUES (3, 'Temps partiel');
INSERT INTO `xent_gen_typeposte`
VALUES (4, 'À contrat');
INSERT INTO `xent_gen_typeposte`
VALUES (5, 'Consultant');
