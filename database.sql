/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 10.4.11-MariaDB : Database - e_learning_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`e_learning_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `e_learning_db`;

/*Table structure for table `app_user` */

DROP TABLE IF EXISTS `app_user`;

CREATE TABLE `app_user` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT 1,
  `is_admin` int(1) NOT NULL DEFAULT 0,
  `user_password` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `registered_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `app_user` */

insert  into `app_user`(`id`,`status`,`is_admin`,`user_password`,`email`,`full_name`,`registered_on`) values 
(1,1,1,'787f04d4569019803dfb6ab702ab7f26d86969da242628aed42d8a89775fbba34400a1520fd2dcc9a91370735261e93118f0aa58739581bf3bcbb50390d05cb4XGhVM2ALAff0L6jrJK1827w/hbCwTN9eMgl0WeMeQ84=','admin@mail.com','Parvej Ahmed Ahmed','2020-09-24 13:34:14'),
(2,1,0,'1a2b223e73774315c7f5bb2dfe8aa3f75a8332c04a0fcae47d1745f8af5d48395a42b8702646a832f659b5e54010c5516ee8bb934bc57245a5c9fae69c20ccb29jgVaCri2uZ8jkVzpIooYoHu0NmuGHEbZPFqcHt7x08=','user1@mail.com','User 1','2020-09-24 14:13:17'),
(3,1,0,'a1734e1caf3cc66b4786ead575c608cb08b433c8da225a4489309064d68c8824b0b791bba109fca51a806c7eea1c81bc3929d9c1cc579db65c288c74d0324e65I0clwoGrh/D3z5b6ovOEN0bXUQQSVp78G5prJLubqtg=','user2@mail.com','User 2','2020-09-24 14:14:03');

/*Table structure for table `course` */

DROP TABLE IF EXISTS `course`;

CREATE TABLE `course` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `course` */

insert  into `course`(`id`,`name`,`status`) values 
(1,'Java Basic',1),
(2,'PHP Basic',1),
(3,'HTML Basic',1),
(4,'Dot Net Basic',1),
(5,'Spring Boot',1),
(6,'Codeigniter Framework',1);

/*Table structure for table `evaluation_report` */

DROP TABLE IF EXISTS `evaluation_report`;

CREATE TABLE `evaluation_report` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `app_user_id` bigint(10) NOT NULL DEFAULT 0,
  `given_answer` varchar(1000) NOT NULL,
  `exam_date` datetime NOT NULL,
  `course_id` bigint(10) NOT NULL DEFAULT 0,
  `lesson_id` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `evaluation_report` */

/*Table structure for table `lesson` */

DROP TABLE IF EXISTS `lesson`;

CREATE TABLE `lesson` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `course_id` bigint(10) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `lesson_course_id_idx` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `lesson` */

insert  into `lesson`(`id`,`name`,`course_id`,`status`) values 
(1,'Concepts of OOPs',1,1),
(2,'Character and Boolean Data Types',1,1),
(3,'Data Structures',1,1);

/*Table structure for table `questionnaire` */

DROP TABLE IF EXISTS `questionnaire`;

CREATE TABLE `questionnaire` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `course_id` bigint(10) NOT NULL DEFAULT 0,
  `lesson_id` bigint(10) NOT NULL DEFAULT 0,
  `right_answer` int(1) NOT NULL DEFAULT 0,
  `title` varchar(500) DEFAULT NULL,
  `answer_1` varchar(500) NOT NULL,
  `answer_2` varchar(500) NOT NULL,
  `answer_3` varchar(500) NOT NULL,
  `answer_4` varchar(500) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `questionnaire_course_id_idx` (`course_id`),
  KEY `questionnaire_lesson_id_idx` (`lesson_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `questionnaire` */

insert  into `questionnaire`(`id`,`course_id`,`lesson_id`,`right_answer`,`title`,`answer_1`,`answer_2`,`answer_3`,`answer_4`,`status`) values 
(1,1,1,4,'Which of the following is not OOPS concept in Java?','Inheritance','Encapsulation','Polymorphism','Inheritance',1),
(2,1,1,4,'What is it called if an object has its own lifecycle and there is no owner?','Aggregation','Composition','Encapsulation','Association',1),
(3,1,1,3,'Which concept of Java is a way of converting real world objects in terms of class?','Polymorphism','Encapsulation','Abstraction','Inheritance',1),
(4,1,1,1,'Which of these values can a boolean variable contain?','True & False','0 & 1','Any integer value','true',1),
(5,1,1,1,'Which one is a valid declaration of a boolean?','boolean b1 = 1;','boolean b1 = \"false\";','boolean b1 = false;','boolean b1 = \"true\";',1),
(6,1,1,1,'Which of these is used to perform all input & output operations in Java?','streams','Variables','classes','Methods',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
