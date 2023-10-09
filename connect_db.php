<?php
//ไฟล์นี้ใช้เป็นไฟล์กลางในการติดต่อกับ Database ดั้งนั้นจึงจะใช้ร่วมกับทุก API
class ConnectDB
{
    //ประกาศตัวแปรที่เก็บค่าต่างๆ เกี่ยวกับ Server และ Database
    private $host = "localhost";    //ใช้งานจริงให้แก้เป็น IP Address หรือ Domain Name
    private $username = "root";     //คือ username ที่เข้าใช้งาน Database
    private $password = "";         //คือ password ที่เข้าใช้งาน Database
    private $dbName = "sau_coffee_db";  //คือชื่อ Database อย่าลืมตรวจสอบให้ถูกต้อง เมื่อใช้งานจริง

    //ประกาศตัวแปรเก็บค่าการ Connect ไปยัง Server และ Database
    private $connDB;

    //ประกาศฟังก์ชันที่ใช้ในการ Connect ไปยัง Server และ Database
    public function getConnectDB()
    {
        try {
            $this->connDB = new PDO(
                "mysql:host=".$this->host.";dbname=".$this->dbName,$this->username,$this->password
            );

            $this->connDB->exec("set name utf");
        } catch (PDOException $ex) {
        }

        return $this->connDB;
    }
}
