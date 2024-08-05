/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     12/25/2023 9:37:23 AM                        */
/*==============================================================*/

drop table if exists ADMIN;

drop table if exists CROP;

drop table if exists FARMER;

drop table if exists HAS;

drop table if exists LAND;

drop table if exists PLANTS;

drop table if exists REGION;

/*==============================================================*/
/* Table: CROP                                                  */
/*==============================================================*/
create table CROP
(
   CID                  int not null auto_increment,
   CNAME                varchar(100) not null,
   CDESC                text,
   CPLANTSEASON         varchar(200) not null,
   CHARVESTSEASON       varchar(200) not null,
   WATER_INTAKE         int not null,
   primary key (CID)
);

/*==============================================================*/
/* Table: FARMER                                                */
/*==============================================================*/
create table FARMER
(
   FID                  int not null auto_increment,
   FFIRSTNAME           varchar(50) not null,
   FLASTNAME            varchar(50) not null,
   FUSERNAME            varchar(50) not null,
   FPASSWORD            varchar(255) not null,
   FEMAIL               varchar(100) not null,
   FDATEOFBIRTH         date not null,
   FGENDER              varchar(6) not null,
   FPHONE               varchar(20),
   FADDRESS             varchar(100),
   primary key (FID)
);

/*==============================================================*/
/* Table: RECENTLY_HARVESTED                                                   */
/*==============================================================*/
CREATE TABLE RECENTLY_HARVESTED (
    RHID INT AUTO_INCREMENT PRIMARY KEY,
    CID INT NOT NULL,
    CNAME VARCHAR(100) NOT NULL,
    HarvestDate DATE NOT NULL
);

/*==============================================================*/
/* Table: HAS                                                   */
/*==============================================================*/
create table HAS
(
   LID                  int not null,
   CID                  int not null,
   HSEASON              int,
   HDURATION            int,
   primary key (LID, CID)
);

/*==============================================================*/
/* Table: LAND                                                  */
/*==============================================================*/
create table LAND
(
   LID                  int not null auto_increment,
   RID                  int not null,
   LNUMBER              varchar(50) not null,
   LSIZE                decimal not null,
   LSOILTYPE            varchar(100),
   LWATER               decimal,
   WATER_AVAILABLE      int not null,
   LDESC                char(10),
   LNAME                varchar(50),
   primary key (LID)
);

INSERT INTO `LAND` (`LID`, `RID`, `LNUMBER`, `LSIZE`, `LSOILTYPE`, `LWATER`, `LDESC`) VALUES
(1, 1, 'CA123', 150, 'Sandy Loam', 60, 'Coastal'),
(2, 2, 'NY456', 121, 'Clay', 46, 'Rural'),
(3, 3, 'TX789', 200, 'Black Soil', 76, 'Fertile'),
(4, 4, 'FL101', 181, 'Silt', 55, 'Everglades'),
(5, 5, 'IL202', 91, 'Loamy Sand', 40, 'Prairie'),
(6, 6, 'AZ303', 250, 'Red Clay', 80, 'Desert'),
(7, 7, 'CO404', 131, 'Rocky', 70, 'Mountainou'),
(8, 8, 'WA505', 175, 'Peat', 66, 'Forest'),
(9, 9, 'GA606', 160, 'Chalky', 56, 'Plantation'),
(10, 10, 'OH707', 110, 'Limestone', 50, 'Rolling Hi');

/*==============================================================*/
/* Table: PLANTS                                                */
/*==============================================================*/
create table PLANTS
(
   FID                  int not null,
   LID                  int not null,
   primary key (FID, LID)
);

/*==============================================================*/
/* Table: WORKERS                                                */
/*==============================================================*/
CREATE TABLE WORKER (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(50) NOT NULL,
    LASTNAME VARCHAR(50) NOT NULL,
    USERNAME VARCHAR(50) NOT NULL UNIQUE,
    PASSWORD VARCHAR(255) NOT NULL,
    FID INT,
    FOREIGN KEY (FID) REFERENCES USERS(FID)
);

/*==============================================================*/
/* Table: REGION                                                */
/*==============================================================*/
create table REGION
(
   RID                  int not null auto_increment,
   RSTATE               varchar(255) not null,
   RADDRESS             varchar(255) not null,
   RTEMP                int,
   RHUMIDITY            decimal,
   primary key (RID)
);

INSERT INTO `REGION` (`RID`, `RSTATE`, `RADDRESS`, `RTEMP`, `RHUMIDITY`) VALUES
(1, 'California', '123 Main St, Los Angeles, CA', 75, 51),
(2, 'New York', '456 Broadway, New York, NY', 68, 65),
(3, 'Texas', '789 Oak St, Houston, TX', 82, 56),
(4, 'Florida', '101 Palm St, Miami, FL', 88, 70),
(5, 'Illinois', '202 Maple St, Chicago, IL', 72, 45),
(6, 'Arizona', '303 Pine St, Phoenix, AZ', 95, 31),
(7, 'Colorado', '404 Cedar St, Denver, CO', 78, 41),
(8, 'Washington', '505 Spruce St, Seattle, WA', 65, 60),
(9, 'Georgia', '606 Birch St, Atlanta, GA', 80, 56),
(10, 'Ohio', '707 Elm St, Columbus, OH', 70, 49);

alter table HAS add constraint FK_HAS foreign key (LID)
      references LAND (LID) on delete restrict on update restrict;

alter table HAS add constraint FK_HAS2 foreign key (CID)
      references CROP (CID) on delete restrict on update restrict;

alter table LAND add constraint FK_LOCATEDIN foreign key (RID)
      references REGION (RID) on delete restrict on update restrict;

alter table PLANTS add constraint FK_PLANTS foreign key (FID)
      references FARMER (FID) on delete restrict on update restrict;

alter table PLANTS add constraint FK_PLANTS2 foreign key (LID)
      references LAND (LID) on delete restrict on update restrict;
